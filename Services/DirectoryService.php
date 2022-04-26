<?php namespace Services;

class DirectoryService
{
    public static function isDirExists(string $dir, bool $local = true): bool
    {
        if ( $local ) {
            $dir = _APP_BASE_DIR_ . $dir;
        }

        return is_dir($dir);
    }

    public static function createDir(string $dir, bool $recursive = true): bool
    {
        return mkdir($dir, 0755, $recursive);
    }

    public static function removeDir(string $dir): bool
    {
        return rmdir($dir);
    }
}
