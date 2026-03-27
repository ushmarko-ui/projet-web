<?php

namespace App\Domain;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: 'avis')]
class Avis
{
    #[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[Column(type: 'text')]
    private string $commentaire;

    #[Column(type: 'integer')]
    private int $note;

    #[Column(type: 'integer', name: 'offre_id')]
    private int $offreId;

    public function __construct(string $commentaire, int $note, int $offreId)
    {
        $this->commentaire = $commentaire;
        $this->note = $note;
        $this->offreId = $offreId;
    }
}