#!/usr/bin/env php
<?php

/**
 * Simple test runner for Filament Navigation Search Plugin
 *
 * This script runs all tests and quality checks for the plugin.
 * Run this from the plugin directory: php test-runner.php
 */
echo "🚀 Filament Navigation Search Plugin - Test Runner\n";
echo "================================================\n\n";

$startTime = microtime(true);
$passed = 0;
$failed = 0;

function runCommand($description, $command, $requireSuccess = true)
{
    global $passed, $failed;

    echo "📋 {$description}...\n";
    echo "   Command: {$command}\n";

    $output = [];
    $returnVar = 0;

    exec($command.' 2>&1', $output, $returnVar);

    if ($returnVar === 0) {
        echo "   ✅ PASSED\n\n";
        $passed++;

        return true;
    } else {
        echo "   ❌ FAILED\n";
        echo "   Output:\n";
        foreach ($output as $line) {
            echo "   > {$line}\n";
        }
        echo "\n";
        $failed++;

        if ($requireSuccess) {
            echo "💥 Test suite failed. Stopping execution.\n";
            exit(1);
        }

        return false;
    }
}

// Check if we're in the right directory
if (! file_exists('composer.json')) {
    echo "❌ Error: composer.json not found. Please run this script from the plugin directory.\n";
    exit(1);
}

$composer = json_decode(file_get_contents('composer.json'), true);
if ($composer['name'] !== 'hkdevs/filament-navigation-search') {
    echo "❌ Error: This doesn't appear to be the navigation search plugin directory.\n";
    exit(1);
}

echo '📂 Working directory: '.getcwd()."\n";
echo "📦 Package: {$composer['name']}\n";
echo "📝 Description: {$composer['description']}\n\n";

// Install dependencies
runCommand(
    'Installing Composer dependencies',
    'composer install --no-interaction --prefer-dist --optimize-autoloader'
);

// Run PHPUnit tests
runCommand(
    'Running PHPUnit tests',
    'vendor/bin/phpunit --testdox --colors=always'
);

// Check if Pint exists and run code style check
if (file_exists('vendor/bin/pint')) {
    runCommand(
        'Checking code style with Laravel Pint',
        'vendor/bin/pint --test',
        false // Don't stop on failure
    );
} else {
    echo "⚠️  Laravel Pint not found. Skipping code style check.\n\n";
}

// Check if PHPStan exists and run static analysis
if (file_exists('vendor/bin/phpstan')) {
    runCommand(
        'Running static analysis with PHPStan',
        'vendor/bin/phpstan analyse --no-progress',
        false // Don't stop on failure
    );
} else {
    echo "⚠️  PHPStan not found. Skipping static analysis.\n\n";
}

// Summary
$endTime = microtime(true);
$duration = round($endTime - $startTime, 2);

echo "🏁 Test Summary\n";
echo "===============\n";
echo "✅ Passed: {$passed}\n";
echo "❌ Failed: {$failed}\n";
echo "⏱️  Duration: {$duration} seconds\n\n";

if ($failed === 0) {
    echo "🎉 All tests passed! The plugin is ready for use.\n";
    exit(0);
} else {
    echo "💥 Some tests failed. Please review the output above.\n";
    exit(1);
}
