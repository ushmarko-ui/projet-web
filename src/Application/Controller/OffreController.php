<?php

namespace App\Application\Controller;

use App\Domain\Offres;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Slim\Routing\RouteContext;

class OffreController
{
    private EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function gestion_offres(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        $repository = $this->em->getRepository(Offres::class);

        $page = isset($args['page']) ? (int)$args['page'] : 1;
        $parPage = 9;
        $offset = ($page - 1) * $parPage;

        $totalOffres = $repository->createQueryBuilder('o')
            ->select('COUNT(o.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $gestion_offres = $repository->createQueryBuilder('o')
            ->orderBy('o.id', 'ASC')
            ->setFirstResult($offset)
            ->setMaxResults($parPage)
            ->getQuery()
            ->getResult();

        $totalPages = (int)ceil($totalOffres / $parPage);

        return $view->render($response, 'gestion_offres.html.twig', [
            'gestion_offres' => $gestion_offres,
            'page' => $page,
            'totalPages' => $totalPages,
        ]);
    }

    public function ajoute(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        if ($request->getMethod() === 'POST') {
            $parsedBody = $request->getParsedBody();
            $nom = trim($parsedBody['nom'] ?? '');
            $domaine = trim($parsedBody['domaine'] ?? '');
            $lieu = trim($parsedBody['lieu'] ?? '');
            $email = trim($parsedBody['email'] ?? '');
            $description = trim($parsedBody['description'] ?? '');
            $duree = trim($parsedBody['duree'] ?? '');

            if ($nom !== '' && $description !== '') {
                $offre = new Offres($nom, $domaine, $lieu, $email, $description, $duree);
                $this->em->persist($offre);
                $this->em->flush();
            }
        }

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('gestion_offres');
        return $response->withHeader('Location', $url)->withStatus(302);
    }

    public function modifier(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        $id = (int)$args['id'];
        $offre = $this->em->find(Offres::class, $id);

        if (!$offre) {
            return $response->withStatus(404);
        }

        if ($request->getMethod() === 'POST') {
            $parsedBody = $request->getParsedBody();

            $nom = trim($parsedBody['nom'] ?? '');
            $domaine = trim($parsedBody['domaine'] ?? '');
            $lieu = trim($parsedBody['lieu'] ?? '');
            $email = trim($parsedBody['email'] ?? '');
            $description = trim($parsedBody['description'] ?? '');
            $duree = trim($parsedBody['duree'] ?? '');

            if ($nom !== '' && $description !== '') {
                $offre->setNom($nom);
                $offre->setDomaine($domaine);
                $offre->setLieu($lieu);
                $offre->setEmail($email);
                $offre->setDescription($description);
                $offre->setDuree($duree);
                $this->em->flush();

                $routeParser = RouteContext::fromRequest($request)->getRouteParser();
                $url = $routeParser->urlFor('gestion_offres');
                return $response->withHeader('Location', $url)->withStatus(302);
            }
        }

        return $view->render($response, 'modifier_offres.html.twig', [
            'gestion_offres' => $offre,
        ]);
    }

    public function supprimer(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = (int)$args['id'];
        $offre = $this->em->find(Offres::class, $id);

        if ($offre) {
            $this->em->remove($offre);
            $this->em->flush();
        }

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('gestion_offres');
        return $response->withHeader('Location', $url)->withStatus(302);
    }
}
