<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Produit
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
     * @ORM\ManyToOne(targetEntity=TypeProduit::class, inversedBy="produits")
     */
    private $type;

    /**
     * @ORM\Column(type="float")
     */
    private $PUA;

    /**
     * @ORM\Column(type="float")
     */
    private $PUV;

    /**
     * @ORM\OneToMany(targetEntity=ProduitStock::class, mappedBy="produit")
     */
    private $produitStocks;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $domaine;

    /**
     * @ORM\OneToMany(targetEntity=ProduitCommande::class, mappedBy="produit")
     */
    private $produitCommandes;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deleteAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imagePrincipal;


    public function __construct()
    {
        $this->produitStocks = new ArrayCollection();
        $this->produitCommandes = new ArrayCollection();
        $this->imageProduits = new ArrayCollection();
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

    public function getType(): ?TypeProduit
    {
        return $this->type;
    }

    public function setType(?TypeProduit $type): self
    {
        $this->type = $type;

        return $this;
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

    /**
     * @return Collection|ProduitStock[]
     */
    public function getProduitStocks(): Collection
    {
        return $this->produitStocks;
    }

    public function addProduitStock(ProduitStock $produitStock): self
    {
        if (!$this->produitStocks->contains($produitStock)) {
            $this->produitStocks[] = $produitStock;
            $produitStock->setProduit($this);
        }

        return $this;
    }

    public function removeProduitStock(ProduitStock $produitStock): self
    {
        if ($this->produitStocks->removeElement($produitStock)) {
            // set the owning side to null (unless already changed)
            if ($produitStock->getProduit() === $this) {
                $produitStock->setProduit(null);
            }
        }

        return $this;
    }

    public function getDomaine(): ?string
    {
        return $this->domaine;
    }

    public function setDomaine(string $domaine): self
    {
        $this->domaine = $domaine;

        return $this;
    }

    /**
     * @return Collection|ProduitCommande[]
     */
    public function getProduitCommandes(): Collection
    {
        return $this->produitCommandes;
    }

    public function addProduitCommande(ProduitCommande $produitCommande): self
    {
        if (!$this->produitCommandes->contains($produitCommande)) {
            $this->produitCommandes[] = $produitCommande;
            $produitCommande->setProduit($this);
        }

        return $this;
    }

    public function removeProduitCommande(ProduitCommande $produitCommande): self
    {
        if ($this->produitCommandes->removeElement($produitCommande)) {
            // set the owning side to null (unless already changed)
            if ($produitCommande->getProduit() === $this) {
                $produitCommande->setProduit(null);
            }
        }

        return $this;
    }

    public function getDeleteAt(): ?\DateTimeInterface
    {
        return $this->deleteAt;
    }

    public function setDeleteAt(?\DateTimeInterface $deleteAt): self
    {
        $this->deleteAt = $deleteAt;

        return $this;
    }

    public function getImagePrincipal(): ?string
    {
        return $this->imagePrincipal;
    }

    public function setImagePrincipal(?string $imagePrincipal): self
    {
        $this->imagePrincipal = $imagePrincipal;

        return $this;
    }

}
