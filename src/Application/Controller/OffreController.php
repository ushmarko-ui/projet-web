<?php

namespace App\Application\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class OffreController
{
    public function gestion_offres(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        $offres = [
            ['id' => 1, 'nom' => 'Engie', 'domaine' => 'Informatique', 'lieu' => 'Paris', 'email' => 'contact@engie.com', 'duree' => '3 mois', 'description' => 'Grande entreprise dans le secteur énergétique.'],
            ['id' => 2, 'nom' => 'GreenLeaf', 'domaine' => 'Écologie', 'lieu' => 'Lyon', 'email' => 'contact@greenleaf.com', 'duree' => '6 mois', 'description' => 'Startup spécialisée dans les énergies renouvelables.'],
            ['id' => 3, 'nom' => 'CyberShield', 'domaine' => 'Sécurité', 'lieu' => 'Bordeaux', 'email' => 'contact@cybershield.com', 'duree' => '4 mois', 'description' => 'Expert en cybersécurité et protection des données.'],
        ];
        return $view->render($response, 'gestion_offres.html.twig', ['offres' => $offres]);
    }
}
