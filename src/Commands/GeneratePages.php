<?php
namespace Dash\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GeneratePages extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'dash:make-page {page}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate New Page';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	protected function getResourceStub() {
		return file_get_contents(__DIR__ .'/myStubs/Page.stub');
	}

	protected function generate($namespace = 'App\Dash\Pages', $name) {
		$template = str_replace(
			['{{namespace}}', '{{name}}'],
			[$namespace, $name],
			$this->getResourceStub()
		);

		$path = app_path("Dash/Pages");
		if (!File::exists($path)) {
			File::makeDirectory($path, 0775, true);
		}

		file_put_contents($path.'/'.$name.'.php', $template);

		// blade views
		file_put_contents(
			resource_path('views').'/'.$name.'.blade.php',
			file_get_contents(__DIR__ .'/myStubs/PageBlade.stub')
		);
	}

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle() {
		$page = $this->argument('page');
		$this->generate('App\Dash\Pages', $page);
		$this->info($page.' Page generated');
		return 0;
	}
}
