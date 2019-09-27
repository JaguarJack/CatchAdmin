<?php
namespace JaguarJack\CatchAdmin\Console;

use Illuminate\Console\Command;
use JaguarJack\CatchAdmin\Service\Common\BackupDatabase as Backup;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:database {table --zip=no}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'backup database';

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
        ini_set('memory_limit', config('catchAdmin.backup.backup_memory'));

        $table = $this->argument('table');

        $tables = explode(',', $table);

        $backupDatabaseService = new Backup();

        $backupDatabaseService->generator($tables);
    }
}
