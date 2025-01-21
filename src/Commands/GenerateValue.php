<?php
namespace Dash\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateValue extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'dash:value {Value} {--module=}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate New Value';

    protected $defaultPath = 'Dash/Metrics/Values';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	protected function getValueStub() {
		return file_get_contents(__DIR__ . '/myStubs/value.stub');
	}



    protected function argsDash($module=null,$name){
        $new_path  = lara_module() ? '/app':'';
        return [
            'path'=>$module!= null?base_path('Modules/'.$module.$new_path.'/Dash/Metrics/Values') :app_path('Dash/Metrics/Values'),
            'namespace'=>$module!= null?'Modules\\'.$module.'\\Dash\\Metrics\\Values':'App\Dash\Metrics\Values',
            'text'=>$module!= null?'[Modules/'.$module.'/Dash/Metrics/Values/'.$name.'.php]':'[app/Dash/Metrics/Values/'. $name . '.php]'
        ];
    }

	protected function generate() {

        $name = $this->argument('Value');
        $module = $this->option('module')??null;

        $args = $this->argsDash($module,$name);

        $namespace = $args['namespace'];
        $path =  $args['path'];
        $text = $args['text'];


		$template = str_replace(
			['{{namespace}}', '{{valuename}}'],
			[$namespace, $name],
			$this->getValueStub()
		);


		if (!File::exists($path)) {
            File::makeDirectory($path, 0775, true);
		}

        if (!File::exists($path . '/' . $name . '.php')) {
            file_put_contents($path . '/' . $name . '.php', $template);
            $this->info( $text);
            return true;
		}else{
            $this->warn( $text.' Value already exists');
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
    $this->info($this->argument('Value') . ' Value generated');
}

		return 0;
	}
}
