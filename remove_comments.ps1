$ErrorActionPreference = 'Stop'

# Define file extensions to process
$extensions = @('.php', '.blade.php')

# Get all target files recursively
Get-ChildItem -Path "$PSScriptRoot" -Recurse -Include *.php, *.blade.php | ForEach-Object {
    $filePath = $_.FullName
    $content = Get-Content -Path $filePath -Raw -Encoding UTF8
    # Remove PHP single-line comments (// and #)
    $content = $content -replace '(?m)//.*$',''
    $content = $content -replace '(?m)#.*$',''
    # Remove PHP multi-line comments (/* */)
    $content = $content -replace '/\*[\s\S]*?\*/',''
    # Remove Blade comments {{-- --}}
    $content = $content -replace '\{\{--[\s\S]*?--\}\}',''
    # Remove HTML comments <!-- -->
    $content = $content -replace '<!--[\s\S]*?-->',''
    # Write back cleaned content
    Set-Content -Path $filePath -Value $content -Encoding UTF8
    Write-Host "Processed: $filePath"
}

Write-Host "All comments removed successfully."
