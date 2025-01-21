<?php
namespace Dash\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GeneratePolicy extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'dash:make-policy {policy} {--module=}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate New Policy you can use --module={ModuleName} flag in HMVC Module';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	protected function getResourceStub() {
		return file_get_contents(__DIR__ . '/myStubs/Policy.stub');
	}

	protected function argsDash($module=null,$name){
        $new_path  = lara_module() ? '/app':'';
        return [
            'path'=>$module!= null?base_path('Modules/'.$module.$new_path.'/Policies') :app_path('Policies'),
            'namespace'=>$module!= null?'Modules\\'.$module.'\\Policies':'App\Policies',
            'text'=>$module!= null?'[Modules/'.$module.'/Policies/'.$name.'.php]':'[app/Policies/'. $name . '.php]'
        ];
    }

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle() {
		$name = $this->argument('policy');

		$module = $this->option('module')??null;
        $args = $this->argsDash($module,$name);

		$namespace = $args['namespace'];
        $path =  $args['path'];
        $text = $args['text'];

		$template = str_replace(
			['{{namespace}}', '{{name}}', '{{resource}}'],
			[$namespace, $name, $module??'YourResourceName'],
			$this->getResourceStub()
		);


		if (!File::exists($path)) {
            File::makeDirectory($path, 0775, true);
		}

        if (!File::exists($path . '/' . $name . '.php')) {
            file_put_contents($path . '/' . $name . '.php', $template);
            $this->info( $text);
            return true;
		}else{
            $this->warn( $text.' Policy already exists');
            return false;
        }

		return 0;
	}
}
