<?php

namespace App\Application\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class EtudiantController
{
    public function gestion_etudiants(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        $etudiants = [
            ['id' => 1, 'prenom' => 'Mark', 'nom' => 'Otto', 'surnom' => '@mdo', 'email' => 'mdo@gmail.com', 'age' => '28'],
            ['id' => 2, 'prenom' => 'Bernard', 'nom' => 'Madelaine', 'surnom' => '@bme', 'email' => 'bme@gmail.com', 'age' => '20'],
            ['id' => 3, 'prenom' => 'Claude', 'nom' => 'Garnier', 'surnom' => '@cgr', 'email' => 'cgr@gmail.com', 'age' => '19'],
        ];
        return $view->render($response, 'gestion_etudiants.html.twig', ['etudiants' => $etudiants]);
    }
}
