<?php

use PHP_CodeSniffer\Generators\HTML;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

// Configuration de Twig

$twig = Twig::create(__DIR__, ['cache' => false]);
$app->add(TwigMiddleware::create($app, $twig));

// --- ON APPELLE LE FICHIER DE ROUTES ICI ---
$routes = require __DIR__ . '/Php/Route.php';
$routes($app);
// -------------------------------------------

$app->run();