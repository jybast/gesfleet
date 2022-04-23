<?php

namespace App\Entity;

use App\Repository\FuelTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FuelTypeRepository::class)]
class FuelType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $name;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private $color;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private $code;

    #[ORM\OneToMany(mappedBy: 'fuelType', targetEntity: Fuel::class)]
    private $fuel;

    public function __construct()
    {
        $this->fuel = new ArrayCollection();
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

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection<int, Fuel>
     */
    public function getFuel(): Collection
    {
        return $this->fuel;
    }

    public function addFuel(Fuel $fuel): self
    {
        if (!$this->fuel->contains($fuel)) {
            $this->fuel[] = $fuel;
            $fuel->setFuelType($this);
        }

        return $this;
    }

    public function removeFuel(Fuel $fuel): self
    {
        if ($this->fuel->removeElement($fuel)) {
            // set the owning side to null (unless already changed)
            if ($fuel->getFuelType() === $this) {
                $fuel->setFuelType(null);
            }
        }

        return $this;
    }
}
