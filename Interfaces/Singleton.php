<?php namespace Interfaces;

interface Singleton
{
    public static function getInstance(): self;
}
