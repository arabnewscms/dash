<?php
namespace Dash\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateProgress extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'dash:progress {Progress} {--module=}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate New Progress';

    protected $defaultPath = 'Dash/Metrics/Progress';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	protected function getProgressStub() {
		return file_get_contents(__DIR__ . '/myStubs/progress.stub');
	}



    protected function argsDash($module=null,$name){
        $new_path  = lara_module() ? '/app':'';
        return [
            'path'=>$module!= null?base_path('Modules/'.$module.$new_path.'/Dash/Metrics/Progress') :app_path('Dash/Metrics/Progress'),
            'namespace'=>$module!= null?'Modules\\'.$module.'\\Dash\\Metrics\\Progress':'App\Dash\Metrics\Progress',
            'text'=>$module!= null?'[Modules/'.$module.'/Dash/Metrics/Progress/'.$name.'.php]':'[app/Dash/Metrics/Progress/'. $name . '.php]'
        ];
    }

	protected function generate() {

        $name = $this->argument('Progress');
        $module = $this->option('module')??null;

        $args = $this->argsDash($module,$name);

        $namespace = $args['namespace'];
        $path =  $args['path'];
        $text = $args['text'];


		$template = str_replace(
			['{{namespace}}', '{{progressname}}'],
			[$namespace, $name],
			$this->getProgressStub()
		);


		if (!File::exists($path)) {
            File::makeDirectory($path, 0775, true);
		}

        if (!File::exists($path . '/' . $name . '.php')) {
            file_put_contents($path . '/' . $name . '.php', $template);
            $this->info( $text);
            return true;
		}else{
            $this->warn( $text.' Progress already exists');
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
            $this->info($this->argument('Progress') . ' Progress generated');
        }
		return 0;
	}
}
