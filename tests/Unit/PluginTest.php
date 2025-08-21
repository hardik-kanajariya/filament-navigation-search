<?php

namespace HkDevs\FilamentNavigationSearch\Tests\Unit;

use HkDevs\FilamentNavigationSearch\FilamentNavigationSearchPlugin;
use HkDevs\FilamentNavigationSearch\Tests\TestCase;

class PluginTest extends TestCase
{
    public function test_plugin_can_be_instantiated()
    {
        $plugin = FilamentNavigationSearchPlugin::make();

        $this->assertInstanceOf(FilamentNavigationSearchPlugin::class, $plugin);
        $this->assertEquals('filament-navigation-search', $plugin->getId());
    }

    public function test_plugin_has_default_configuration()
    {
        $plugin = FilamentNavigationSearchPlugin::make();

        $this->assertEquals('Search navigation...', $plugin->getPlaceholder());
        $this->assertEquals('top', $plugin->getPosition());
        $this->assertTrue($plugin->getShowResultsCount());
        $this->assertEquals(200, $plugin->getSearchDelay());
        $this->assertEquals(1, $plugin->getMinSearchLength());
        $this->assertTrue($plugin->getHighlightMatches());
        $this->assertTrue($plugin->isEnabled());
    }

    public function test_plugin_can_be_configured()
    {
        $plugin = FilamentNavigationSearchPlugin::make()
            ->placeholder('Custom placeholder')
            ->position('bottom')
            ->showResultsCount(false)
            ->searchDelay(500)
            ->minSearchLength(3)
            ->highlightMatches(false)
            ->enabled(false);

        $this->assertEquals('Custom placeholder', $plugin->getPlaceholder());
        $this->assertEquals('bottom', $plugin->getPosition());
        $this->assertFalse($plugin->getShowResultsCount());
        $this->assertEquals(500, $plugin->getSearchDelay());
        $this->assertEquals(3, $plugin->getMinSearchLength());
        $this->assertFalse($plugin->getHighlightMatches());
        $this->assertFalse($plugin->isEnabled());
    }

    public function test_plugin_validates_position()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Position must be either "top" or "bottom"');

        FilamentNavigationSearchPlugin::make()->position('invalid');
    }

    public function test_plugin_validates_search_delay()
    {
        $plugin = FilamentNavigationSearchPlugin::make()->searchDelay(-100);

        $this->assertEquals(0, $plugin->getSearchDelay());
    }

    public function test_plugin_validates_min_search_length()
    {
        $plugin = FilamentNavigationSearchPlugin::make()->minSearchLength(0);

        $this->assertEquals(1, $plugin->getMinSearchLength());
    }

    public function test_plugin_enabled_with_closure()
    {
        $plugin = FilamentNavigationSearchPlugin::make()
            ->enabled(fn() => false);

        $this->assertFalse($plugin->isEnabled());
    }
}
