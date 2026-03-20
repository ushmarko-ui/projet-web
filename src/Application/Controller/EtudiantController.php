<?php

namespace App\Application\Controller;

use App\Domain\Etudiant;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Slim\Routing\RouteContext;

class EtudiantController
{
    private EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function gestion_etudiants(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        $repository = $this->em->getRepository(Etudiant::class);

        $page = (int)($request->getQueryParams()['page'] ?? 1);
        $parPage = 9;
        $offset = ($page - 1) * $parPage;

        $totalOffres = $repository->createQueryBuilder('o')
            ->select('COUNT(o.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $gestion_etudiants = $repository->createQueryBuilder('o')
            ->orderBy('o.id', 'ASC')
            ->setFirstResult($offset)
            ->setMaxResults($parPage)
            ->getQuery()
            ->getResult();

        $totalPages = (int)ceil($totalOffres / $parPage);

        return $view->render($response, 'gestion_etudiants.html.twig', [
            'gestion_etudiants' => $gestion_etudiants,
            'page' => $page,
            'totalPages' => $totalPages,
        ]);
    }

    public function ajoute(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        if ($request->getMethod() === 'POST') {
            $parsedBody = $request->getParsedBody();
            $nom = trim($parsedBody['nom'] ?? '');
            $prenom = trim($parsedBody['prenom'] ?? '');
            $email = trim($parsedBody['email'] ?? '');
            $age = trim($parsedBody['age'] ?? '');

            if ($nom !== '' && $email !== '') {
                $etudiants = new Etudiant($nom, $prenom, $age, $email);
                $this->em->persist($etudiants);
                $this->em->flush();
            }
        }

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('gestion_etudiants');
        return $response->withHeader('Location', $url)->withStatus(302);
    }

    public function modifier(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        $id = (int)$args['id'];
        $etudiants = $this->em->find(Etudiant::class, $id);

        if (!$etudiants) {
            return $response->withStatus(404);
        }

        if ($request->getMethod() === 'POST') {
            $parsedBody = $request->getParsedBody();
            $etudiants->setNom(trim($parsedBody['nom'] ?? ''));
            $etudiants->setDomaine(trim($parsedBody['prenom'] ?? ''));
            $etudiants->setLieu(trim($parsedBody['email'] ?? ''));
            $etudiants->setDescription(trim($parsedBody['age'] ?? ''));

            $this->em->flush();

            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            $url = $routeParser->urlFor('gestion_etudiants');
            return $response->withHeader('Location', $url)->withStatus(302);
        }

        return $view->render($response, 'gestion_etudiants.html.twig', [
            'gestion_etudiants' => $etudiants,
        ]);
    }

    public function supprimer(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = (int)$args['id'];
        $etudiants = $this->em->find(Etudiant::class, $id);

        if ($etudiants) {
            $this->em->remove($etudiants);
            $this->em->flush();
        }

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('gestion_etudiants');
        return $response->withHeader('Location', $url)->withStatus(302);
    }
}
