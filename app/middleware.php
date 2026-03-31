<?php

declare(strict_types=1);

use App\Application\Middleware\SessionMiddleware;
use Slim\App;
use App\Application\Middleware\UserTwigMiddleware;
use Doctrine\ORM\EntityManager;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Twig\Extension\DebugExtension;
use App\Application\Middleware\RoleCheckMiddleware;
use App\Domain\Role;
return function (App $app) {
     $twig = Twig::create(__DIR__ . '/../src/Application/Templates', ['cache' => false, 'debug' => true ]);
    $twig->getEnvironment()->addExtension(new DebugExtension());
    $app->add(TwigMiddleware::create($app, $twig));
     $app->add(new UserTwigMiddleware($twig, $app->getContainer()->get(EntityManager::class)));
    $app->add(SessionMiddleware::class);
};
$adminOnly = new RoleCheckMiddleware($responseFactory, [Role::ADMIN]);

$adminOrPilote = new RoleCheckMiddleware(
    $responseFactory,
    [Role::ADMIN, Role::PILOTE]
);
