<?php

namespace App\Application\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class HomeController
{
    public function home(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        $session = $request->getAttribute('session');
        $offres = [
            ['id' => 1, 'nom' => 'Engie', 'domaine' => 'Informatique', 'lieu' => 'Paris', 'email' => 'contact@engie.com', 'duree' => '3 mois', 'description' => 'Grande entreprise dans le secteur énergétique.'],
            ['id' => 2, 'nom' => 'GreenLeaf', 'domaine' => 'Écologie', 'lieu' => 'Lyon', 'email' => 'contact@greenleaf.com', 'duree' => '6 mois', 'description' => 'Startup spécialisée dans les énergies renouvelables.'],
            ['id' => 3, 'nom' => 'CyberShield', 'domaine' => 'Sécurité', 'lieu' => 'Bordeaux', 'email' => 'contact@cybershield.com', 'duree' => '4 mois', 'description' => 'Expert en cybersécurité et protection des données.'],
        ];
        return $view->render($response, 'index.html.twig', ['role' => $session['userRole'] ?? '', 'offres' => $offres]);
    }

    public function entreprise(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        $session = $request->getAttribute('session');
        $entreprises = [
            ['id' => 1, 'nom' => 'Engie', 'domaine' => 'Informatique', 'lieu' => 'Paris', 'email' => 'contact@engie.com'],
            ['id' => 2, 'nom' => 'GreenLeaf', 'domaine' => 'Écologie', 'lieu' => 'Lyon', 'email' => 'contact@greenleaf.com'],
            ['id' => 3, 'nom' => 'CyberShield', 'domaine' => 'Sécurité', 'lieu' => 'Bordeaux', 'email' => 'contact@cybershield.com'],
        ];
        return $view->render($response, 'Trouver_une_entreprise.html.twig', ['role' => $session['userRole'] ?? '', 'entreprises' => $entreprises]);
    }

    public function politique(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'politique.html.twig', []);
    }

    public function role(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'choix_role.html.twig', []);
    }

    public function connexion(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        $role = $request->getQueryParams()['role'] ?? '';
        return $view->render($response, 'page_connexion.html.twig', ['role' => $role]);
    }

    public function creation_entreprise(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'creation_entreprise.html.twig', []);
    }

    public function gestion_etudiants(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'gestion_etudiants.html.twig', []);
    }


    public function gestion_pilotes(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'gestion_pilotes.html.twig', []);
    }

    public function mentions(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'mentions.html.twig', []);
    }
}
