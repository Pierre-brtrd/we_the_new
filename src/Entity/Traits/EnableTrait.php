<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

trait EnableTrait
{   
    #[Groups(['read'])]
    #[ORM\Column(type: 'boolean')]
    private ?bool $enable = null;

    public function isEnable(): ?bool
    {
        return $this->enable;
    }

    public function setEnable(bool $enable): static
    {
        $this->enable = $enable;

        return $this;
    }
}
