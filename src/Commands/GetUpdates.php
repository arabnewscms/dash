<?php

namespace Dash\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GetUpdates extends Command
{

    protected $signature = 'dash:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update dash template files';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->warn('Updating and installing please wait some files in your template');
        $this->pushingUpdateFiles();
        $this->info('Dash package updated successfully!');
    }

    public function pushingUpdateFiles()
    {
        $this->warn('updating dashboard files ...');
        if (File::exists(public_path('dashboard'))) {
            File::deleteDirectory(public_path('dashboard'));
        }

        File::copyDirectory(__DIR__ . '/../publish/public/dashboard', public_path('dashboard'));
    }
}
