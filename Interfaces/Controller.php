<?php namespace Interfaces;

interface Controller
{
    public function execute(): bool;
    public function getOutput(): ControllerOutput;
}
