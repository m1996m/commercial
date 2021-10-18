<?php

namespace App\Entity;

use App\Repository\FournisseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FournisseurRepository::class)
 */
class Fournisseur
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
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tel;

    /**
     * @ORM\ManyToOne(targetEntity=Centre::class, inversedBy="fournisseurs")
     */
    private $centre;

    /**
     * @ORM\OneToMany(targetEntity=FournisseurCentre::class, mappedBy="fournisseur")
     */
    private $fournisseurCentres;

    /**
     * @ORM\OneToMany(targetEntity=ProduitStock::class, mappedBy="fournisseur")
     */
    private $produitStocks;

    public function __construct()
    {
        $this->fournisseurCentres = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

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

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

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
     * @return Collection|FournisseurCentre[]
     */
    public function getFournisseurCentres(): Collection
    {
        return $this->fournisseurCentres;
    }

    public function addFournisseurCentre(FournisseurCentre $fournisseurCentre): self
    {
        if (!$this->fournisseurCentres->contains($fournisseurCentre)) {
            $this->fournisseurCentres[] = $fournisseurCentre;
            $fournisseurCentre->setFournisseur($this);
        }

        return $this;
    }

    public function removeFournisseurCentre(FournisseurCentre $fournisseurCentre): self
    {
        if ($this->fournisseurCentres->removeElement($fournisseurCentre)) {
            // set the owning side to null (unless already changed)
            if ($fournisseurCentre->getFournisseur() === $this) {
                $fournisseurCentre->setFournisseur(null);
            }
        }

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
            $produitStock->setFournisseur($this);
        }

        return $this;
    }

    public function removeProduitStock(ProduitStock $produitStock): self
    {
        if ($this->produitStocks->removeElement($produitStock)) {
            // set the owning side to null (unless already changed)
            if ($produitStock->getFournisseur() === $this) {
                $produitStock->setFournisseur(null);
            }
        }

        return $this;
    }
}
