<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
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
use App\Application\Controller\CreationEntrepriseController;
use App\Application\Controller\PostuleController;
use App\Application\Controller\SouhaitController;
use App\Application\Controller\StageController;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        return $response;
    });
    $app->get('/', [HomeController::class, 'home']);
    $app->get('/stage', [StageController::class, 'stage']);
    $app->get('/entreprise', [EntrepriseController::class, 'entreprise']);
    $app->get('/souhait', [SouhaitController::class, 'souhait']);
    $app->get('/politique', [HomeController::class, 'politique']);
    $app->get('/role', [HomeController::class, 'role']);
    $app->get('/creation_compte', [HomeController::class, 'creation_compte']);
    $app->get('/mentions', [HomeController::class, 'mentions']);
    $app->get('/connexion',  [ConnexionController::class, 'afficher']);
    $app->post('/connexion', [ConnexionController::class, 'connecter']);
    $app->get('/deconnexion', [ConnexionController::class, 'deconnecter']);
    $app->get('/postule',  [PostuleController::class, 'afficher2']);
    $app->post('/postule', [PostuleController::class, 'traiter']);

    $app->get('/creation_entreprise', [CreationEntrepriseController::class, 'creation_entreprise'])->setName('creation_entreprise');
    $app->post('/creation_entreprise/ajouter', [CreationEntrepriseController::class, 'ajoute']);
    $app->get('/creation_entreprise/modifier/{id}', [CreationEntrepriseController::class, 'modifier'])->setName('modifier-entreprise');
    $app->post('/creation_entreprise/modifier/{id}', [CreationEntrepriseController::class, 'modifier']);
    $app->post('/creation_entreprise/supprimer/{id}', [CreationEntrepriseController::class, 'supprimer'])->setName('supprimer-entreprise');

    $app->get('/gestion_offres', [OffreController::class, 'gestion_offres'])->setName('gestion_offres');
    $app->post('/gestion_offres/ajouter', [OffreController::class, 'ajoute']);
    $app->get('/gestion_offres/modifier/{id}', [OffreController::class, 'modifier'])->setName('modifier-offres');
    $app->post('/gestion_offres/modifier/{id}', [OffreController::class, 'modifier']);
    $app->post('/gestion_offres/supprimer/{id}', [OffreController::class, 'supprimer'])->setName('supprimer-offres');

    $app->get('/gestion_etudiants', [EtudiantController::class, 'gestion_etudiants'])->setName('gestion_etudiants');
    $app->post('/gestion_etudiants/ajouter', [EtudiantController::class, 'ajoute']);
    $app->get('/gestion_etudiants/modifier/{id}', [EtudiantController::class, 'modifier'])->setName('modifier-etudiants');
    $app->post('/gestion_etudiants/modifier/{id}', [EtudiantController::class, 'modifier']);
    $app->post('/gestion_etudiants/supprimer/{id}', [EtudiantController::class, 'supprimer'])->setName('supprimer-etudiants');

    $app->get('/gestion_pilotes', [PiloteController::class, 'gestion_pilotes'])->setName('gestion_pilotes');
    $app->post('/gestion_pilotes/ajouter', [PiloteController::class, 'ajoute']);
    $app->get('/gestion_pilotes/modifier/{id}', [PiloteController::class, 'modifier'])->setName('modifier-pilotes');
    $app->post('/gestion_pilotes/modifier/{id}', [PiloteController::class, 'modifier']);
    $app->post('/gestion_pilotes/supprimer/{id}', [PiloteController::class, 'supprimer'])->setName('supprimer-pilotes');
};
