<?php

namespace App\Application\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class PiloteController
{
    public function gestion_pilotes(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        $pilotes = [
            ['id' => 1, 'Nom' => 'Plez', 'prenom' => 'Antoine', 'ville' => 'reims', 'email' => 'plez@gmail.com'],
            ['id' => 2, 'Nom' => 'Dupont', 'prenom' => 'Lucas', 'ville' => 'Lyon', 'email' => 'lucas.dupont@gmail.com'],
            ['id' => 3, 'Nom' => 'Martin', 'prenom' => 'Emma', 'ville' => 'Bordeaux', 'email' => 'emma.martin@gmail.com'],
            ['id' =>4, 'Nom' => '6', 'prenom' => '7', 'ville' => 'brainrotcity', 'email' => '67@gmail.com' ],
        ];
        return $view->render($response, 'gestion_pilotes.html.twig', ['pilotes' => $pilotes]);
    }
}
