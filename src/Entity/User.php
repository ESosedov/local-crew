<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity]
#[ORM\Table(name: "users")]
class User extends AbstractBaseUuidEntity
{
    use TimestampableEntity;

    #[ORM\Column(type: 'string', length: 255, nullable: false, options: ['comment' => "User`s login"])]
    private string $login;
    #[ORM\Column(type: 'string', nullable: false, options: ['comment' => "User`s password"])]
    private string $password;
    #[ORM\Column(type: 'string', length: 255, nullable: false, options: ['comment' => "User`s name"])]
    private string $name;
    #[ORM\Column(type: 'string', length: 255, nullable: true, options: ['comment' => "User`s city"])]
    private ?string $city;
    #[ORM\Column(type: 'integer', nullable: true, options: ['comment' => "User`s age"])]
    private ?int $age;
    #[ORM\Column(type: 'string', length: 255, nullable: true, options: ['comment' => 'User`s gender'])]
    private ?string $gender;
    #[ORM\Column(type: 'string', nullable: true, options: ['comment' => 'User`s info'])]
    private string $info;
}