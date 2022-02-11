<?php namespace Interfaces;

interface Module
{
    public function init(): void;

    public function enable(): bool;
    public function disable(): bool;

    public function isEnabled(): bool;

    public function getName(): string;
    public function getPath(): string;
}
