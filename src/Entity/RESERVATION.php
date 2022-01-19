<?php

namespace App\Entity;

use App\Repository\RESERVATIONRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RESERVATIONRepository::class)]
class RESERVATION
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $DateDebut;

    #[ORM\Column(type: 'date')]
    private $DateFin;

    #[ORM\Column(type: 'float')]
    private $PrixNuit;

    #[ORM\Column(type: 'float')]
    private $PrixTotal;

    #[ORM\Column(type: 'float')]
    private $NbrAdulte;

    #[ORM\Column(type: 'float')]
    private $NbrEnfant;

    #[ORM\Column(type: 'boolean')]
    private $EtatContrat;

    #[ORM\ManyToOne(targetEntity: LOCATAIRE::class, inversedBy: 'Reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private $Locataires;

    #[ORM\ManyToOne(targetEntity: LOGEMENT::class, inversedBy: 'Reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private $Logements;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->DateDebut;
    }

    public function setDateDebut(\DateTimeInterface $DateDebut): self
    {
        $this->DateDebut = $DateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->DateFin;
    }

    public function setDateFin(\DateTimeInterface $DateFin): self
    {
        $this->DateFin = $DateFin;

        return $this;
    }

    public function getPrixNuit(): ?string
    {
        return $this->PrixNuit;
    }

    public function setPrixNuit(string $PrixNuit): self
    {
        $this->PrixNuit = $PrixNuit;

        return $this;
    }

    public function getPrixTotal(): ?string
    {
        return $this->PrixTotal;
    }

    public function setPrixTotal(string $PrixTotal): self
    {
        $this->PrixTotal = $PrixTotal;

        return $this;
    }

    public function getNbrAdulte(): ?float
    {
        return $this->NbrAdulte;
    }

    public function setNbrAdulte(float $NbrAdulte): self
    {
        $this->NbrAdulte = $NbrAdulte;

        return $this;
    }

    public function getNbrEnfant(): ?float
    {
        return $this->NbrEnfant;
    }

    public function setNbrEnfant(float $NbrEnfant): self
    {
        $this->NbrEnfant = $NbrEnfant;

        return $this;
    }

    public function getEtatContrat(): ?bool
    {
        return $this->EtatContrat;
    }

    public function setEtatContrat(bool $EtatContrat): self
    {
        $this->EtatContrat = $EtatContrat;

        return $this;
    }

    public function getLocataires(): ?LOCATAIRE
    {
        return $this->Locataires;
    }

    public function setLocataires(?LOCATAIRE $Locataires): self
    {
        $this->Locataires = $Locataires;

        return $this;
    }

    public function getLogements(): ?LOGEMENT
    {
        return $this->Logements;
    }

    public function setLogements(?LOGEMENT $Logements): self
    {
        $this->Logements = $Logements;

        return $this;
    }
}
