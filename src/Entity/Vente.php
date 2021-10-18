<?php

namespace App\Entity;

use App\Repository\VenteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VenteRepository::class)
 */
class Vente
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=Produitvendu::class, mappedBy="vente")
     */
    private $produitvendus;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    public function __construct()
    {
        $this->produitvendus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $produitvendu->setVente($this);
        }

        return $this;
    }

    public function removeProduitvendu(Produitvendu $produitvendu): self
    {
        if ($this->produitvendus->removeElement($produitvendu)) {
            // set the owning side to null (unless already changed)
            if ($produitvendu->getVente() === $this) {
                $produitvendu->setVente(null);
            }
        }

        return $this;
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
}
