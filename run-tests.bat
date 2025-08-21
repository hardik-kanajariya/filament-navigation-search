@echo off
echo Running Filament Navigation Search Plugin Tests...
echo.

echo Installing dependencies...
call composer install --no-interaction --prefer-dist --optimize-autoloader
if %errorlevel% neq 0 (
    echo Failed to install dependencies
    exit /b %errorlevel%
)

echo.
echo Running PHPUnit tests...
call vendor\bin\phpunit --testdox
if %errorlevel% neq 0 (
    echo Tests failed
    exit /b %errorlevel%
)

echo.
echo Running code style checks...
call vendor\bin\pint --test
if %errorlevel% neq 0 (
    echo Code style issues found
    exit /b %errorlevel%
)

echo.
echo Running static analysis...
call vendor\bin\phpstan analyse --no-progress
if %errorlevel% neq 0 (
    echo Static analysis issues found
    exit /b %errorlevel%
)

echo.
echo All tests passed successfully!
echo.
