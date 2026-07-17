<#
.SYNOPSIS
Deploy the current Laravel workspace to Hostinger over SSH.

.DESCRIPTION
Builds the app locally (optional), packages the workspace, uploads it to Hostinger,
and extracts the files into /domains/eventsdomain.com/public_html.

.PARAMETER Host
SSH host.
.PARAMETER Port
SSH port.
.PARAMETER User
SSH username.
.PARAMETER RemotePath
Remote destination directory.
.PARAMETER Build
Run composer/npm build before upload.
.PARAMETER DryRun
Show deployment steps without uploading.
#>

param(
    [string]$Host = "82.112.239.2",
    [int]$Port = 65002,
    [string]$User = "u205934545",
    [string]$RemotePath = "/domains/eventsdomain.com/public_html",
    [switch]$Build,
    [switch]$DryRun
)

function Write-Step($message) {
    Write-Host "`n=== $message ===" -ForegroundColor Cyan
}

function Run-Command($command) {
    Write-Host "PS> $command" -ForegroundColor Yellow
    if (-not $DryRun) {
        $result = Invoke-Expression $command
        if ($LASTEXITCODE -ne 0) {
            throw "Command failed with exit code $LASTEXITCODE"
        }
        return $result
    }
}

$archiveName = "hostinger-deploy.zip"
$archivePath = Join-Path $env:TEMP $archiveName

Write-Step "Hostinger deploy settings"
Write-Host "Host: $Host"
Write-Host "Port: $Port"
Write-Host "User: $User"
Write-Host "RemotePath: $RemotePath"
Write-Host "Archive: $archivePath"

if ($Build) {
    Write-Step "Running local build"
    Run-Command "composer install --no-dev --optimize-autoloader"
    Run-Command "npm install"
    Run-Command "npm run build"
}

Write-Step "Packaging current workspace"
Remove-Item -Path $archivePath -ErrorAction SilentlyContinue

$excluded = @(
    '.git',
    '.github',
    '.vscode',
    'node_modules',
    'tests',
    'storage',
    'vendor',
    '.env',
    '.env.*',
    'deploy-hostinger.ps1'
)

$items = Get-ChildItem -Force | Where-Object {
    $name = $_.Name
    $excluded -notcontains $name
}

if ($items.Count -eq 0) {
    throw 'No files found to package. Check your repository contents.'
}

if (-not $DryRun) {
    Compress-Archive -Path $items.FullName -DestinationPath $archivePath -Force
}

Write-Step "Uploading package to remote host"
$remoteTemp = "/tmp/$archiveName"
$scpCommand = "scp -P $Port `"$archivePath`" $User@${Host}:`"$remoteTemp`""
Run-Command $scpCommand

Write-Step "Extracting package on Hostinger"
$sshCommand = "ssh -p $Port $User@${Host} `"mkdir -p '$RemotePath' && cd '$RemotePath' && find . -mindepth 1 -maxdepth 1 -exec rm -rf {} + && unzip -o '$remoteTemp' -d '$RemotePath' && rm -f '$remoteTemp'`""
Run-Command $sshCommand

Write-Step "Deployment complete"
Write-Host "If your remote host requires additional steps, run them manually on the Hostinger server." -ForegroundColor Green
