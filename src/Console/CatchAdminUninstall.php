<?php
namespace JaguarJack\CatchAdmin\Console;

use Illuminate\Console\Command;

class CatchAdminUninstall extends Command
{
    use ConsoleTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'catch:uninstall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'uninstall catchAdmin';

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
        $answer = $this->ask('删除配置文件? [yes/no]');

        if (strtolower($answer) === 'yes') {
            $this->uninstallConfig();
        }

        $answer = $this->ask('删除表以及数据填充?[yes/no]');

        if (strtolower($answer) === 'yes') {
            $this->uninstallMigrations();

            $this->uninstallSeed();
        }
    }

    /**
     * 删除配置
     *
     * @time 2019年09月27日
     * @return void
     */
    protected function uninstallConfig()
    {
        foreach ($this->getConfigFile() as $file) {
            $this->unlink($file);
        }

        $this->info('config deleted');
    }

    /**
     * 回滚表
     *
     * @time 2019年09月27日
     * @return void
     */
    protected function uninstallMigrations()
    {
        $migrationPath = $this->getMigrationPath();

        $this->call('migrate:rollback', [
            '--path' => $this->getFilesOfPath($migrationPath, 'php'),
            '--realpath' => true
        ]);

        foreach ($this->getFilesOfPath($migrationPath) as $item) {
            $this->unlink($item);
        }

        $this->rmdir($migrationPath);
    }

    /**
     * 删除预置数据
     *
     * @time 2019年09月27日
     * @return void
     */
    protected function uninstallSeed()
    {
        foreach ($this->getFilesOfPath($this->getSeedsPath()) as $file) {
            $this->unlink($file);
        }

        $this->rmdir($this->getSeedsPath());
    }
}
