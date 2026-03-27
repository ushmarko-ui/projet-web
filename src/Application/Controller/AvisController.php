<?php

namespace App\Application\Controller;

use App\Domain\Avis;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;



public function laisser_avis(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
{
    
    $donnees = $request->getParsedBody();
    $commentaire = $donnees['commentaire'] ?? '';
    $note = (int)($donnees['note'] ?? 5);
    $offreId = (int)$args['id'];

    
    $avis = new \App\Domain\Avis($commentaire, $note, $offreId);
    $this->em->persist($avis);
    $this->em->flush();

  
    return $response->withHeader('Location', '/stage')->withStatus(302);
}