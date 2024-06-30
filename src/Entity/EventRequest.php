<?php

namespace App\Entity;

use App\Entity\Traits\CreatedTrait;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\UpdatedTrait;
use App\Repository\EventRequestRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRequestRepository::class)]
#[ORM\Table(name: 'event_requests')]
class EventRequest extends AbstractBaseUuidEntity
{
    use IdTrait;
    use CreatedTrait;
    use UpdatedTrait;

    public const STATUS_NEW = 'new';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECT = 'reject';

    #[ORM\ManyToOne(targetEntity: Event::class, inversedBy: 'requests')]
    #[ORM\JoinColumn(nullable: false)]
    private Event $event;

    #[ORM\Column(type: 'string', length: 50, nullable: false, options: ['comment' => 'Статус запроса'])]
    private string $status;

    public function getEvent(): Event
    {
        return $this->event;
    }

    public function setEvent(Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
