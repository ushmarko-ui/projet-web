<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use App\Application\Controller\AccueilController;
use App\Application\Controller\CandidatureController;
use App\Application\Controller\EntrepriseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use App\Application\Controller\HomeController;
use App\Application\Controller\OffreController;
use App\Application\Controller\EtudiantController;
use App\Application\Controller\PiloteController;
use App\Application\Controller\ConnexionController;
use App\Application\Controller\GestionEntreprise;
use App\Application\Controller\PostuleController;
use App\Application\Controller\SouhaitController;
use App\Application\Controller\StageController;
use App\Application\Controller\VoirOffresController;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        return $response;
    });
    $app->get('/', [AccueilController::class, 'home']);
    $app->get('/stage[/{page:\d+}]', [StageController::class, 'stage'])->setName('stage');
    $app->get('/entreprise[/{page:\d+}]', [EntrepriseController::class, 'entreprise'])->setName('entreprise');
    $app->get('/politique', [HomeController::class, 'politique']);
    $app->get('/role', [HomeController::class, 'role']);
    $app->get('/mentions', [HomeController::class, 'mentions']);
    $app->get('/connexion',  [ConnexionController::class, 'afficher']);
    $app->post('/connexion', [ConnexionController::class, 'connecter']);
    $app->get('/deconnexion', [ConnexionController::class, 'deconnecter']);
    $app->get('/postule/{id}',  [PostuleController::class, 'afficher2']);
    $app->post('/postule/{id}', [PostuleController::class, 'traiter']);
    $app->get('/offres/{nom}', [VoirOffresController::class, 'VoirOffres'])->setName('voir-offres');
    $app->get('/candidature', [CandidatureController::class, 'candidature'])->setName('candidature');

    $app->get('/gestion_entreprises[/{page:\d+}]', [GestionEntreprise::class, 'gestion_entreprises'])->setName('gestion_entreprises');
    $app->post('/gestion_entreprises/ajouter', [GestionEntreprise::class, 'ajoute']);
    $app->get('/gestion_entreprises/ajouter', [GestionEntreprise::class, 'ajoute'])->setName('ajout-entreprises');
    $app->get('/gestion_entreprises/modifier/{id}', [GestionEntreprise::class, 'modifier'])->setName('modifier-entreprises');
    $app->post('/gestion_entreprises/modifier/{id}', [GestionEntreprise::class, 'modifier']);
    $app->post('/gestion_entreprises/supprimer/{id}', [GestionEntreprise::class, 'supprimer'])->setName('supprimer-entreprises');

    $app->get('/gestion_offres[/{page:\d+}]', [OffreController::class, 'gestion_offres'])->setName('gestion_offres');
    $app->post('/gestion_offres/ajouter', [OffreController::class, 'ajoute']);
    $app->get('/gestion_offres/ajouter', [OffreController::class, 'ajoute'])->setName('ajout-offres');
    $app->get('/gestion_offres/modifier/{id}', [OffreController::class, 'modifier'])->setName('modifier-offres');
    $app->post('/gestion_offres/modifier/{id}', [OffreController::class, 'modifier']);
    $app->post('/gestion_offres/supprimer/{id}', [OffreController::class, 'supprimer'])->setName('supprimer-offres');

    $app->get('/gestion_etudiants[/{page:\d+}]', [EtudiantController::class, 'gestion_etudiants'])->setName('gestion_etudiants');
    $app->post('/gestion_etudiants/ajouter', [EtudiantController::class, 'ajoute']);
    $app->get('/gestion_etudiants/ajouter', [EtudiantController::class, 'ajoute'])->setName('ajout-etudiants');
    $app->get('/gestion_etudiants/modifier/{id}', [EtudiantController::class, 'modifier'])->setName('modifier-etudiants');
    $app->post('/gestion_etudiants/modifier/{id}', [EtudiantController::class, 'modifier']);
    $app->post('/gestion_etudiants/supprimer/{id}', [EtudiantController::class, 'supprimer'])->setName('supprimer-etudiants');

    $app->get('/gestion_pilotes[/{page:\d+}]', [PiloteController::class, 'gestion_pilotes'])->setName('gestion_pilotes');
    $app->post('/gestion_pilotes/ajouter', [PiloteController::class, 'ajoute']);
    $app->get('/gestion_pilotes/ajouter', [PiloteController::class, 'ajoute'])->setName('ajout-pilotes');
    $app->get('/gestion_pilotes/modifier/{id}', [PiloteController::class, 'modifier'])->setName('modifier-pilotes');
    $app->post('/gestion_pilotes/modifier/{id}', [PiloteController::class, 'modifier']);
    $app->post('/gestion_pilotes/supprimer/{id}', [PiloteController::class, 'supprimer'])->setName('supprimer-pilotes');

    $app->get('/souhait[/{page:\d+}]', [SouhaitController::class, 'souhait'])->setName('souhait');
    $app->post('/souhait/ajouter/{id}', [SouhaitController::class, 'ajouter'])->setName('ajouter-souhait');
    $app->post('/souhait/supprimer/{id}', [SouhaitController::class, 'supprimer'])->setName('supprimer-souhait');
};
