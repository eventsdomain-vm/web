<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\ActivityLog;
use App\Models\PlatformSetting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DatabaseBackup extends Command
{
    protected $signature = 'backup:run {--disk=} {--database=}';

    protected $description = 'Backup the database and upload to configured storage';

    public function handle(): int
    {
        $diskName = $this->option('disk') ?: PlatformSetting::get('backup_disk', 'local');
        $database = $this->option('database') ?: config('database.connections.mysql.database', 'events_idea');
        $retention = (int) PlatformSetting::get('backup_retention_days', 7);

        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = "backup_{$database}_{$timestamp}.sql";
        $tempPath = storage_path("app/temp/{$filename}");

        Storage::makeDirectory('temp');

        $command = sprintf(
            'mysqldump --user=%s --password=%s --host=%s %s > %s 2>&1',
            escapeshellarg(config('database.connections.mysql.username', 'root')),
            escapeshellarg(config('database.connections.mysql.password', '')),
            escapeshellarg(config('database.connections.mysql.host', '127.0.0.1')),
            escapeshellarg($database),
            escapeshellarg($tempPath)
        );

        $this->info("Running: mysqldump for {$database}");
        exec($command, $output, $exitCode);

        if ($exitCode !== 0 || ! file_exists($tempPath)) {
            $this->error('Backup failed: mysqldump returned exit code '.$exitCode);
            ActivityLog::log('backup_failed', "Database backup failed for {$database}");

            return Command::FAILURE;
        }

        $size = filesize($tempPath);
        $disk = Storage::disk($diskName);

        if (! $disk->put("backups/{$filename}", file_get_contents($tempPath))) {
            $this->error('Failed to upload backup to '.$diskName);
            unlink($tempPath);

            return Command::FAILURE;
        }

        unlink($tempPath);

        $this->info("Backup saved: backups/{$filename} ({$this->formatBytes($size)}) on disk [{$diskName}]");
        ActivityLog::log('backup_completed', "Database backup created: {$filename} ({$this->formatBytes($size)}) on {$diskName}");

        $this->pruneOldBackups($disk, $retention);

        return Command::SUCCESS;
    }

    private function pruneOldBackups($disk, int $retentionDays): void
    {
        $cutoff = now()->subDays($retentionDays);
        $files = $disk->files('backups');

        foreach ($files as $file) {
            $timestamp = $disk->lastModified($file);
            if ($timestamp && $timestamp < $cutoff->timestamp) {
                $disk->delete($file);
                $this->info("Pruned old backup: {$file}");
            }
        }
    }

    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, 2).' '.$units[$i];
    }
}
