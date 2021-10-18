<?php

namespace App\Entity;

use App\Repository\FournisseurCentreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FournisseurCentreRepository::class)
 */
class FournisseurCentre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Fournisseur::class, inversedBy="fournisseurCentres")
     */
    private $fournisseur;

    /**
     * @ORM\ManyToOne(targetEntity=Centre::class, inversedBy="fournisseurCentres")
     */
    private $centre;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCentre(): ?Centre
    {
        return $this->centre;
    }

    public function setCentre(?Centre $centre): self
    {
        $this->centre = $centre;

        return $this;
    }
}
