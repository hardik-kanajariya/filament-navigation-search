<?php

namespace HkDevs\FilamentNavigationSearch\Tests\Unit;

use HkDevs\FilamentNavigationSearch\FilamentNavigationSearchServiceProvider;
use HkDevs\FilamentNavigationSearch\Tests\TestCase;

class ServiceProviderTest extends TestCase
{
    public function test_service_provider_loads_views()
    {
        $this->assertTrue(view()->exists('filament-navigation-search::navigation-search'));
    }

    public function test_service_provider_loads_translations()
    {
        $this->assertIsString(__('filament-navigation-search::navigation-search.clear'));
        $this->assertIsString(__('filament-navigation-search::navigation-search.no_results'));
        $this->assertIsString(__('filament-navigation-search::navigation-search.placeholder'));
    }

    public function test_service_provider_has_correct_name()
    {
        $this->assertEquals('filament-navigation-search', FilamentNavigationSearchServiceProvider::$name);
    }
}
