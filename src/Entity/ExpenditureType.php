<?php

namespace App\Entity;

use App\Repository\ExpenditureTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExpenditureTypeRepository::class)]
class ExpenditureType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $name;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private $color;

    #[ORM\OneToMany(mappedBy: 'expenditureType', targetEntity: Expenditure::class)]
    private $expenditure;

    public function __construct()
    {
        $this->expenditure = new ArrayCollection();
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

    /**
     * @return Collection<int, Expenditure>
     */
    public function getExpenditure(): Collection
    {
        return $this->expenditure;
    }

    public function addExpenditure(Expenditure $expenditure): self
    {
        if (!$this->expenditure->contains($expenditure)) {
            $this->expenditure[] = $expenditure;
            $expenditure->setExpenditureType($this);
        }

        return $this;
    }

    public function removeExpenditure(Expenditure $expenditure): self
    {
        if ($this->expenditure->removeElement($expenditure)) {
            // set the owning side to null (unless already changed)
            if ($expenditure->getExpenditureType() === $this) {
                $expenditure->setExpenditureType(null);
            }
        }

        return $this;
    }
}
