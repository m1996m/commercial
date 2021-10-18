<?php

namespace App\Entity;

use App\Repository\ProduitStockRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProduitStockRepository::class)
 */
class ProduitStock
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $PUA;

    /**
     * @ORM\Column(type="float")
     */
    private $PUV;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class, inversedBy="produitStocks")
     */
    private $produit;

    /**
     * @ORM\ManyToOne(targetEntity=Fournisseur::class, inversedBy="produitStocks")
     */
    private $fournisseur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPUA(): ?float
    {
        return $this->PUA;
    }

    public function setPUA(float $PUA): self
    {
        $this->PUA = $PUA;

        return $this;
    }

    public function getPUV(): ?float
    {
        return $this->PUV;
    }

    public function setPUV(float $PUV): self
    {
        $this->PUV = $PUV;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getFournisseur(): ?Fournisseur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Fournisseur $fournisseur): self
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }
}
