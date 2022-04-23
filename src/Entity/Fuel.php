<?php

namespace App\Entity;

use App\Repository\FuelRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FuelRepository::class)]
class Fuel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $fuelAt;

    #[ORM\Column(type: 'integer')]
    private $quantity;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private $amount;

    #[ORM\Column(type: 'decimal', precision: 6, scale: 2, nullable: true)]
    private $unit_price;

    #[ORM\ManyToOne(targetEntity: Logbook::class, inversedBy: 'fuels')]
    private $logbook;

    #[ORM\ManyToOne(targetEntity: FuelType::class, inversedBy: 'fuel')]
    #[ORM\JoinColumn(nullable: false)]
    private $fuelType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFuelAt(): ?\DateTimeInterface
    {
        return $this->fuelAt;
    }

    public function setFuelAt(\DateTimeInterface $fuelAt): self
    {
        $this->fuelAt = $fuelAt;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getUnitPrice(): ?string
    {
        return $this->unit_price;
    }

    public function setUnitPrice(?string $unit_price): self
    {
        $this->unit_price = $unit_price;

        return $this;
    }

    public function getLogbook(): ?Logbook
    {
        return $this->logbook;
    }

    public function setLogbook(?Logbook $logbook): self
    {
        $this->logbook = $logbook;

        return $this;
    }

    public function getFuelType(): ?FuelType
    {
        return $this->fuelType;
    }

    public function setFuelType(?FuelType $fuelType): self
    {
        $this->fuelType = $fuelType;

        return $this;
    }
}
