<?php
namespace Dash\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateDashboard extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'dash:make-dash {dash}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate New dashboard object';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	protected function getResourceStub() {
		return file_get_contents(__DIR__ .'/myStubs/Dashboard.stub');
	}

	protected function generate($namespace = 'App\Dash\Dashboard', $name) {
		$template = str_replace(
			['{{namespace}}', '{{name}}'],
			[$namespace, $name],
			$this->getResourceStub()
		);

		$path = app_path("Dash/Dashboard");
		if (!File::exists($path)) {
			File::makeDirectory($path, 0775, true);
		}

		file_put_contents($path.'/'.$name.'.php', $template);
	}

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle() {
		$dashboard = $this->argument('dash');
		$this->generate('App\Dash\Dashboard', $dashboard);
		$this->info($dashboard.' Dashboard generated');

		return 0;
	}
}
