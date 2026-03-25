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
            ['Nom' => 'Amazon', 'Ville' => 'Paris', 'Date' => 'Mars 2027', 'Domaine' => 'Logistique', 'Niveau' => 'Bac +3', 'Salaire' => '1100€'],
            ['Nom' => 'Airbus', 'Ville' => 'Toulouse', 'Date' => 'Avril 2027', 'Domaine' => 'Aéronautique', 'Niveau' => 'Bac +5', 'Salaire' => '1800€'],
            ['Nom' => 'Ubisoft', 'Ville' => 'Montpellier', 'Date' => 'Mai 2027', 'Domaine' => 'Jeux vidéo', 'Niveau' => 'Bac +3', 'Salaire' => '1300€'],
            ['Nom' => 'Capgemini', 'Ville' => 'Lille', 'Date' => 'Juin 2027', 'Domaine' => 'Informatique', 'Niveau' => 'Bac +5', 'Salaire' => '1400€'],
            ['Nom' => 'TotalEnergies', 'Ville' => 'Paris', 'Date' => 'Juillet 2027', 'Domaine' => 'Énergie', 'Niveau' => 'Bac +5', 'Salaire' => '1600€'],
            ['Nom' => 'Orange', 'Ville' => 'Rennes', 'Date' => 'Août 2027', 'Domaine' => 'Télécommunication', 'Niveau' => 'Bac +3', 'Salaire' => '1200€'],
        ];

        $page = (int)($request->getQueryParams()['page'] ?? 1);
        $parPage = 6;
        $offset = ($page - 1) * $parPage;

        $souhaitsPagination = array_slice($souhaits, $offset, $parPage);

        return $view->render($response, 'liste_de_souhait.html.twig', [
            'role' => $session['userRole'] ?? '',
            'souhaits' => $souhaitsPagination,
            'page' => $page,
        ]);
    }
}
