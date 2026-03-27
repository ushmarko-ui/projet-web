<?php

namespace App\Application\Controller;

use App\Domain\Candidature;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class CandidatureController
{
    private EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function candidature(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        $candidatures = $this->em->getRepository(Candidature::class)->findAll();

        return $view->render($response, 'MaCandidature.html.twig', [
            'candidatures' => $candidatures,
        ]);
    }
}
