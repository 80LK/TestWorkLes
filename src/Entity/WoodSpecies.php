<?php

namespace App\Entity;

use App\Repository\WoodSpeciesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WoodSpeciesRepository::class)
 */
class WoodSpecies
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy = "IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
