<?php

namespace App\Model\Event;

use App\Model\User\PublicModel;
use App\Model\User\ShortModel;
use Symfony\Component\Serializer\Annotation\SerializedName;

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
        private PublicModel $organizer,
        /** @var ShortModel[] */
        private array $members,
        /** @var ShortModel[] */
        private array $candidates,
        private int|null $countMembersMax,
        /** @var string[] */
        private array $category,
        private bool $isFavorite,
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

    public function getOrganizer(): PublicModel
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
}
