<?php

namespace App\Entity;

use App\Repository\ProduitvenduRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProduitvenduRepository::class)
 */
class Produitvendu
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Vente::class, inversedBy="produitvendus")
     */
    private $vente;

    /**
     * @ORM\ManyToOne(targetEntity=Rayon::class, inversedBy="produitvendus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $rayon;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVente(): ?Vente
    {
        return $this->vente;
    }

    public function setVente(?Vente $vente): self
    {
        $this->vente = $vente;

        return $this;
    }

    public function getRayon(): ?Rayon
    {
        return $this->rayon;
    }

    public function setRayon(?Rayon $rayon): self
    {
        $this->rayon = $rayon;

        return $this;
    }
}
