<?php

namespace App\Entity;

use App\Entity\Traits\CreatedTrait;
use App\Entity\Traits\UpdatedTrait;
use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
#[ORM\Table(name: 'events')]
#[ORM\Index(columns: ['date'], name: 'date_idx')]
#[ORM\Index(columns: ['created_at'], name: 'created_at_idx')]
class Event extends AbstractBaseUuidEntity
{
    use CreatedTrait;
    use UpdatedTrait;

    public const TYPE_ONLINE = 'online';
    public const TYPE_LOCAL = 'local';

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->members = new ArrayCollection();
        $this->requests = new ArrayCollection();
    }

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

    #[ORM\OneToOne(targetEntity: Location::class)]
    #[ORM\JoinColumn(nullable: true)]
    private Location|null $location = null;

    #[ORM\OneToOne(targetEntity: File::class)]
    #[ORM\JoinColumn(onDelete: 'SET NULL')]
    private ?File $avatar;

    #[ORM\Column(type: 'integer', nullable: true)]
    private int|null $countMembersMax;

    #[ORM\ManyToMany(targetEntity: Category::class)]
    #[ORM\JoinTable(name: 'category_evens')]
    #[ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'event_id', referencedColumnName: 'id')]
    private Collection $categories;

    #[ORM\OneToMany(mappedBy: 'event', targetEntity: EventMember::class)]
    private Collection $members;

    #[ORM\OneToMany(mappedBy: 'event', targetEntity: EventRequest::class)]
    private Collection $requests;

    #[ORM\Column(type: 'string', length: 55, nullable: true)]
    private string|null $timeZone = null;

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

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

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

    public function getCountMembersMax(): ?int
    {
        return $this->countMembersMax;
    }

    public function setCountMembersMax(?int $countMembersMax): self
    {
        $this->countMembersMax = $countMembersMax;

        return $this;
    }

    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): void
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }
    }

    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function getRequests(): Collection
    {
        return $this->requests;
    }

    public function addRequest(EventRequest $request): void
    {
        if (!$this->requests->contains($request)) {
            $this->requests->add($request);
        }
    }

    public function getTimeZone(): ?string
    {
        return $this->timeZone;
    }

    public function setTimeZone(?string $timeZone): self
    {
        $this->timeZone = $timeZone;

        return $this;
    }
}
