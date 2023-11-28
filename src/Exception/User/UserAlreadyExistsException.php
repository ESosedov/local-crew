<?php

namespace App\Exception\User;

use RuntimeException;

class UserAlreadyExistsException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('user already exists');
    }
}
