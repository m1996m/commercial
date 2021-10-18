<?php

namespace App\Entity;

use App\Repository\RayonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RayonRepository::class)
 */
class Rayon
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=Vente::class, mappedBy="rayon")
     */
    private $ventes;

    /**
     * @ORM\OneToMany(targetEntity=Produitvendu::class, mappedBy="rayon")
     */
    private $produitvendus;

    public function __construct()
    {
        $this->produitvendus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    } 

    /**
     * @return Collection|Produitvendu[]
     */
    public function getProduitvendus(): Collection
    {
        return $this->produitvendus;
    }

    public function addProduitvendu(Produitvendu $produitvendu): self
    {
        if (!$this->produitvendus->contains($produitvendu)) {
            $this->produitvendus[] = $produitvendu;
            $produitvendu->setRayon($this);
        }

        return $this;
    }

    public function removeProduitvendu(Produitvendu $produitvendu): self
    {
        if ($this->produitvendus->removeElement($produitvendu)) {
            // set the owning side to null (unless already changed)
            if ($produitvendu->getRayon() === $this) {
                $produitvendu->setRayon(null);
            }
        }

        return $this;
    }
}
