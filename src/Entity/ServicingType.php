<?php

namespace App\Entity;

use App\Repository\ServicingTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServicingTypeRepository::class)]
class ServicingType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 10)]
    private $code;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private $color;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Servicing::class)]
    private $servicings;

    public function __construct()
    {
        $this->servicings = new ArrayCollection();
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

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
            $servicing->setType($this);
        }

        return $this;
    }

    public function removeServicing(Servicing $servicing): self
    {
        if ($this->servicings->removeElement($servicing)) {
            // set the owning side to null (unless already changed)
            if ($servicing->getType() === $this) {
                $servicing->setType(null);
            }
        }

        return $this;
    }
}
