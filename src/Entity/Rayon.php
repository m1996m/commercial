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
     * @ORM\OneToMany(targetEntity=Vente::class, mappedBy="rayon")
     */
    private $ventes;

    /**
     * @ORM\OneToMany(targetEntity=Produitvendu::class, mappedBy="rayon")
     */
    private $produitvendus;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=ProduitStock::class, inversedBy="rayons")
     */
    private $produitStock;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="rayons")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=TypeRayon::class, inversedBy="rayons")
     */
    private $type;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getProduitStock(): ?ProduitStock
    {
        return $this->produitStock;
    }

    public function setProduitStock(?ProduitStock $produitStock): self
    {
        $this->produitStock = $produitStock;

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

    public function getType(): ?TypeRayon
    {
        return $this->type;
    }

    public function setType(?TypeRayon $type): self
    {
        $this->type = $type;

        return $this;
    }
}
