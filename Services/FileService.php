<?php namespace Services;

class FileService
{
    public static function fileExists(string $filePath): bool
    {
        return file_exists($filePath);
    }
}
