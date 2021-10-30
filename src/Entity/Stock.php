<?php

namespace App\Entity;

use App\Repository\StockRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=StockRepository::class)
 */
class Stock
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\ManyToOne(targetEntity=Centre::class, inversedBy="stocks")
     */
    private $centre;

    /**
     * @ORM\OneToMany(targetEntity=ProduitStock::class, mappedBy="stock")
     */
    private $produitStocks;

    /**
     * @Gedmo\Slug(fields={"nom"})
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    public function __construct()
    {
        $this->produitStocks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

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
            $produitStock->setStock($this);
        }

        return $this;
    }

    public function removeProduitStock(ProduitStock $produitStock): self
    {
        if ($this->produitStocks->removeElement($produitStock)) {
            // set the owning side to null (unless already changed)
            if ($produitStock->getStock() === $this) {
                $produitStock->setStock(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
