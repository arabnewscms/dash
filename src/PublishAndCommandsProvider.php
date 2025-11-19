<?php

namespace Dash;

use Dash\Commands\GenerateActions;
use Dash\Commands\GenerateAverage;
use Dash\Commands\GenerateChart;
use Dash\Commands\GenerateDashboard;
use Dash\Commands\GenerateFilters;
use Dash\Commands\GenerateNotification;
use Dash\Commands\GeneratePages;
use Dash\Commands\GeneratePolicy;
use Dash\Commands\GenerateProgress;
use Dash\Commands\GenerateResource;
use Dash\Commands\GenerateValue;
use Dash\Commands\GetUpdates;
use Dash\Commands\InitialAdmin;
use Illuminate\Support\ServiceProvider;

/**
 * Publish And Commands Provider
 *
 * Service provider for registering Artisan commands and publishing package assets.
 * Handles all command registration and file publishing for the PHPDash package.
 *
 * Registered Commands:
 * - dash:make-resource - Generate new resource
 * - dash:make-filter - Generate filter
 * - dash:make-action - Generate action
 * - dash:make-dashboard - Generate dashboard
 * - dash:make-notify - Generate notification
 * - dash:make-policy - Generate policy
 * - dash:make-page - Generate blank page
 * - dash:get-updates - Get package updates
 * - dash:setup - Setup initial admin account
 * - dash:make-chart - Generate chart metric
 * - dash:make-value - Generate value metric
 * - dash:make-average - Generate average metric
 * - dash:make-progress - Generate progress metric
 *
 * @package Dash
 */
class PublishAndCommandsProvider extends ServiceProvider
{
    /**
     * Get the services provided by the provider
     *
     * Lists the services that this provider makes available.
     * Used by Laravel's service container for deferred providers.
     *
     * @return array<string>
     */
    public function provides()
    {
        return [
            'command.make-resource.resourceName',
        ];
    }

    /**
     * Register services
     *
     * Registers all Artisan commands for the dashboard including:
     * - Resource generators (resources, filters, actions, policies, pages)
     * - Dashboard generators
     * - Notification generators
     * - Metric generators (chart, value, average, progress)
     * - Setup and update commands
     *
     * @return void
     */
    public function register()
    {
        // Register the main resource generation command as singleton
        $this->app->singleton('command.dash', function ($app) {
            return new GenerateResource();
        });

        // Register all dashboard commands
        $this->commands([
            // Core generators
            GenerateResource::class,
            GenerateFilters::class,
            GenerateActions::class,
            GenerateDashboard::class,
            GenerateNotification::class,
            GeneratePolicy::class,
            GeneratePages::class,

            // Utility commands
            GetUpdates::class,
            InitialAdmin::class,

            // Metric generators
            GenerateChart::class,
            GenerateValue::class,
            GenerateAverage::class,
            GenerateProgress::class,
        ]);
    }

    /**
     * Bootstrap services
     *
     * Publishes all package assets to the application including:
     * - Policies - Base policy classes
     * - Providers - Service provider templates
     * - Public assets - CSS, JS, images
     * - Language files - Translations
     * - Database files - Migrations and seeders
     * - Resources - Base resource classes
     * - Metrics - Metric templates
     * - Dashboard files - Dashboard configuration
     * - Models - Base model classes
     * - Config files - Package configuration
     * - Base path files - Root level files
     *
     * Run: php artisan vendor:publish --provider="Dash\PublishAndCommandsProvider"
     *
     * @return void
     */
    public function boot()
    {
        // Publish policies
        $this->publishes([
            __DIR__ . '/publish/Policies' => base_path('app/Policies')
        ], 'dash-policies');

        // Publish service providers
        $this->publishes([
            __DIR__ . '/publish/providers' => base_path('app/Providers')
        ], 'dash-providers');

        // Publish public assets (CSS, JS, images)
        $this->publishes([
            __DIR__ . '/publish/public' => public_path('')
        ], 'dash-assets');

        // Publish language files
        $this->publishes([
            __DIR__ . '/publish/lang' => resource_path('lang')
        ], 'dash-lang');

        // Publish database files (migrations, seeders)
        $this->publishes([
            __DIR__ . '/publish/database' => database_path('')
        ], 'dash-database');

        // Publish resource templates
        $this->publishes([
            __DIR__ . '/publish/resources' => app_path('Dash/Resources')
        ], 'dash-resources');

        // Publish metric templates
        $this->publishes([
            __DIR__ . '/publish/Metrics' => app_path('Dash/Metrics')
        ], 'dash-metrics');

        // Publish dashboard core files
        $this->publishes([
            __DIR__ . '/publish/Dash' => app_path('Dash')
        ], 'dash-core');

        // Publish model files
        $this->publishes([
            __DIR__ . '/publish/models' => app_path('Models')
        ], 'dash-models');

        // Publish dashboard configuration
        $this->publishes([
            __DIR__ . '/publish/Dashboard' => app_path('Dash/Dashboard')
        ], 'dash-dashboard');

        // Publish config files
        $this->publishes([
            __DIR__ . '/publish/config' => base_path('config')
        ], 'dash-config');

        // Publish base path files (root level files like .env.example)
        $this->publishes([
            __DIR__ . '/publish/base_path' => base_path('/')
        ], 'dash-base');
    }
}
