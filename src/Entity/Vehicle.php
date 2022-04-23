<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
class Vehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 10)]
    private $numberplate;

    #[ORM\Column(type: 'string', length: 50)]
    private $brand;

    #[ORM\Column(type: 'string', length: 50)]
    private $model;

    #[ORM\Column(type: 'integer')]
    private $odometer;

    #[ORM\Column(type: 'string', length: 15)]
    private $energy;

    #[ORM\OneToMany(mappedBy: 'vehicle', targetEntity: Servicing::class)]
    private $servicings;

    public function __construct()
    {
        $this->servicings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberplate(): ?string
    {
        return $this->numberplate;
    }

    public function setNumberplate(string $numberplate): self
    {
        $this->numberplate = $numberplate;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getOdometer(): ?int
    {
        return $this->odometer;
    }

    public function setOdometer(int $odometer): self
    {
        $this->odometer = $odometer;

        return $this;
    }

    public function getEnergy(): ?string
    {
        return $this->energy;
    }

    public function setEnergy(string $energy): self
    {
        $this->energy = $energy;

        return $this;
    }

    /**
     * @return Collection<int, Servicing>
     */
    public function getServicings(): Collection
    {
        return $this->servicings;
    }

    public function addServicing(Servicing $servicing): self
    {
        if (!$this->servicings->contains($servicing)) {
            $this->servicings[] = $servicing;
            $servicing->setVehicle($this);
        }

        return $this;
    }

    public function removeServicing(Servicing $servicing): self
    {
        if ($this->servicings->removeElement($servicing)) {
            // set the owning side to null (unless already changed)
            if ($servicing->getVehicle() === $this) {
                $servicing->setVehicle(null);
            }
        }

        return $this;
    }
}
