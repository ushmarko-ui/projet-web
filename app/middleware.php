<?php

declare(strict_types=1);

use App\Application\Middleware\SessionMiddleware;
use Slim\App;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use App\Application\Middleware\UserTwigMiddleware;
use Doctrine\ORM\EntityManager;


return function (App $app) {
    $twig = Twig::create(__DIR__ . '/../src/Application/Templates', ['cache' => false]);
    $app->add(TwigMiddleware::create($app, $twig));
    $app->add(new UserTwigMiddleware($twig, $app->getContainer()->get(EntityManager::class)));
    $app->add(SessionMiddleware::class);
};
