<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $city;

    #[ORM\Column(type: 'string', length: 255)]
    private $color;

    #[ORM\OneToMany(mappedBy: 'team', targetEntity: Players::class)]
    private $players;

    #[ORM\ManyToOne(targetEntity: competition::class, inversedBy: 'teams')]
    private $competition;

    public function __construct()
    {
        $this->players = new ArrayCollection();
    }

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

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return Collection<int, Players>
     */
    public function getPlayerss(): Collection
    {
        return $this->playerss;
    }

    public function addPlayer(Players $players): self
    {
        if (!$this->playerss->contains($players)) {
            $this->playerss[] = $players;
            $players->setTeam($this);
        }

        return $this;
    }

    public function removePlayer(Players $players): self
    {
        if ($this->playerss->removeElement($players)) {
            // set the owning side to null (unless already changed)
            if ($players->getTeam() === $this) {
                $players->setTeam(null);
            }
        }

        return $this;
    }

    public function getCompetition(): ?competition
    {
        return $this->competition;
    }

    public function setCompetition(?competition $competition): self
    {
        $this->competition = $competition;

        return $this;
    }
}
