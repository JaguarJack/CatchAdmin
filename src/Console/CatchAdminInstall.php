<?php
namespace JaguarJack\CatchAdmin\Console;

use Illuminate\Console\Command;

class CatchAdminInstall extends Command
{
    use ConsoleTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'catch:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'install catchAdmin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('vendor:publish', [
            '--tag' => 'catchConfig',
            '--force' => true
        ]);

        $this->call('vendor:publish', [
            '--tag' => 'catchMigration',
            '--force' => true
        ]);

        $this->call('vendor:publish', [
            '--tag' => 'catchMigration',
            '--force' => true
        ]);

        $this->call('vendor:publish', [
            '--tag' => 'catchSeed',
            '--force' => true
        ]);

        $this->call('migrate', [
            '--path' => $this->getFilesOfPath($this->getMigrationPath(), 'php'),
            '--realpath' => true
        ]);

        $answer = $this->ask('数据填充需要执行 composer dump-autoload [yes/no]');

        if (strtolower($answer) === 'yes') {
            exec('composer dump-autoload');
            $this->call('db:seed', [
                '--class' => 'CatchAdminSeeder'
            ]);
        } else {
           $this->info('你需要手动执行 composer dump-autoload & php artisan db:seed --class=CatchAdminSeeder');
        }
    }
}
