#!/bin/bash

echo "Running Filament Navigation Search Plugin Tests..."
echo

echo "Installing dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader
if [ $? -ne 0 ]; then
    echo "Failed to install dependencies"
    exit 1
fi

echo
echo "Running PHPUnit tests..."
vendor/bin/phpunit --testdox
if [ $? -ne 0 ]; then
    echo "Tests failed"
    exit 1
fi

echo
echo "Running code style checks..."
vendor/bin/pint --test
if [ $? -ne 0 ]; then
    echo "Code style issues found"
    exit 1
fi

echo
echo "Running static analysis..."
vendor/bin/phpstan analyse --no-progress
if [ $? -ne 0 ]; then
    echo "Static analysis issues found"
    exit 1
fi

echo
echo "All tests passed successfully!"
echo
