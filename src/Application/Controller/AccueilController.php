<?php

namespace App\Application\Controller;

use App\Domain\Offres;
use App\Domain\Candidature;
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
        $repoCandidatures = $this->em->getRepository(Candidature::class);

        $offres = $repository->findBy([], ['id' => 'ASC'], 3);

        $totalOffres = $repository->count([]);

        $totalPostulations = $repoCandidatures->count([]);

        return $view->render($response, 'Index.html.twig', ['role' => $session['userRole'] ?? '', 'offres' => $offres, 'totalOffres' => $totalOffres, 'totalPostulations' => $totalPostulations]);
    }
}
