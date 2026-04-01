<?php

namespace App\Domain;

use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: 'entreprises')]
class Entreprise
{
    #[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[Column(type: 'string', nullable: false)]
    private string $nom;

    #[Column(type: 'string', nullable: false)]
    private string $domaine;

    #[Column(type: 'string', nullable: false)]
    private string $telephone;

    #[Column(type: 'string', nullable: false)]
    private string $description;

    #[Column(type: 'string', nullable: false)]
    private string $lieu;

    #[Column(type: 'string', nullable: false)]
    private string $email;

    #[Column(name: 'created_at', type: 'datetimetz_immutable', nullable: false)]
    private DateTimeImmutable $createdAt;

    public function __construct(string $nom, string $domaine, string $lieu, string $email, string $telephone, string $description)
    {
        $this->nom = $nom;
        $this->domaine = $domaine;
        $this->lieu = $lieu;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->description = $description;
        $this->createdAt = new DateTimeImmutable('now');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function getDomaine(): string
    {
        return $this->domaine;
    }

    public function setDomaine(string $domaine): void
    {
        $this->domaine = $domaine;
    }

    public function getLieu(): string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): void
    {
        $this->lieu = $lieu;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getTelephone(): string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): void
    {
        $this->telephone = $telephone;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
