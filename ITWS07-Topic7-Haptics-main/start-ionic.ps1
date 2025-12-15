Write-Host "Starting Ionic Development Server..." -ForegroundColor Cyan
Write-Host ""

# Ensure Node.js is in PATH
$env:Path = "C:\Program Files\nodejs;" + $env:Path

# Check Node.js version
$nodeVersion = node --version
Write-Host "Using Node.js: $nodeVersion" -ForegroundColor Green

# Start Ionic server
ionic serve

