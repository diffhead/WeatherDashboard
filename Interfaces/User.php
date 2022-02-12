<?php namespace Interfaces;

interface User
{
    public function isLogged(): bool;
    public function isAdmin(): bool;
    public function isActive(): bool;
    public function isGuest(): bool;
}
