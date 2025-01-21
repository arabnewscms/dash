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

class PublishAndCommandsProvider extends ServiceProvider {

	public function provides() {
		return [
			'command.make-resource.resourceName',
		];
	}

	/**
	 * Register services.
	 *
	 * @return void
	 */
	public function register() {
		$this->app->singleton('command.dash', function ($app) {
			return new GenerateResource;
		});

		$this->commands([
			GenerateResource::class,
			GenerateFilters::class,
			GenerateActions::class,
			GenerateDashboard::class,
			GenerateNotification::class,
			GeneratePolicy::class,
			GeneratePages::class,
			GetUpdates::class,
			InitialAdmin::class,

            // Metrics Commands
			GenerateChart::class,
			GenerateValue::class,
			GenerateAverage::class,
			GenerateProgress::class,
		]);

	}

	/**
	 * Bootstrap services.
	 *
	 * @return void
	 */
	public function boot() {
		// Publish files and folders
		$this->publishes([__DIR__ . '/publish/Policies' => base_path('app/Policies')]);
		$this->publishes([__DIR__ . '/publish/providers' => base_path('app/Providers')]);
		$this->publishes([__DIR__ . '/publish/public' => public_path('')]);
		$this->publishes([__DIR__ . '/publish/lang' => resource_path('lang')]);
		$this->publishes([__DIR__ . '/publish/database' => database_path('')]);
		$this->publishes([__DIR__ . '/publish/resources' => app_path('Dash/Resources')]);
		$this->publishes([__DIR__ . '/publish/Metrics' => app_path('Dash/Metrics')]);
		$this->publishes([__DIR__ . '/publish/Dash' => app_path('Dash')]);
		$this->publishes([__DIR__ . '/publish/models' => app_path('Models')]);
		$this->publishes([__DIR__ . '/publish/Dashboard' => app_path('Dash/Dashboard')]);
		$this->publishes([__DIR__ . '/publish/config' => base_path('config')]);
		$this->publishes([__DIR__ . '/publish/base_path' => base_path('/')]);

	}

}
