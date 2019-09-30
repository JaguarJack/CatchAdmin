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
    protected $signature = 'catch:backup 
                            {table : the table name you need backup, support multi and you need , join them} 
                            {--format= : the format you can use [php/sql]} 
                            {--zip=no : Whether you need compression [yes/no]}';

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
        $backup = config('catchAdmin.backup');

        ini_set('memory_limit', $backup['backup_memory']);

        $table = $this->argument('table');

        $tables = explode(',', $table);

        $backupDatabaseService = new Backup();

        $backupDatabaseService->generator($tables, $this->getFormat(), $backup['path'] . $this->getFormat() . DIRECTORY_SEPARATOR);
    }

    /**
     * 获取导出格式
     *
     * @time 2019年09月30日
     * @return array|bool|\Illuminate\Config\Repository|mixed|string|null
     */
    protected function getFormat()
    {
        $format = $this->option('format');

        if (!$format) {
            $format = config('catchAdmin.backup.format');
        }

        return $format;
    }
}
