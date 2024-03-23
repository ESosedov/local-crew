<?php

namespace App\Exception\User;

class UserAlreadyExistsException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('user already exists');
    }
}
