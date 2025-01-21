<?php
namespace Dash\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateAverage extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'dash:average {Average} {--module=}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate New Average';

    protected $defaultPath = 'Dash/Metrics/Averages';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	protected function getAverageStub() {
		return file_get_contents(__DIR__ . '/myStubs/average.stub');
	}



    protected function argsDash($module=null,$name){
        $new_path  = lara_module() ? '/app':'';
        return [
            'path'=>$module!= null?base_path('Modules/'.$module.$new_path.'/Dash/Metrics/Averages') :app_path('Dash/Metrics/Averages'),
            'namespace'=>$module!= null?'Modules\\'.$module.'\\Dash\\Metrics\\Averages':'App\Dash\Metrics\Averages',
            'text'=>$module!= null?'[Modules/'.$module.'/Dash/Metrics/Averages/'.$name.'.php]':'[app/Dash/Metrics/Averages/'. $name . '.php]'
        ];
    }

	protected function generate() {

        $name = $this->argument('Average');
        $module = $this->option('module')??null;

        $args = $this->argsDash($module,$name);

        $namespace = $args['namespace'];
        $path =  $args['path'];
        $text = $args['text'];


		$template = str_replace(
			['{{namespace}}', '{{averagename}}'],
			[$namespace, $name],
			$this->getAverageStub()
		);


		if (!File::exists($path)) {
            File::makeDirectory($path, 0775, true);
		}

        if (!File::exists($path . '/' . $name . '.php')) {
            file_put_contents($path . '/' . $name . '.php', $template);
            $this->info( $text);
            return true;
		}else{
            $this->warn( $text.' Average already exists');
            return false;
        }
	}

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle() {


if($this->generate()) {
    $this->info($this->argument('Average') . ' Average generated');
}

		return 0;
	}
}
