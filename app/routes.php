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
    $app->get('/creation_entreprise', [CreationEntrepriseController::class, 'creation_entreprise']);
    $app->get('/gestion_etudiants', [EtudiantController::class, 'gestion_etudiants']);
    $app->get('/gestion_pilotes', [PiloteController::class, 'gestion_pilotes']);
    $app->get('/gestion_offres', [OffreController::class, 'gestion_offres']);
    $app->get('/creation_compte', [HomeController::class, 'creation_compte']);
    $app->get('/mentions', [HomeController::class, 'mentions']);
    $app->get('/connexion',  [ConnexionController::class, 'afficher']);
    $app->post('/connexion', [ConnexionController::class, 'connecter']);
    $app->get('/deconnexion', [ConnexionController::class, 'deconnecter']);
    $app->get('/postule',  [PostuleController::class, 'afficher2']);
    $app->post('/postule', [PostuleController::class, 'traiter']);
};
