<?php namespace Interfaces\DependencyInjection;

interface InjectionClient
{
    public function inject(string $prop, Injectable $injectable): bool;
    public function eject(string $prop): bool;
}
