<?php namespace Services;

class FileService
{
    public static function fileExists(string $filePath): bool
    {
        return file_exists($filePath);
    }

    public static function getDir(string $filePath): string
    {
        return dirname($filePath);
    }

    public static function isWritable(string $filePath): bool
    {
        return is_writable($filePath);
    }

    public static function isReadable(string $filePath): bool
    {
        return is_readable($filePath);
    }
}
