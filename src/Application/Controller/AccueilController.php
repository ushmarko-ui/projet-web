<?php

namespace App\Application\Controller;

use App\Domain\Offres;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class AccueilController
{
    private EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function home(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        $session = $request->getAttribute('session');
        $repository = $this->em->getRepository(Offres::class);

        $offres = $repository->findBy([], ['id' => 'ASC'], 3);

        return $view->render($response, 'Index.html.twig', ['role' => $session['userRole'] ?? '', 'offres' => $offres]);
    }
}
