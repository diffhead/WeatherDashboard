<?php namespace Interfaces\DependencyInjection;

interface Injectable
{
    public function onInjected(): bool;
    public function onEjected(): bool;
}
