<?php

use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

return function ($app) {

    // Twig
    $twig = Twig::create(__DIR__ . '/../templates', ['cache' => false]);
    $app->add(TwigMiddleware::create($app, $twig));

    // PDO
    $container = $app->getContainer();
    $container->set('db', function () {
        return new PDO(
            "mysql:host=db;dbname=stage_explorer;charset=utf8",
            "user_stage",
            "password_stage"
        );
    });
};
