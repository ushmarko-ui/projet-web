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
use App\Domain\Role;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\Routing\RouteCollectorProxy;
use App\Application\Middleware\RoleCheckMiddleware;
use App\Application\Middleware\LoggedMiddleware;

return function (App $app) {
    $factory = $app->getContainer()->get(ResponseFactoryInterface::class);
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        return $response;
    });
    $app->get('/', [AccueilController::class, 'home'])->setName('accueil');
    $app->get('/stage[/{page:\d+}]', [StageController::class, 'stage'])->setName('stage');
    $app->get('/entreprise[/{page:\d+}]', [EntrepriseController::class, 'entreprise'])->setName('entreprise');
    $app->get('/politique', [HomeController::class, 'politique'])->setName('politique');
    $app->get('/mentions', [HomeController::class, 'mentions'])->setName('mentions');
    $app->get('/connexion',  [ConnexionController::class, 'afficher'])->setName('connexion');
    $app->post('/connexion', [ConnexionController::class, 'connecter']);
    $app->get('/deconnexion', [ConnexionController::class, 'deconnecter'])->setName('deconnexion');
    $app->get('/offres/{nom}', [VoirOffresController::class, 'VoirOffres'])->setName('voir-offres');

    // Admin seulement
    $app->group('', function (RouteCollectorProxy $group) {
        $group->get('/gestion_pilotes[/{page:\d+}]', [PiloteController::class, 'gestion_pilotes'])->setName('gestion_pilotes');
        $group->post('/gestion_pilotes/ajouter', [PiloteController::class, 'ajoute']);
        $group->get('/gestion_pilotes/ajouter', [PiloteController::class, 'ajoute'])->setName('ajout-pilotes');
        $group->get('/gestion_pilotes/modifier/{id}', [PiloteController::class, 'modifier'])->setName('modifier-pilotes');
        $group->post('/gestion_pilotes/modifier/{id}', [PiloteController::class, 'modifier']);
        $group->post('/gestion_pilotes/supprimer/{id}', [PiloteController::class, 'supprimer'])->setName('supprimer-pilotes');
    })->add(new RoleCheckMiddleware($factory, [Role::ADMIN]));

    // Admin + Pilote
    $app->group('', function (RouteCollectorProxy $group) {
        $group->get('/gestion_etudiants[/{page:\d+}]', [EtudiantController::class, 'gestion_etudiants'])->setName('gestion_etudiants');
        $group->post('/gestion_etudiants/ajouter', [EtudiantController::class, 'ajoute']);
        $group->get('/gestion_etudiants/ajouter', [EtudiantController::class, 'ajoute'])->setName('ajout-etudiants');
        $group->get('/gestion_etudiants/modifier/{id}', [EtudiantController::class, 'modifier'])->setName('modifier-etudiants');
        $group->post('/gestion_etudiants/modifier/{id}', [EtudiantController::class, 'modifier']);
        $group->post('/gestion_etudiants/supprimer/{id}', [EtudiantController::class, 'supprimer'])->setName('supprimer-etudiants');

        $group->get('/gestion_offres[/{page:\d+}]', [OffreController::class, 'gestion_offres'])->setName('gestion_offres');
        $group->post('/gestion_offres/ajouter', [OffreController::class, 'ajoute']);
        $group->get('/gestion_offres/ajouter', [OffreController::class, 'ajoute'])->setName('ajout-offres');
        $group->get('/gestion_offres/modifier/{id}', [OffreController::class, 'modifier'])->setName('modifier-offres');
        $group->post('/gestion_offres/modifier/{id}', [OffreController::class, 'modifier']);
        $group->post('/gestion_offres/supprimer/{id}', [OffreController::class, 'supprimer'])->setName('supprimer-offres');

        $group->get('/gestion_entreprises[/{page:\d+}]', [GestionEntreprise::class, 'gestion_entreprises'])->setName('gestion_entreprises');
        $group->post('/gestion_entreprises/ajouter', [GestionEntreprise::class, 'ajoute']);
        $group->get('/gestion_entreprises/ajouter', [GestionEntreprise::class, 'ajoute'])->setName('ajout-entreprises');
        $group->get('/gestion_entreprises/modifier/{id}', [GestionEntreprise::class, 'modifier'])->setName('modifier-entreprises');
        $group->post('/gestion_entreprises/modifier/{id}', [GestionEntreprise::class, 'modifier']);
        $group->post('/gestion_entreprises/supprimer/{id}', [GestionEntreprise::class, 'supprimer'])->setName('supprimer-entreprises');
    })->add(new RoleCheckMiddleware($factory, [Role::ADMIN, Role::PILOTE]));


    $app->group('', function (RouteCollectorProxy $group) {
        $group->get('/souhait[/{page:\d+}]', [SouhaitController::class, 'souhait'])->setName('souhait');
        $group->post('/souhait/ajouter/{id}', [SouhaitController::class, 'ajouter'])->setName('ajouter-souhait');
        $group->post('/souhait/supprimer/{id}', [SouhaitController::class, 'supprimer'])->setName('supprimer-souhait');
        $group->get('/candidature', [CandidatureController::class, 'candidature'])->setName('candidature');
        $group->get('/postule/{id}', [PostuleController::class, 'afficher2'])->setName('postule');
        $group->post('/postule/{id}', [PostuleController::class, 'traiter']);
    })->add(new LoggedMiddleware($factory));
};
