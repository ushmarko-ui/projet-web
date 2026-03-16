<?php

namespace App\Application\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class SouhaitController
{
    public function souhait(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        $session = $request->getAttribute('session');
        $souhaits = [
            ['Nom' => 'Google', 'Ville' => 'Paris', 'Date' => 'Juin 2026', 'Domaine' => 'Informatique', 'Niveau' => 'Bac +3', 'Salaire' => '1200€'],
            ['Nom' => 'Tesla', 'Ville' => 'Berlin', 'Date' => 'Septembre 2026', 'Domaine' => 'Ingénierie', 'Niveau' => 'Bac +5', 'Salaire' => '1500€'],
            ['Nom' => 'Microsoft', 'Ville' => 'Lyon', 'Date' => 'Janvier 2027', 'Domaine' => 'Informatique', 'Niveau' => 'Bac +5', 'Salaire' => '2000€'],
        ];
        return $view->render($response, 'liste_de_souhait.html.twig', ['role' => $session['userRole'] ?? '', 'souhaits' => $souhaits]);
    }
}
