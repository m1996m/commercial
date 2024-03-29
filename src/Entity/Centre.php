<?php

namespace App\Entity;

use App\Repository\CentreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=CentreRepository::class)
 */
class Centre
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
     * @ORM\Column(type="string", length=255)
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pays;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="centre")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=ClientCentre::class, mappedBy="centre")
     */
    private $clientCentres;

    /**
     * @ORM\OneToMany(targetEntity=FournisseurCentre::class, mappedBy="centre")
     */
    private $fournisseurCentres;

    /**
     * @ORM\OneToMany(targetEntity=Stock::class, mappedBy="centre")
     */
    private $stocks;

    /**
     * @Gedmo\Slug(fields={"tel","nom"})
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=TypeProduit::class, mappedBy="centre")
     */
    private $typeProduits;

    /**
     * @ORM\OneToMany(targetEntity=TypeRayon::class, mappedBy="centre")
     */
    private $typeRayons;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $domaine;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cp;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deleteAt;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->fournisseurs = new ArrayCollection();
        $this->clientCentres = new ArrayCollection();
        $this->fournisseurCentres = new ArrayCollection();
        $this->stocks = new ArrayCollection();
        $this->typeProduits = new ArrayCollection();
        $this->typeRayons = new ArrayCollection();
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

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(?string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setCentre($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getCentre() === $this) {
                $user->setCentre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ClientCentre[]
     */
    public function getClientCentres(): Collection
    {
        return $this->clientCentres;
    }

    public function addClientCentre(ClientCentre $clientCentre): self
    {
        if (!$this->clientCentres->contains($clientCentre)) {
            $this->clientCentres[] = $clientCentre;
            $clientCentre->setCentre($this);
        }

        return $this;
    }

    public function removeClientCentre(ClientCentre $clientCentre): self
    {
        if ($this->clientCentres->removeElement($clientCentre)) {
            // set the owning side to null (unless already changed)
            if ($clientCentre->getCentre() === $this) {
                $clientCentre->setCentre(null);
            }
        }

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
            $fournisseurCentre->setCentre($this);
        }

        return $this;
    }

    public function removeFournisseurCentre(FournisseurCentre $fournisseurCentre): self
    {
        if ($this->fournisseurCentres->removeElement($fournisseurCentre)) {
            // set the owning side to null (unless already changed)
            if ($fournisseurCentre->getCentre() === $this) {
                $fournisseurCentre->setCentre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Stock[]
     */
    public function getStocks(): Collection
    {
        return $this->stocks;
    }

    public function addStock(Stock $stock): self
    {
        if (!$this->stocks->contains($stock)) {
            $this->stocks[] = $stock;
            $stock->setCentre($this);
        }

        return $this;
    }

    public function removeStock(Stock $stock): self
    {
        if ($this->stocks->removeElement($stock)) {
            // set the owning side to null (unless already changed)
            if ($stock->getCentre() === $this) {
                $stock->setCentre(null);
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

    /**
     * @return Collection|TypeProduit[]
     */
    public function getTypeProduits(): Collection
    {
        return $this->typeProduits;
    }

    public function addTypeProduit(TypeProduit $typeProduit): self
    {
        if (!$this->typeProduits->contains($typeProduit)) {
            $this->typeProduits[] = $typeProduit;
            $typeProduit->setCentre($this);
        }

        return $this;
    }

    public function removeTypeProduit(TypeProduit $typeProduit): self
    {
        if ($this->typeProduits->removeElement($typeProduit)) {
            // set the owning side to null (unless already changed)
            if ($typeProduit->getCentre() === $this) {
                $typeProduit->setCentre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TypeRayon[]
     */
    public function getTypeRayons(): Collection
    {
        return $this->typeRayons;
    }

    public function addTypeRayon(TypeRayon $typeRayon): self
    {
        if (!$this->typeRayons->contains($typeRayon)) {
            $this->typeRayons[] = $typeRayon;
            $typeRayon->setCentre($this);
        }

        return $this;
    }

    public function removeTypeRayon(TypeRayon $typeRayon): self
    {
        if ($this->typeRayons->removeElement($typeRayon)) {
            // set the owning side to null (unless already changed)
            if ($typeRayon->getCentre() === $this) {
                $typeRayon->setCentre(null);
            }
        }

        return $this;
    }

    public function getDomaine(): ?string
    {
        return $this->domaine;
    }

    public function setDomaine(?string $domaine): self
    {
        $this->domaine = $domaine;

        return $this;
    }

    public function getCp(): ?string
    {
        return $this->cp;
    }

    public function setCp(?string $cp): self
    {
        $this->cp = $cp;

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
}
