<?php

namespace App\Entity;

use App\Repository\ProduitStockRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\ManyToOne(targetEntity=Stock::class, inversedBy="produitStocks")
     */
    private $stock;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\OneToMany(targetEntity=Rayon::class, mappedBy="produitStock")
     */
    private $rayons;

    public function __construct()
    {
        $this->rayons = new ArrayCollection();
    }

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

    public function getStock(): ?Stock
    {
        return $this->stock;
    }

    public function setStock(?Stock $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

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
            $rayon->setProduitStock($this);
        }

        return $this;
    }

    public function removeRayon(Rayon $rayon): self
    {
        if ($this->rayons->removeElement($rayon)) {
            // set the owning side to null (unless already changed)
            if ($rayon->getProduitStock() === $this) {
                $rayon->setProduitStock(null);
            }
        }

        return $this;
    }
}
