<?php

namespace App\Application\Controller;

use App\Domain\Entreprise;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Slim\Routing\RouteContext;

class CreationEntrepriseController
{
    private EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function creation_entreprise(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        $repository = $this->em->getRepository(Entreprise::class);

        $perPage = 10;
        $page = isset($args['page']) ? (int)$args['page'] : 1;
        $offset = ($page - 1) * $perPage;

        $totalEntreprises = $repository->createQueryBuilder('e')
            ->select('COUNT(e.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $creation_entreprises = $repository->createQueryBuilder('e')
            ->orderBy('e.id', 'ASC')
            ->setFirstResult($offset)
            ->setMaxResults($perPage)
            ->getQuery()
            ->getResult();

        $totalPages = (int)ceil($totalEntreprises / $perPage);

        return $view->render($response, 'creation_entreprise.html.twig', [
            'creation_entreprises' => $creation_entreprises,
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

            if ($nom !== '' && $domaine !== '') {
                $entreprise = new Entreprise($nom, $domaine, $lieu, $email);
                $this->em->persist($entreprise);
                $this->em->flush();
            }
        }

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('creation_entreprise');
        return $response->withHeader('Location', $url)->withStatus(302);
    }

    public function modifier(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        $id = (int)$args['id'];
        $entreprise = $this->em->find(Entreprise::class, $id);

        if (!$entreprise) {
            return $response->withStatus(404);
        }

        if ($request->getMethod() === 'POST') {
            $parsedBody = $request->getParsedBody();
            $nom = trim($parsedBody['nom'] ?? '');
            $domaine = trim($parsedBody['domaine'] ?? '');
            $lieu = trim($parsedBody['lieu'] ?? '');
            $email = trim($parsedBody['email'] ?? '');

            if ($nom !== '' && $domaine !== '') {
                $entreprise->setNom($nom);
                $entreprise->setDomaine($domaine);
                $entreprise->setLieu($lieu);
                $entreprise->setEmail($email);
                $this->em->flush();
            }

            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            $url = $routeParser->urlFor('creation_entreprise');
            return $response->withHeader('Location', $url)->withStatus(302);
        }

        return $view->render($response, 'creation_entreprise.html.twig', [
            'entreprise' => $entreprise,
        ]);
    }

    public function supprimer(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = (int)$args['id'];
        $entreprise = $this->em->find(Entreprise::class, $id);

        if ($entreprise) {
            $this->em->remove($entreprise);
            $this->em->flush();
        }

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('creation_entreprise');
        return $response->withHeader('Location', $url)->withStatus(302);
    }
}
