<?php

namespace App\Model\User;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;

class SignUpModel
{
    #[Email]
    #[NotNull]
    private string $email;
    #[NotNull]
    #[Length(min: 4)]
    private string $password;
    #[EqualTo(propertyPath: 'password', message: 'This value should be equal to password field.')]
    private string $confirmPassword;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;

    }

    public function getConfirmPassword(): string
    {
        return $this->confirmPassword;
    }

    public function setConfirmPassword(string $confirmPassword): self
    {
        $this->confirmPassword = $confirmPassword;

        return $this;

    }
}
