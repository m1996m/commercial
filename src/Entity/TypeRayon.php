<?php

namespace App\Entity;

use App\Repository\TypeRayonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeRayonRepository::class)
 */
class TypeRayon
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $designation;

    /**
     * @ORM\OneToMany(targetEntity=Rayon::class, mappedBy="type")
     */
    private $rayons;

    /**
     * @ORM\ManyToOne(targetEntity=Centre::class, inversedBy="typeRayons")
     */
    private $centre;

    public function __construct()
    {
        $this->rayons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * @return Collection|Rayon[]
     */
    public function getRayons(): Collection
    {
        return $this->rayons;
    }

    public function addRayon(Rayon $rayon): self
    {
        if (!$this->rayons->contains($rayon)) {
            $this->rayons[] = $rayon;
            $rayon->setType($this);
        }

        return $this;
    }

    public function removeRayon(Rayon $rayon): self
    {
        if ($this->rayons->removeElement($rayon)) {
            // set the owning side to null (unless already changed)
            if ($rayon->getType() === $this) {
                $rayon->setType(null);
            }
        }

        return $this;
    }

    public function getCentre(): ?Centre
    {
        return $this->centre;
    }

    public function setCentre(?Centre $centre): self
    {
        $this->centre = $centre;

        return $this;
    }
}
