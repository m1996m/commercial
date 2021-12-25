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
     * @ORM\OneToMany(targetEntity=Produitvendu::class, mappedBy="vente")
     */
    private $produitvendus;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="ventes")
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="ventes")
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $remise;

    public function __construct()
    {
        $this->produitvendus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

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

    public function getRemise(): ?int
    {
        return $this->remise;
    }

    public function setRemise(int $remise): self
    {
        $this->remise = $remise;

        return $this;
    }
}
