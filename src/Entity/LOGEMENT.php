<?php

namespace App\Entity;

use App\Repository\LOGEMENTRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LOGEMENTRepository::class)]
class LOGEMENT
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $Adresse;

    #[ORM\Column(type: 'string', length: 255)]
    private $Ville;

    #[ORM\Column(type: 'float')]
    private $CodePostal;

    #[ORM\Column(type: 'float')]
    private $PersMax;

    #[ORM\Column(type: 'string', length: 255)]
    private $Description;

    #[ORM\Column(type: 'boolean')]
    private $Etat;

    #[ORM\OneToMany(mappedBy: 'Logements', targetEntity: RESERVATION::class)]
    private $Reservations;

    public function __construct()
    {
        $this->Reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }

    public function setAdresse(string $Adresse): self
    {
        $this->Adresse = $Adresse;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->Ville;
    }

    public function setVille(string $Ville): self
    {
        $this->Ville = $Ville;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->CodePostal;
    }

    public function setCodePostal(string $CodePostal): self
    {
        $this->CodePostal = $CodePostal;

        return $this;
    }

    public function getPersMax(): ?float
    {
        return $this->PersMax;
    }

    public function setPersMax(float $PersMax): self
    {
        $this->PersMax = $PersMax;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getEtat(): ?bool
    {
        return $this->Etat;
    }

    public function setEtat(bool $Etat): self
    {
        $this->Etat = $Etat;

        return $this;
    }

    /**
     * @return Collection|RESERVATION[]
     */
    public function getReservations(): Collection
    {
        return $this->Reservations;
    }

    public function addReservation(RESERVATION $reservation): self
    {
        if (!$this->Reservations->contains($reservation)) {
            $this->Reservations[] = $reservation;
            $reservation->setLogements($this);
        }

        return $this;
    }

    public function removeReservation(RESERVATION $reservation): self
    {
        if ($this->Reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getLogements() === $this) {
                $reservation->setLogements(null);
            }
        }

        return $this;
    }
}
