<?php

namespace App\Entity;

use App\Repository\ExpenditureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExpenditureRepository::class)]
class Expenditure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'date')]
    private $createdAt;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private $amount;

    #[ORM\ManyToOne(targetEntity: Logbook::class, inversedBy: 'expenditures')]
    #[ORM\JoinColumn(nullable: false)]
    private $travel;

    #[ORM\ManyToOne(targetEntity: ExpenditureType::class, inversedBy: 'expenditure')]
    #[ORM\JoinColumn(nullable: false)]
    private $expenditureType;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

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

    public function getTravel(): ?Logbook
    {
        return $this->travel;
    }

    public function setTravel(?Logbook $travel): self
    {
        $this->travel = $travel;

        return $this;
    }

    public function getExpenditureType(): ?ExpenditureType
    {
        return $this->expenditureType;
    }

    public function setExpenditureType(?ExpenditureType $expenditureType): self
    {
        $this->expenditureType = $expenditureType;

        return $this;
    }
}
