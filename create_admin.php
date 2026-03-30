<?php

require __DIR__ . '/vendor/autoload.php';

use App\Domain\Role;
use DI\ContainerBuilder;
use App\Application\Settings\Settings;
use Doctrine\ORM\EntityManager;
use App\Domain\Utilisateur;

// 🔥 1. construire le container comme Slim
$containerBuilder = new ContainerBuilder();

// charger les settings
$settings = require __DIR__ . '/app/settings.php';
$settings($containerBuilder);

// charger les dependencies (TON fichier 👌)
$dependencies = require __DIR__ . '/app/dependencies.php';
$dependencies($containerBuilder);

// construire le container
$container = $containerBuilder->build();

/** @var EntityManager $entityManager */
$entityManager = $container->get(EntityManager::class);

// vérifier si admin existe déjà
$userRepo = $entityManager->getRepository(Utilisateur::class);
$existing = $userRepo->findOneBy(['email' => 'admin@admin.com']);

if ($existing) {
    echo "Admin existe déjà.";
    exit;
}

// créer admin avec constructeur
$admin = new Utilisateur(
    'Admin',
    'Super',
    'Paris',
    'admin@mail.com',
    'admin123',
    Role::ADMIN
);

// ⚠️ role en minuscule comme tu as dit
$admin->setRole(Role::ADMIN);
$entityManager->persist($admin);
$entityManager->flush();

echo "Admin créé avec succès 🎉";