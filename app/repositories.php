<?php

declare(strict_types=1);

use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {

    $containerBuilder->addDefinitions([

        
        UserRepository::class => \DI\autowire(InMemoryUserRepository::class),

        
        'entrepriseRepository' => function($container) {
            $db = $container->get('db');

            return [

                'create' => function($nom, $description, $image, $site, $mots) use ($db) {
                    $sql = "INSERT INTO entreprises (nom, description, image_url, site_url, mots_cles)
                            VALUES (:nom, :description, :image, :site, :mots)";
                    $stmt = $db->prepare($sql);
                    $stmt->execute([
                        'nom' => $nom,
                        'description' => $description,
                        'image' => $image,
                        'site' => $site,
                        'mots' => $mots
                    ]);
                },

                'findAll' => function() use ($db) {
                    return $db->query("SELECT * FROM entreprises")->fetchAll();
                },

                'findById' => function($id) use ($db) {
                    $stmt = $db->prepare("SELECT * FROM entreprises WHERE id = :id");
                    $stmt->execute(['id' => $id]);
                    return $stmt->fetch();
                },

                'update' => function($id, $nom, $description, $image, $site, $mots) use ($db) {
                    $sql = "UPDATE entreprises
                            SET nom=:nom, description=:description, image_url=:image,
                                site_url=:site, mots_cles=:mots
                            WHERE id=:id";
                    $stmt = $db->prepare($sql);
                    $stmt->execute([
                        'id' => $id,
                        'nom' => $nom,
                        'description' => $description,
                        'image' => $image,
                        'site' => $site,
                        'mots' => $mots
                    ]);
                },

                'delete' => function($id) use ($db) {
                    $stmt = $db->prepare("DELETE FROM entreprises WHERE id = :id");
                    $stmt->execute(['id' => $id]);
                },

            ];
        },

    ]);
};
