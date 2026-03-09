<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

// Configuration de Twig (cherche à la racine pour trouver Index.html et /HTML)
$twig = Twig::create(__DIR__, ['cache' => false]);
$app->add(TwigMiddleware::create($app, $twig));

// Connexion à la base de données - CORRIGÉ ICI
$db = new PDO('mysql:host=stage_explorer_db;dbname=stage_explorer;charset=utf8', 'user_stage', 'password_stage');

// --- ON CHARGE LE FICHIER DE ROUTES ---
$routes = require __DIR__ . '/Php/Route.php';

// --- ON APPELLE LA FONCTION DES ROUTES EN PASSANT $APP ET $DB ---
$routes($app, $db); 

$app->run();