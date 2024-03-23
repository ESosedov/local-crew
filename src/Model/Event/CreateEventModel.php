<?php

namespace App\Model\Event;

use App\Entity\Event;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class CreateEventModel
{
    #[Assert\Length(min: 3, max: 50)]
    #[Assert\NotNull]
    private string $title;
    #[Assert\NotNull]
    private \DateTimeInterface $date;
    #[Assert\Choice([Event::TYPE_ONLINE])]
    #[Assert\NotNull]
    private string $type;
    private string|null $participationTerms = null;
    private string|null $details = null;
    private UploadedFile|null $avatar = null;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): void
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
}
