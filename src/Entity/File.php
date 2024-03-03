<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity]
#[ORM\Table(name: 'files')]
class File extends AbstractBaseUuidEntity
{
    use TimestampableEntity;

    #[ORM\Column(type: 'string', length: 255, nullable: false, options: ['comment' => 'Cloud id'])]
    private string $externalId;

    #[ORM\Column(type: 'string', length: 512, nullable: false, options: ['comment' => 'url'])]
    private string $url;

    public function getExternalId(): string
    {
        return $this->externalId;
    }

    public function setExternalId(string $externalId): self
    {
        $this->externalId = $externalId;

        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }
}
