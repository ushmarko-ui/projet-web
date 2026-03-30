<?php
declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

define('APP_ROOT', __DIR__);

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'displayErrorDetails' => true,
                'logError'            => false,
                'logErrorDetails'     => false,
                'logger' => [
                    'name' => 'slim-app',
                    'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],
                'doctrine' => [
                    'dev_mode'      => true,
                    'cache_dir'     => APP_ROOT . '/var/doctrine',
                    'metadata_dirs' => [APP_ROOT . '/src/Domain'],
                    'connection'    => [
                        'driver'   => 'pdo_mysql',
                        'host'     => '127.0.0.1',
                        'port'     => 3307,
                        'dbname'   => 'toto',
                        'user'     => 'root',
                        'password' => 'example',
                        'charset'  => 'utf8mb4',
                    ],
                ],
            ]);
        }
    ]);
};