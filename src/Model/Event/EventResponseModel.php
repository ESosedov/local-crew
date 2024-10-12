<?php

namespace App\Model\Event;

use App\Model\File\FileModel;
use App\Model\Location\LocationModel;
use App\Model\User\CandidateModel;
use App\Model\User\UserPublicModel;
use Symfony\Component\Serializer\Annotation\SerializedName;

class EventResponseModel
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
        /** @var string[] */
        private array $category = [],
        private bool $isFavorite = false,
        private ?FileModel $avatar = null,
        private ?UserPublicModel $organizer = null,
        /** @var UserPublicModel[] */
        private array $members = [],
        /** @var CandidateModel[] */
        private array $candidates = [],

        private ?LocationModel $location = null,
        /** @var bool[] */
        private array $frontendOptions = [],
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function getTimeZone(): string
    {
        return $this->timeZone;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getParticipationTerms(): ?string
    {
        return $this->participationTerms;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function getAvatar(): ?FileModel
    {
        return $this->avatar;
    }

    public function getOrganizer(): UserPublicModel
    {
        return $this->organizer;
    }

    public function getMembers(): array
    {
        return $this->members;
    }

    public function getCandidates(): array
    {
        return $this->candidates;
    }

    public function getCountMembersMax(): ?int
    {
        return $this->countMembersMax;
    }

    public function getCategory(): array
    {
        return $this->category;
    }

    #[SerializedName('isFavorite')]
    public function isFavorite(): bool
    {
        return $this->isFavorite;
    }

    public function getLocation(): ?LocationModel
    {
        return $this->location;
    }

    public function getFrontendOptions(): array
    {
        return $this->frontendOptions;
    }

    public function setIsFavorite(bool $isFavorite): self
    {
        $this->isFavorite = $isFavorite;

        return $this;
    }

    public function setAvatar(?FileModel $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function setOrganizer(?UserPublicModel $organizer): self
    {
        $this->organizer = $organizer;

        return $this;
    }

    public function setMembers(array $members): self
    {
        $this->members = $members;

        return $this;
    }

    public function setCandidates(array $candidates): self
    {
        $this->candidates = $candidates;

        return $this;
    }

    public function setCategory(array $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function setLocation(?LocationModel $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function setFrontendOptions(array $frontendOptions): self
    {
        $this->frontendOptions = $frontendOptions;

        return $this;
    }
}
