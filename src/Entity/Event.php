<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity]
#[ORM\Table(name: 'events')]
class Event extends AbstractBaseUuidEntity
{
    use TimestampableEntity;

    #[ORM\Column(type: 'string', length: 255, nullable: false, options: ['comment' => 'Event`s title'])]
    private string $title;

    #[ORM\Column(type: 'datetime_immutable', nullable: false)]
    private \DateTimeInterface $date;

    #[ORM\Column(type: 'string', length: 1024, nullable: true, options: ['comment' => 'Условия участия'])]
    private ?string $participationTerms;

    #[ORM\Column(type: 'string', length: 255, nullable: true, options: ['comment' => 'Статус'])]
    private ?string $meetingStatus;

    #[ORM\Column(type: 'string', length: 1024, nullable: true, options: ['comment' => 'Детали'])]
    private ?string $details;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $city;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $street;

    #[ORM\Column(type: 'integer', length: 255, nullable: true)]
    private ?int $streetNumber;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $placeTitle;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $latitude;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $longitude;
}
