# PowerShell script to check for hardcoded asset paths in Blade files
# This prevents using hardcoded asset() calls instead of @vite directives

Write-Host "Checking for hardcoded asset paths..." -ForegroundColor Cyan

$errorFound = $false
$errors = @()

# Check for hardcoded build asset paths
$hardcodedPaths = Get-ChildItem -Path "resources\views" -Filter "*.blade.php" -Recurse | 
Select-String -Pattern "asset\(['""]build/assets" | 
ForEach-Object { "$($_.Filename):$($_.LineNumber) - $($_.Line)" }

if ($hardcodedPaths) {
    $errorFound = $true
    $errors += "ERROR: Hardcoded asset paths found!"
    $errors += ""
    $errors += "Please replace hardcoded asset paths with @vite directives:"
    $errors += ""
    $errors += "Bad:  <link rel=""stylesheet"" href=""{{ asset('build/assets/app-XXX.css') }}"">"
    $errors += "Good: @vite(['resources/css/app.css', 'resources/js/app.js'])"
    $errors += ""
    $errors += "Files with hardcoded paths:"
    $errors += $hardcodedPaths
}

# Also check for old CSS/JS file references
$oldRefs = Get-ChildItem -Path "resources\views" -Filter "*.blade.php" -Recurse | 
Select-String -Pattern "app-BVG48AMd|app-CXDpL9bK|app-CK8dCDDL|app-Dx6_zjTn" | 
ForEach-Object { "$($_.Filename):$($_.LineNumber) - $($_.Line)" }

if ($oldRefs) {
    $errorFound = $true
    $errors += "ERROR: Old hardcoded asset file names found!"
    $errors += ""
    $errors += $oldRefs
    $errors += ""
    $errors += "Please use @vite directives instead of hardcoded file names."
}

if ($errorFound) {
    Write-Host ""
    foreach ($errorMessage in $errors) {
        Write-Host $errorMessage -ForegroundColor Red
    }
    exit 1
}

Write-Host "No hardcoded asset paths found!" -ForegroundColor Green
exit 0

