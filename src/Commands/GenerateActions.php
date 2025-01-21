<?php
namespace Dash\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateActions extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'dash:make-action {action}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate New Actions';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	protected function getResourceStub() {
		return file_get_contents(__DIR__ .'/myStubs/Action.stub');
	}

	protected function generate($namespace = 'App\Dash\Actions', $name) {
		$template = str_replace(
			['{{namespace}}', '{{name}}'],
			[$namespace, $name],
			$this->getResourceStub()
		);

		$path = app_path("Dash/Actions");
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
		$actions = $this->argument('action');
		$this->generate('App\Dash\Actions', $actions);
		$this->info($actions.' Action generated');

		return 0;
	}
}
