@echo off
setlocal enabledelayedexpansion

rem Hostinger SSH deployment settings
set "HOST=82.112.239.2"
set "PORT=65002"
set "USER=u205934545"
set "REMOTE_PATH=/domains/eventsdomain.com/public_html"
set "ARCHIVE_NAME=hostinger-deploy.zip"
set "ARCHIVE_PATH=%TEMP%\%ARCHIVE_NAME%"

echo.
echo Creating archive %ARCHIVE_PATH%
powershell -NoProfile -Command "if (Test-Path '%ARCHIVE_PATH%') { Remove-Item -Force '%ARCHIVE_PATH%' }; $exclude = @('.git','.github','.vscode','node_modules','tests','storage','vendor','deploy-hostinger.bat','deploy-hostinger.ps1','.env'); $items = Get-ChildItem -Force | Where-Object { $exclude -notcontains $_.Name }; if (-not $items) { throw 'No files found to archive.' }; Compress-Archive -Path $items.FullName -DestinationPath '%ARCHIVE_PATH%' -Force"
if errorlevel 1 goto error

echo.
echo Uploading archive to %USER%@%HOST%:/tmp/%ARCHIVE_NAME%
scp -P %PORT% "%ARCHIVE_PATH%" %USER%@%HOST%:/tmp/%ARCHIVE_NAME%
if errorlevel 1 goto error

echo.
echo Extracting archive on remote host...
ssh -p %PORT% %USER%@%HOST% "mkdir -p '%REMOTE_PATH%' && cd '%REMOTE_PATH%' && find . -mindepth 1 -maxdepth 1 -exec rm -rf {} + && unzip -o /tmp/%ARCHIVE_NAME% -d '%REMOTE_PATH%' && rm -f /tmp/%ARCHIVE_NAME%"
if errorlevel 1 goto error

echo.
echo Deployment completed successfully.
goto end

:error
echo.
echo Deployment failed with error code %ERRORLEVEL%.
endlocal
exit /b %ERRORLEVEL%

:end
endlocal
exit /b 0
