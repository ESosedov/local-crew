<?php

namespace App\Model\Event;

use App\Entity\Event;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class CreateEventModel
{
    private string $title;
    private \DateTime $date;
    private string $type;
    /**
     * @var string[]
     */
    private array $categories;
    private string|null $participationTerms = null;
    private string|null $details = null;
    private UploadedFile|null $avatar = null;
    private int|null $countMembersMax = null;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getParticipationTerms(): ?string
    {
        return $this->participationTerms;
    }

    public function setParticipationTerms(?string $participationTerms): void
    {
        $this->participationTerms = $participationTerms;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): void
    {
        $this->details = $details;
    }

    public function getAvatar(): ?UploadedFile
    {
        return $this->avatar;
    }

    public function setAvatar(?UploadedFile $avatar): void
    {
        $this->avatar = $avatar;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function setCategories(array $categories): self
    {
        $this->categories = $categories;

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
}
