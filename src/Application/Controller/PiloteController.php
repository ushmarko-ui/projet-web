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
            ['id' => 4, 'Nom' => 'Martin', 'prenom' => 'Maxence', 'ville' => 'Nogentel', 'email' => 'Martin@gmail.com'],
            ['id' => 5, 'Nom' => 'Bernard', 'prenom' => 'Sophie', 'ville' => 'Paris', 'email' => 'sophie.bernard@gmail.com'],
            ['id' => 6, 'Nom' => 'Lefevre', 'prenom' => 'Hugo', 'ville' => 'Nantes', 'email' => 'hugo.lefevre@gmail.com'],
            ['id' => 7, 'Nom' => 'Moreau', 'prenom' => 'Camille', 'ville' => 'Strasbourg', 'email' => 'camille.moreau@gmail.com'],
            ['id' => 8, 'Nom' => 'Petit', 'prenom' => 'Nathan', 'ville' => 'Toulouse', 'email' => 'nathan.petit@gmail.com'],
            ['id' => 9, 'Nom' => 'Rousseau', 'prenom' => 'Léa', 'ville' => 'Marseille', 'email' => 'lea.rousseau@gmail.com'],
            ['id' => 10, 'Nom' => 'Simon', 'prenom' => 'Antoine', 'ville' => 'Lille', 'email' => 'antoine.simon@gmail.com'],
            ['id' => 11, 'Nom' => 'Laurent', 'prenom' => 'Chloé', 'ville' => 'Montpellier', 'email' => 'chloe.laurent@gmail.com'],
            ['id' => 12, 'Nom' => 'Thomas', 'prenom' => 'Maxime', 'ville' => 'Rennes', 'email' => 'maxime.thomas@gmail.com'],
            ['id' => 13, 'Nom' => 'Girard', 'prenom' => 'Inès', 'ville' => 'Grenoble', 'email' => 'ines.girard@gmail.com'],
            ['id' => 14, 'Nom' => 'Fontaine', 'prenom' => 'Romain', 'ville' => 'Nice', 'email' => 'romain.fontaine@gmail.com'],
            ['id' => 15, 'Nom' => 'Chevalier', 'prenom' => 'Manon', 'ville' => 'Dijon', 'email' => 'manon.chevalier@gmail.com'],
            ['id' => 16, 'Nom' => 'Bonnet', 'prenom' => 'Théo', 'ville' => 'Angers', 'email' => 'theo.bonnet@gmail.com'],
            ['id' => 17, 'Nom' => 'Mercier', 'prenom' => 'Julie', 'ville' => 'Metz', 'email' => 'julie.mercier@gmail.com'],
            ['id' => 18, 'Nom' => 'Garnier', 'prenom' => 'Alexis', 'ville' => 'Rouen', 'email' => 'alexis.garnier@gmail.com'],
        ];
        $page = (int)($request->getQueryParams()['page'] ?? 1);
        $parPage = 10;
        $offset = ($page - 1) * $parPage;

        $Gestion_PilotesPagination = array_slice($pilotes, $offset, $parPage);

        return $view->render($response, 'gestion_pilotes.html.twig', [
            'role' => $session['userRole'] ?? '',
            'gestion_pilotes' => $Gestion_PilotesPagination,
            'page' => $page,
        ]);
    }
}
