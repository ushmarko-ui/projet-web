<?php

namespace App\Application\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class CreationEntrepriseController
{
    public function creation_entreprise(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        $entreprises = [
            ['id' => 1, 'nom' => 'Engie', 'domaine' => 'Informatique', 'lieu' => 'Paris', 'email' => 'contact@engie.com'],
            ['id' => 2, 'nom' => 'GreenLeaf', 'domaine' => 'Écologie', 'lieu' => 'Lyon', 'email' => 'contact@greenleaf.com'],
            ['id' => 3, 'nom' => 'CyberShield', 'domaine' => 'Sécurité', 'lieu' => 'Bordeaux', 'email' => 'contact@cybershield.com'],
            ['id' => 4, 'nom' => 'TechVision', 'domaine' => 'Informatique', 'lieu' => 'Paris', 'email' => 'contact@techvision.com'],
            ['id' => 5, 'nom' => 'DataFlow', 'domaine' => 'Data', 'lieu' => 'Lyon', 'email' => 'contact@dataflow.com'],
            ['id' => 6, 'nom' => 'CloudNest', 'domaine' => 'Informatique', 'lieu' => 'Nantes', 'email' => 'contact@cloudnest.com'],
            ['id' => 7, 'nom' => 'BioTech Labs', 'domaine' => 'Biologie', 'lieu' => 'Strasbourg', 'email' => 'contact@biotechlabs.com'],
            ['id' => 8, 'nom' => 'FinSmart', 'domaine' => 'Finance', 'lieu' => 'Paris', 'email' => 'contact@finsmart.com'],
            ['id' => 9, 'nom' => 'UrbanDesign', 'domaine' => 'Architecture', 'lieu' => 'Marseille', 'email' => 'contact@urbandesign.com'],
            ['id' => 10, 'nom' => 'MediaPulse', 'domaine' => 'Communication', 'lieu' => 'Bordeaux', 'email' => 'contact@mediapulse.com'],
            ['id' => 11, 'nom' => 'RoboCore', 'domaine' => 'Robotique', 'lieu' => 'Toulouse', 'email' => 'contact@robocore.com'],
            ['id' => 12, 'nom' => 'EcoMove', 'domaine' => 'Écologie', 'lieu' => 'Grenoble', 'email' => 'contact@ecomove.com'],
            ['id' => 13, 'nom' => 'HealthPlus', 'domaine' => 'Santé', 'lieu' => 'Lille', 'email' => 'contact@healthplus.com'],
            ['id' => 14, 'nom' => 'GameForge', 'domaine' => 'Jeux Vidéo', 'lieu' => 'Montpellier', 'email' => 'contact@gameforge.com'],
            ['id' => 15, 'nom' => 'LegalTech', 'domaine' => 'Droit', 'lieu' => 'Paris', 'email' => 'contact@legaltech.com'],
            ['id' => 16, 'nom' => 'AgroSmart', 'domaine' => 'Agriculture', 'lieu' => 'Rennes', 'email' => 'contact@agrosmart.com'],
            ['id' => 17, 'nom' => 'LogiChain', 'domaine' => 'Logistique', 'lieu' => 'Le Havre', 'email' => 'contact@logichain.com'],
            ['id' => 18, 'nom' => 'SpaceTech', 'domaine' => 'Aérospatial', 'lieu' => 'Toulouse', 'email' => 'contact@spacetech.com'],
        ];
        $page = (int)($request->getQueryParams()['page'] ?? 1);
        $parPage = 10;
        $offset = ($page - 1) * $parPage;

        $Gestion_EntreprisePagination = array_slice($entreprises, $offset, $parPage);

        return $view->render($response, 'creation_entreprise.html.twig', [
            'role' => $session['userRole'] ?? '',
            'gestion_entreprises' => $Gestion_EntreprisePagination,
            'page' => $page,
        ]);
    }
}
