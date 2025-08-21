<?php

namespace HkDevs\FilamentNavigationSearch;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentNavigationSearchServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-navigation-search';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasViews()
            ->hasTranslations();
    }

    public function packageRegistered(): void
    {
        //
    }

    public function packageBooted(): void
    {
        //
    }
}
