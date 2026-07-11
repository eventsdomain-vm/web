<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Services\EventImportService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ImportSponsorshipSearchJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $timeout = 300;

    public function handle(EventImportService $importer): void
    {
        Log::info('Starting sponsorshipsearch.com import...');

        $stats = $importer->import();

        Log::info('Import completed', $stats);
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('ImportSponsorshipSearchJob failed', [
            'message' => $exception->getMessage(),
        ]);
    }
}
