<?php
namespace Dash\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateChart extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'dash:chart {Chart} {--module=}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate New Chart bar , line , polar , etc...';

    protected $defaultPath = 'Dash/Metrics/Charts';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	protected function getChartStub() {
		return file_get_contents(__DIR__ . '/myStubs/chart.stub');
	}



    protected function argsDash($module=null,$name){
        $new_path  = lara_module() ? '/app':'';
        return [
            'path'=>$module!= null?base_path('Modules/'.$module.$new_path.'/Dash/Metrics/Charts') :app_path('Dash/Metrics/Charts'),
            'namespace'=>$module!= null?'Modules\\'.$module.'\\Dash\\Metrics\\Charts':'App\Dash\Metrics\Charts',
            'text'=>$module!= null?'[Modules/'.$module.'/Dash/Metrics/Charts/'.$name.'.php]':'[app/Dash/Metrics/Charts/'. $name . '.php]'
        ];
    }

	protected function generate() {

        $name = $this->argument('Chart');
        $module = $this->option('module')??null;

        $args = $this->argsDash($module,$name);

        $namespace = $args['namespace'];
        $path =  $args['path'];
        $text = $args['text'];


		$template = str_replace(
			['{{namespace}}', '{{chartname}}'],
			[$namespace, $name],
			$this->getChartStub()
		);


		if (!File::exists($path)) {
            File::makeDirectory($path, 0775, true);
		}

        if (!File::exists($path . '/' . $name . '.php')) {
            file_put_contents($path . '/' . $name . '.php', $template);
            $this->info( $text);
            return true;
		}else{
            $this->warn( $text.' Chart already exists');
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
    $this->info($this->argument('Chart') . ' Chart generated');
}

		return 0;
	}
}
