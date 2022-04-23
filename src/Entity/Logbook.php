<?php

namespace App\Entity;

use App\Repository\LogbookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogbookRepository::class)]
class Logbook
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 10)]
    private $numberplate;

    #[ORM\Column(type: 'string', length: 50)]
    private $departure;

    #[ORM\Column(type: 'string', length: 50)]
    private $arrival;

    #[ORM\Column(type: 'date')]
    private $travelAt;

    #[ORM\Column(type: 'integer')]
    private $distance;

    #[ORM\OneToMany(mappedBy: 'logbook', targetEntity: User::class)]
    private $driver;

    #[ORM\OneToMany(mappedBy: 'travel', targetEntity: Expenditure::class)]
    private $expenditures;

    #[ORM\OneToMany(mappedBy: 'logbook', targetEntity: Fuel::class)]
    private $fuels;

    public function __construct()
    {
        $this->driver = new ArrayCollection();
        $this->expenditures = new ArrayCollection();
        $this->fuels = new ArrayCollection();
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

    public function getDeparture(): ?string
    {
        return $this->departure;
    }

    public function setDeparture(string $departure): self
    {
        $this->departure = $departure;

        return $this;
    }

    public function getArrival(): ?string
    {
        return $this->arrival;
    }

    public function setArrival(string $arrival): self
    {
        $this->arrival = $arrival;

        return $this;
    }

    public function getTravelAt(): ?\DateTimeInterface
    {
        return $this->travelAt;
    }

    public function setTravelAt(\DateTimeInterface $travelAt): self
    {
        $this->travelAt = $travelAt;

        return $this;
    }

    public function getDistance(): ?int
    {
        return $this->distance;
    }

    public function setDistance(int $distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getDriver(): Collection
    {
        return $this->driver;
    }

    public function addDriver(User $driver): self
    {
        if (!$this->driver->contains($driver)) {
            $this->driver[] = $driver;
            $driver->setLogbook($this);
        }

        return $this;
    }

    public function removeDriver(User $driver): self
    {
        if ($this->driver->removeElement($driver)) {
            // set the owning side to null (unless already changed)
            if ($driver->getLogbook() === $this) {
                $driver->setLogbook(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Expenditure>
     */
    public function getExpenditures(): Collection
    {
        return $this->expenditures;
    }

    public function addExpenditure(Expenditure $expenditure): self
    {
        if (!$this->expenditures->contains($expenditure)) {
            $this->expenditures[] = $expenditure;
            $expenditure->setTravel($this);
        }

        return $this;
    }

    public function removeExpenditure(Expenditure $expenditure): self
    {
        if ($this->expenditures->removeElement($expenditure)) {
            // set the owning side to null (unless already changed)
            if ($expenditure->getTravel() === $this) {
                $expenditure->setTravel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Fuel>
     */
    public function getFuels(): Collection
    {
        return $this->fuels;
    }

    public function addFuel(Fuel $fuel): self
    {
        if (!$this->fuels->contains($fuel)) {
            $this->fuels[] = $fuel;
            $fuel->setLogbook($this);
        }

        return $this;
    }

    public function removeFuel(Fuel $fuel): self
    {
        if ($this->fuels->removeElement($fuel)) {
            // set the owning side to null (unless already changed)
            if ($fuel->getLogbook() === $this) {
                $fuel->setLogbook(null);
            }
        }

        return $this;
    }
}
