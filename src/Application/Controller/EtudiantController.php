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
            ['id' => 4, 'prenom' => 'Sophie', 'nom' => 'Dupont', 'surnom' => '@sdu', 'email' => 'sdu@gmail.com', 'age' => '22'],
            ['id' => 5, 'prenom' => 'Lucas', 'nom' => 'Martin', 'surnom' => '@lma', 'email' => 'lma@gmail.com', 'age' => '25'],
            ['id' => 6, 'prenom' => 'Emma', 'nom' => 'Bernard', 'surnom' => '@ebe', 'email' => 'ebe@gmail.com', 'age' => '21'],
            ['id' => 7, 'prenom' => 'Hugo', 'nom' => 'Lefevre', 'surnom' => '@hle', 'email' => 'hle@gmail.com', 'age' => '27'],
            ['id' => 8, 'prenom' => 'Camille', 'nom' => 'Rousseau', 'surnom' => '@cro', 'email' => 'cro@gmail.com', 'age' => '23'],
            ['id' => 9, 'prenom' => 'Nathan', 'nom' => 'Petit', 'surnom' => '@npe', 'email' => 'npe@gmail.com', 'age' => '18'],
            ['id' => 10, 'prenom' => 'Léa', 'nom' => 'Moreau', 'surnom' => '@lmo', 'email' => 'lmo@gmail.com', 'age' => '24'],
            ['id' => 11, 'prenom' => 'Antoine', 'nom' => 'Simon', 'surnom' => '@asi', 'email' => 'asi@gmail.com', 'age' => '30'],
            ['id' => 12, 'prenom' => 'Chloé', 'nom' => 'Laurent', 'surnom' => '@cla', 'email' => 'cla@gmail.com', 'age' => '26'],
            ['id' => 13, 'prenom' => 'Maxime', 'nom' => 'Thomas', 'surnom' => '@mth', 'email' => 'mth@gmail.com', 'age' => '29'],
            ['id' => 14, 'prenom' => 'Inès', 'nom' => 'Girard', 'surnom' => '@igi', 'email' => 'igi@gmail.com', 'age' => '20'],
            ['id' => 15, 'prenom' => 'Romain', 'nom' => 'Fontaine', 'surnom' => '@rfo', 'email' => 'rfo@gmail.com', 'age' => '31'],
            ['id' => 16, 'prenom' => 'Manon', 'nom' => 'Chevalier', 'surnom' => '@mch', 'email' => 'mch@gmail.com', 'age' => '22'],
            ['id' => 17, 'prenom' => 'Théo', 'nom' => 'Bonnet', 'surnom' => '@tbo', 'email' => 'tbo@gmail.com', 'age' => '19'],
            ['id' => 18, 'prenom' => 'Julie', 'nom' => 'Mercier', 'surnom' => '@jme', 'email' => 'jme@gmail.com', 'age' => '28'],
        ];
        $page = (int)($request->getQueryParams()['page'] ?? 1);
        $parPage = 10;
        $offset = ($page - 1) * $parPage;

        $Gestion_EtudiantsPagination = array_slice($etudiants, $offset, $parPage);

        return $view->render($response, 'gestion_etudiants.html.twig', [
            'role' => $session['userRole'] ?? '',
            'gestion_etudiants' => $Gestion_EtudiantsPagination,
            'page' => $page,
        ]);
    }
}
