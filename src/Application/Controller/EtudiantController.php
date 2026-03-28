<?php

namespace App\Application\Controller;

use App\Domain\Utilisateur;
use App\Domain\Role;
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
        $repository = $this->em->getRepository(Utilisateur::class);

        $page = isset($args['page']) ? (int)$args['page'] : 1;
        $parPage = 9;
        $offset = ($page - 1) * $parPage;

        $totalEtudiants = $repository->createQueryBuilder('o')
            ->select('COUNT(o.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $gestion_etudiants = $repository->createQueryBuilder('o')
            ->where('o.role = :role')
            ->setParameter('role', Role::ETUDIANT)
            ->orderBy('o.id', 'ASC')
            ->setFirstResult($offset)
            ->setMaxResults($parPage)
            ->getQuery()
            ->getResult();

        $totalPages = (int)ceil($totalEtudiants / $parPage);

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
            $mot_de_passe = trim($parsedBody['mot_de_passe'] ?? '');
            $roleStr = trim($parsedBody['role'] ?? 'pilote');
            $role = Role::from($roleStr);
            $lieu = trim($parsedBody['lieu'] ?? '');

            if ($nom !== '' && $email !== '') {
                $etudiants = new Utilisateur($nom, $prenom, $lieu, $email, $mot_de_passe, $role);
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
        $etudiants = $this->em->find(Utilisateur::class, $id);

        if (!$etudiants) {
            return $response->withStatus(404);
        }

        if ($request->getMethod() === 'POST') {
            $parsedBody = $request->getParsedBody();
            $nom = trim($parsedBody['nom'] ?? '');
            $prenom = trim($parsedBody['prenom'] ?? '');
            $email = trim($parsedBody['email'] ?? '');
            $lieu = trim($parsedBody['lieu'] ?? '');
            $mot_de_passe = trim($parsedBody['mot_de_passe'] ?? '');
            $roleStr = trim($parsedBody['role'] ?? 'pilote');
            $role = Role::from($roleStr);

            if ($nom !== '' && $prenom !== '') {
                $etudiants->setNom($nom);
                $etudiants->setPrenom($prenom);
                $etudiants->setLieu($lieu);
                $etudiants->setEmail($email);
                $etudiants->setMotDePasse($mot_de_passe);
                $etudiants->setRole($role);
                $this->em->flush();

                $routeParser = RouteContext::fromRequest($request)->getRouteParser();
                $url = $routeParser->urlFor('gestion_etudiants');
                return $response->withHeader('Location', $url)->withStatus(302);
            }
        }

        return $view->render($response, 'modifier_etudiants.html.twig', [
            'gestion_etudiants' => $etudiants,
        ]);
    }

    public function supprimer(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = (int)$args['id'];
        $etudiants = $this->em->find(Utilisateur::class, $id);

        if ($etudiants) {
            $this->em->remove($etudiants);
            $this->em->flush();
        }

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('gestion_etudiants');
        return $response->withHeader('Location', $url)->withStatus(302);
    }
}
