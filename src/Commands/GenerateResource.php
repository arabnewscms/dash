<?php
namespace Dash\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateResource extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dash:make-resource {Resource} {--module=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate New Resource';

    protected $defaultPath = 'Dash/Resources';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

    }

    protected function getResourceStub()
    {
        return file_get_contents(__DIR__ . '/myStubs/resource.stub');
    }

    public function convention_name($string)
    {
        if (substr($string, -3) == 'ies') {
            $conv = substr($string, 0, -3) . 'y';
        } elseif (substr($string, -1) == 's') {
            $conv = substr($string, 0, -1);
        } else {
            $conv = $string;
        }
        return ucfirst($conv);
    }

    protected function argsDash($module=null, $name)
    {
        $new_path  = lara_module() ? '/app':'';
        return [
            'path'=>$module!= null?base_path('Modules/'.$module.$new_path.'/Dash/Resources') :app_path('Dash/Resources'),
            'namespace'=>$module!= null?'Modules\\'.$module.'\\App\\Dash\\Resources':'App\Dash\Resources',
            'text'=>$module!= null?'[Modules/'.$module.'/Dash/Resources/'.$name.'.php]':'[app/Dash/Resources/'. $name . '.php]'
        ];
    }

    protected function generate()
    {

        $name = $this->argument('Resource');
        $module = $this->option('module')??null;

        $args = $this->argsDash($module, $name);

        $namespace = $args['namespace'];
        $path =  $args['path'];
        $text = $args['text'];


        $template = str_replace(
            ['{{namespace}}', '{{resourcename}}', '{{model}}'],
            [$namespace, $name, $this->convention_name($name)],
            $this->getResourceStub()
        );


        if (!File::exists($path)) {
            File::makeDirectory($path, 0775, true);
        }

        if (!File::exists($path . '/' . $name . '.php')) {
            file_put_contents($path . '/' . $name . '.php', $template);
            $this->info($text);
            return true;
        } else {
            $this->warn($text.' resource already exists');
            return false;
        }
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {


        if ($this->generate()) {
            $this->info($this->argument('Resource') . ' Resource generated');
        }

        return 0;
    }
}
