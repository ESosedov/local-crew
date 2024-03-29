<?php

namespace App\Model\Event;

use App\Model\User\ShortModel;

class EventResponseModel
{
    public function __construct(
        private string $id,
        private string $title,
        private \DateTimeInterface $date,
        private string $type,
        private string|null $participationTerms,
        private string|null $details,
        private string|null $avatar,
        private ShortModel $organizer,
        /** @var ShortModel[] */
        private array $members,
        /** @var ShortModel[] */
        private array $candidates,
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

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function getOrganizer(): ShortModel
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
}
