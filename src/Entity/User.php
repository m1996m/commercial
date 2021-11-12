<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $fonction;

    /**
     * @ORM\ManyToOne(targetEntity=Centre::class, inversedBy="users")
     */
    private $centre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=Rayon::class, mappedBy="user")
     */
    private $rayons;

    /**
     * @ORM\Column(type="integer")
     */
    private $first;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $actif;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    public function __construct()
    {
        $this->rayons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
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

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    public function setFonction(string $fonction): self
    {
        $this->fonction = $fonction;

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
            $rayon->setUser($this);
        }

        return $this;
    }

    public function removeRayon(Rayon $rayon): self
    {
        if ($this->rayons->removeElement($rayon)) {
            // set the owning side to null (unless already changed)
            if ($rayon->getUser() === $this) {
                $rayon->setUser(null);
            }
        }

        return $this;
    }

    public function getFirst(): ?int
    {
        return $this->first;
    }

    public function setFirst(int $first): self
    {
        $this->first = $first;

        return $this;
    }

    public function getActif(): ?string
    {
        return $this->actif;
    }

    public function setActif(string $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
