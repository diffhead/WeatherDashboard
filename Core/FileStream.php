<?php namespace Core;

use Generator;

use Services\FileService;

class FileStream
{
    public const ACCESS_RW = 'r+';
    public const ACCESS_WO = 'w';
    public const ACCESS_RO = 'r';

    private string $access;
    private string $filePath;
    private mixed  $stream = null;

    public function __construct(string $filePath, string $access = FileStream::ACCESS_RO)
    {
        $this->access = $access;
        $this->filePath = $filePath;
    }

    public function getAccess(): string
    {
        return $this->access;
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }

    public function getFileSize(): int
    {
        if ( $this->stream ) {
            return filesize($this->filePath);
        }

        return 0;
    }

    public function open(): bool
    {
        if ( FileService::fileExists($this->filePath) ) {
            $this->stream = fopen($this->filePath, $this->access);

            return (bool)$this->stream;
        }

        return false;
    }

    public function close(): void
    {
        if ( $this->stream ) {
            fclose($this->stream);

            $this->stream = null;
        }
    }

    public function read(): string
    {
        if ( $this->stream && $this->isAvailableForReading() ) {
            return fread($this->stream, $this->getFileSize());
        }

        return '';
    }

    public function write(string $text): bool
    {
        if ( $this->stream && $this->isAvailableForWriting() ) {
            return fwrite($this->stream, $text);
        }

        return false;
    }

    public function isAvailableForReading(): bool
    {
        return $this->access === self::ACCESS_RW || $this->access === self::ACCESS_RO;
    }

    public function isAvailableForWriting(): bool
    {
        return $this->access === self::ACCESS_RW || $this->access === self::ACCESS_WO;
    }

    public function getLinesGenerator(): Generator
    {
        if ( $this->stream ) {
            while ( ($line = fgets($this->stream)) !== false ) {
                yield $line;
            }
        }

        yield '';
    }
}
