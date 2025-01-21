<?php
namespace Dash\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateFilters extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'dash:make-filter {filter}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate New filters';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	protected function getResourceStub() {
		return file_get_contents(__DIR__ .'/myStubs/filter.stub');
	}

	protected function generate($namespace = 'App\Dash\Filters', $name) {
		$template = str_replace(
			['{{namespace}}', '{{filtername}}'],
			[$namespace, $name],
			$this->getResourceStub()
		);

		$path = app_path("Dash/Filters");
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
		$filter = $this->argument('filter');
		$this->generate('App\Dash\Filters', $filter);
		$this->info($filter.' Filter generated');

		return 0;
	}
}
