<?php
use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function ($app) {

    // --- ACCUEIL ---
    $app->get('/', function (Request $request, Response $response) {
        return Twig::fromRequest($request)->render($response, 'Index.html');
    });

    // --- RECHERCHE ET OFFRES ---
    $app->get('/trouver-stage', function (Request $request, Response $response) {
        return Twig::fromRequest($request)->render($response, '/HTML/Trouver_mon_stage.html');
    });

    $app->get('/trouver-entreprise', function (Request $request, Response $response) {
        return Twig::fromRequest($request)->render($response, '/HTML/Trouver_une_entreprise.html');
    });

    // --- AUTHENTIFICATION ---
    $app->get('/connexion', function (Request $request, Response $response) {
        return Twig::fromRequest($request)->render($response, '/HTML/page_connexion.html');
    });

    $app->get('/inscription', function (Request $request, Response $response) {
        return Twig::fromRequest($request)->render($response, '/HTML/page_creation_compte.html');
    });

    $app->get('/choix-role', function (Request $request, Response $response) {
        return Twig::fromRequest($request)->render($response, '/HTML/choix_role.html');
    });

    // --- GESTION (ADMIN/PILOTE) ---
    $app->get('/gestion-etudiants', function (Request $request, Response $response) {
        return Twig::fromRequest($request)->render($response, '/HTML/gestion_etudiants.html');
    });

    $app->get('/gestion-offres', function (Request $request, Response $response) {
        return Twig::fromRequest($request)->render($response, '/HTML/gestion_offres.html');
    });

    $app->get('/gestion-pilotes', function (Request $request, Response $response) {
        return Twig::fromRequest($request)->render($response, '/HTML/gestion_pilotes.html');
    });

    $app->get('/creation-entreprise', function (Request $request, Response $response) {
        return Twig::fromRequest($request)->render($response, '/HTML/creation_entreprise.html');
    });

    // --- UTILISATEUR ---
    $app->get('/souhaits', function (Request $request, Response $response) {
        return Twig::fromRequest($request)->render($response, '/HTML/liste_de_souhait.html');
    });

    // --- LÉGAL ---
    $app->get('/mentions-legales', function (Request $request, Response $response) {
        return Twig::fromRequest($request)->render($response, '/HTML/mentions.html');
    });

    $app->get('/politique-confidentialite', function (Request $request, Response $response) {
        return Twig::fromRequest($request)->render($response, '/HTML/politique.html');
    });
};