<?php

namespace App\Application\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class ConnexionController
{
    public function afficher(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $role = $request->getQueryParams()['role'] ?? '';
        $view = Twig::fromRequest($request);
        return $view->render($response, 'page_connexion.html.twig', ['role' => $role]);
    }

    public function connecter(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $data     = $request->getParsedBody();
        $role     = $data['role']     ?? '';
        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';

        if ($role === 'admin' && $username === 'admin_user' && $password === 'admin123') {
            $_SESSION['userRole'] = 'admin';
            return $response->withHeader('Location', '/')->withStatus(302);
        }

        if ($role === 'pilote' && $username === 'pilote_user' && $password === 'pilote123') {
            $_SESSION['userRole'] = 'pilote';
            return $response->withHeader('Location', '/')->withStatus(302);
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, 'page_connexion.html.twig', [
            'role'  => $role,
            'error' => 'Identifiants incorrects !',
        ]);
    }

    public function deconnecter(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        session_destroy();
        return $response->withHeader('Location', '/')->withStatus(302);
    }
}
