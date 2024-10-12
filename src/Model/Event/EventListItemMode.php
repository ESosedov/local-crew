<?php

namespace App\Model\Event;

use App\Model\File\FileModel;
use App\Model\Location\LocationModel;

class EventListItemMode
{
    public function __construct(
        private string $id,
        private string $title,
        private \DateTimeInterface $date,
        private string $timeZone,
        private string $type,
        private ?string $participationTerms,
        private ?string $details,
        private ?int $countMembersMax,
        /** @var array<string> */
        private array $category = [],
        private ?int $countMembers = null,
        private bool $isFavorite = false,
        private ?FileModel $avatar = null,
        private ?LocationModel $location = null,
        /** @var bool[] */
        private array $frontendOptions = [],
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

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

    public function getTimeZone(): string
    {
        return $this->timeZone;
    }

    public function setTimeZone(string $timeZone): self
    {
        $this->timeZone = $timeZone;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function isFavorite(): bool
    {
        return $this->isFavorite;
    }

    public function setIsFavorite(bool $isFavorite): self
    {
        $this->isFavorite = $isFavorite;

        return $this;
    }

    public function getCountMembersMax(): ?int
    {
        return $this->countMembersMax;
    }

    public function setCountMembersMax(?int $countMembersMax): self
    {
        $this->countMembersMax = $countMembersMax;

        return $this;
    }

    public function getCountMembers(): ?int
    {
        return $this->countMembers;
    }

    public function setCountMembers(?int $countMembers): self
    {
        $this->countMembers = $countMembers;

        return $this;
    }

    public function getAvatar(): ?FileModel
    {
        return $this->avatar;
    }

    public function setAvatar(?FileModel $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getCategory(): array
    {
        return $this->category;
    }

    public function setCategory(array $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getLocation(): ?LocationModel
    {
        return $this->location;
    }

    public function setLocation(?LocationModel $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getFrontendOptions(): array
    {
        return $this->frontendOptions;
    }

    public function setFrontendOptions(array $frontendOptions): self
    {
        $this->frontendOptions = $frontendOptions;

        return $this;
    }
}
