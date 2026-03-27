<?php

namespace App\Application\Controller;

use App\Domain\Candidature;
use App\Domain\Offres;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Slim\Routing\RouteContext;

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

    public function postuler(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = (int)$args['id'];
        $offre = $this->em->find(Offres::class, $id);

        if ($offre) {
            $candidature = new Candidature(
                $offre->getNom(),
                $offre->getDomaine(),
                $offre->getLieu(),
                $offre->getEmail(),
                $offre->getDescription(),
                $offre->getDuree(),
                $offre->getNiveau(),
                $offre->getSalaire(),

            );
            $this->em->persist($candidature);
            $this->em->flush();
        }

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        return $response->withHeader('Location', $routeParser->urlFor('candidature'))->withStatus(302);
    }
}
