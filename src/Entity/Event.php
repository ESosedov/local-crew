<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: EventRepository::class)]
#[ORM\Table(name: 'events')]
class Event extends AbstractBaseUuidEntity
{
    use TimestampableEntity;

    public const TYPE_ONLINE = 'online';
    public const TYPE_OFFLINE = 'offline';

    #[ORM\Column(type: 'string', length: 255, nullable: false, options: ['comment' => 'Event`s title'])]
    private string $title;

    #[ORM\Column(type: 'datetime_immutable', nullable: false)]
    private \DateTimeInterface $date;

    #[ORM\Column(type: 'string', length: 1024, nullable: true, options: ['comment' => 'Условия участия'])]
    private ?string $participationTerms;

    #[ORM\Column(type: 'string', length: 255, nullable: true, options: ['comment' => 'type of event'])]
    private ?string $type;

    #[ORM\Column(type: 'string', length: 1024, nullable: true, options: ['comment' => 'Детали'])]
    private ?string $details;

    #[ORM\ManyToOne(targetEntity: City::class)]
    #[ORM\JoinColumn(nullable: true)]
    private City $city;

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

    #[ORM\OneToOne(targetEntity: File::class)]
    #[ORM\JoinColumn(onDelete: 'SET NULL')]
    private ?File $avatar;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getParticipationTerms(): ?string
    {
        return $this->participationTerms;
    }

    public function setParticipationTerms(?string $participationTerms): self
    {
        $this->participationTerms = $participationTerms;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function getCity(): City
    {
        return $this->city;
    }

    public function setCity(City $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getStreetNumber(): ?int
    {
        return $this->streetNumber;
    }

    public function setStreetNumber(?int $streetNumber): self
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    public function getPlaceTitle(): ?string
    {
        return $this->placeTitle;
    }

    public function setPlaceTitle(?string $placeTitle): self
    {
        $this->placeTitle = $placeTitle;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getAvatar(): ?File
    {
        return $this->avatar;
    }

    public function setAvatar(?File $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }
}
