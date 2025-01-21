<?php
namespace Dash\Commands;

use Illuminate\Console\Command;
use \App\Models\AdminGroup;
use \App\Models\AdminGroupRole;
use \App\Models\User;

class InitialAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dash:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'setup admin account';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function logo()
    {
        $logo = '
 /$$$$$$$   /$$$$$$   /$$$$$$  /$$   /$$
| $$__  $$ /$$__  $$ /$$__  $$| $$  | $$
| $$  \ $$| $$  \ $$| $$  \__/| $$  | $$
| $$  | $$| $$$$$$$$|  $$$$$$ | $$$$$$$$       /$$$$$$
| $$  | $$| $$__  $$ \____  $$| $$__  $$      |______/
| $$  | $$| $$  | $$ /$$  \ $$| $$  | $$
| $$$$$$$/| $$  | $$|  $$$$$$/| $$  | $$
|_______/ |__/  |__/ \______/ |__/  |__/
 phpdash.com
 Author Mahmoud Ibrahim
';
        return $logo;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $this->warn($this->logo());
        $this->warn('extract files to providers and users model');
        \Artisan::call('vendor:publish', [
            '--force' => true,
            '--provider' => 'Dash\PublishAndCommandsProvider',
        ]);
        $this->info('extracted');

        $this->warn('migrate database users & filemanager and admin roles tables');
        \Artisan::call('migrate');
        $this->info('immigrated');

        $this->warn('inject admin account email:test@test.com , password=123456');
        if (User::where('email', 'test@test.com')->count() == 0) {
            $group = AdminGroup::create(['name' => 'full admin']);
            $roles = ['users', 'admin_groups', 'admin_group_roles'];
            foreach ($roles as $role) {
                AdminGroupRole::create([
                    'admin_group_id' => $group->id,
                    'resource' => $role,
                    'create' => 'yes',
                    'show' => 'yes',
                    'update' => 'yes',
                    'delete' => 'yes',
                    'force_delete' => 'yes',
                    'restore' => 'yes',
                ]);
            }

            User::firstOrCreate([
                'name' => 'admin',
                'email' => 'test@test.com',
                'password' => bcrypt(123456),
                'account_type' => 'admin',
                'admin_group_id' => $group->id,
                'email_verified_at' => now(),
            ]);
            $this->info('The account & group and role has been injected');
        } else {
            $this->info('The account has already been created');
        }

        return 0;
    }
}
