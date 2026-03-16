<?php

namespace App\Application\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class StageController
{
    public function stage(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        $session = $request->getAttribute('session');
        $offres = [
            ['id' => 1, 'nom' => 'Engie', 'domaine' => 'Informatique', 'lieu' => 'Paris', 'email' => 'contact@engie.com', 'duree' => '3 mois', 'description' => 'Grande entreprise dans le secteur énergétique.'],
            ['id' => 2, 'nom' => 'GreenLeaf', 'domaine' => 'Écologie', 'lieu' => 'Lyon', 'email' => 'contact@greenleaf.com', 'duree' => '6 mois', 'description' => 'Startup spécialisée dans les énergies renouvelables.'],
            ['id' => 3, 'nom' => 'CyberShield', 'domaine' => 'Sécurité', 'lieu' => 'Bordeaux', 'email' => 'contact@cybershield.com', 'duree' => '4 mois', 'description' => 'Expert en cybersécurité et protection des données.'],
            ['id' => 4, 'nom' => 'TechVision', 'domaine' => 'Informatique', 'lieu' => 'Paris', 'email' => 'contact@techvision.com', 'duree' => '6 mois', 'description' => 'Startup innovante spécialisée dans le développement web et mobile.'],
            ['id' => 5, 'nom' => 'DataFlow', 'domaine' => 'Data', 'lieu' => 'Lyon', 'email' => 'contact@dataflow.com', 'duree' => '5 mois', 'description' => 'Cabinet de conseil en data science et intelligence artificielle.'],
            ['id' => 6, 'nom' => 'CloudNest', 'domaine' => 'Informatique', 'lieu' => 'Nantes', 'email' => 'contact@cloudnest.com', 'duree' => '6 mois', 'description' => 'Entreprise spécialisée dans les solutions cloud et DevOps.'],
            ['id' => 7, 'nom' => 'BioTech Labs', 'domaine' => 'Biologie', 'lieu' => 'Strasbourg', 'email' => 'contact@biotechlabs.com', 'duree' => '4 mois', 'description' => 'Laboratoire de recherche en biotechnologie et sciences du vivant.'],
            ['id' => 8, 'nom' => 'FinSmart', 'domaine' => 'Finance', 'lieu' => 'Paris', 'email' => 'contact@finsmart.com', 'duree' => '6 mois', 'description' => 'Fintech proposant des solutions de gestion financière automatisée.'],
            ['id' => 9, 'nom' => 'UrbanDesign', 'domaine' => 'Architecture', 'lieu' => 'Marseille', 'email' => 'contact@urbandesign.com', 'duree' => '3 mois', 'description' => 'Agence d\'architecture spécialisée dans les projets urbains durables.'],
            ['id' => 10, 'nom' => 'MediaPulse', 'domaine' => 'Communication', 'lieu' => 'Bordeaux', 'email' => 'contact@mediapulse.com', 'duree' => '4 mois', 'description' => 'Agence de communication digitale et création de contenu.'],
            ['id' => 11, 'nom' => 'RoboCore', 'domaine' => 'Robotique', 'lieu' => 'Toulouse', 'email' => 'contact@robocore.com', 'duree' => '6 mois', 'description' => 'Entreprise de robotique industrielle et automatisation des processus.'],
            ['id' => 12, 'nom' => 'EcoMove', 'domaine' => 'Écologie', 'lieu' => 'Grenoble', 'email' => 'contact@ecomove.com', 'duree' => '5 mois', 'description' => 'Société de mobilité verte spécialisée dans les véhicules électriques.'],
            ['id' => 13, 'nom' => 'HealthPlus', 'domaine' => 'Santé', 'lieu' => 'Lille', 'email' => 'contact@healthplus.com', 'duree' => '4 mois', 'description' => 'Startup e-santé développant des applications médicales innovantes.'],
            ['id' => 14, 'nom' => 'GameForge', 'domaine' => 'Jeux Vidéo', 'lieu' => 'Montpellier', 'email' => 'contact@gameforge.com', 'duree' => '6 mois', 'description' => 'Studio de développement de jeux vidéo indépendant.'],
            ['id' => 15, 'nom' => 'LegalTech', 'domaine' => 'Droit', 'lieu' => 'Paris', 'email' => 'contact@legaltech.com', 'duree' => '3 mois', 'description' => 'Entreprise spécialisée dans la digitalisation des services juridiques.'],
            ['id' => 16, 'nom' => 'AgroSmart', 'domaine' => 'Agriculture', 'lieu' => 'Rennes', 'email' => 'contact@agrosmart.com', 'duree' => '5 mois', 'description' => 'Startup d\'agriculture connectée et gestion intelligente des cultures.'],
            ['id' => 17, 'nom' => 'LogiChain', 'domaine' => 'Logistique', 'lieu' => 'Le Havre', 'email' => 'contact@logichain.com', 'duree' => '4 mois', 'description' => 'Entreprise de logistique et optimisation de la chaîne d\'approvisionnement.'],
            ['id' => 18, 'nom' => 'SpaceTech', 'domaine' => 'Aérospatial', 'lieu' => 'Toulouse', 'email' => 'contact@spacetech.com', 'duree' => '6 mois', 'description' => 'Société spécialisée dans les technologies spatiales et satellites.'],
        ];

        $page = (int)($request->getQueryParams()['page'] ?? 1);
        $parPage = 9;
        $offset = ($page - 1) * $parPage;
        $offresPaginations = array_slice($offres, $offset, $parPage);

        return $view->render($response, 'Trouver_mon_stage.html.twig', [
            'role' => $session['userRole'] ?? '',
            'offres' => $offresPaginations,
            'page' => $page,
        ]);
    }
}
