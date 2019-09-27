<?php
namespace JaguarJack\CatchAdmin\Console;

trait ConsoleTrait
{
    private function getConfigFile()
    {
        return [
            config_path('upload.php'),
            config_path('catchAdmin.php'),
        ];
    }

    private function getMigrationPath()
    {
        return database_path('migrations' . DIRECTORY_SEPARATOR . 'catchAdmin' . DIRECTORY_SEPARATOR );
    }

    private function getSeedsPath()
    {
        return database_path('seeds' . DIRECTORY_SEPARATOR . 'catchAdmin' . DIRECTORY_SEPARATOR );
    }

    private function getFilesOfPath($path, $ext = '*')
    {
        return glob($path . '*.' . $ext);
    }


    private function unlink($file)
    {
        return unlink($file);
    }

    private function rmdir($path)
    {
        return rmdir($path);
    }
}
