<?php

namespace App\Application\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class EntrepriseController
{
    public function creation_entreprise(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        $entreprises = [
            ['id' => 1, 'nom' => 'Engie', 'domaine' => 'Informatique', 'lieu' => 'Paris', 'email' => 'contact@engie.com'],
            ['id' => 2, 'nom' => 'GreenLeaf', 'domaine' => 'Écologie', 'lieu' => 'Lyon', 'email' => 'contact@greenleaf.com'],
            ['id' => 3, 'nom' => 'CyberShield', 'domaine' => 'Sécurité', 'lieu' => 'Bordeaux', 'email' => 'contact@cybershield.com'],
        ];
        return $view->render($response, 'creation_entreprise.html.twig', ['entreprises' => $entreprises]);
    }
}
