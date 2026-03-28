<?php

namespace App\Application\Controller;

use App\Domain\Utilisateur;
use App\Domain\Role;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Slim\Routing\RouteContext;

class PiloteController
{
    private EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function gestion_pilotes(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        $repository = $this->em->getRepository(Utilisateur::class);

        $page = isset($args['page']) ? (int)$args['page'] : 1;
        $parPage = 9;
        $offset = ($page - 1) * $parPage;

        $totalPilotes = $repository->createQueryBuilder('e')
            ->select('COUNT(e.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $gestion_pilotes = $repository->createQueryBuilder('e')
            ->where('e.role = :role')
            ->setParameter('role', Role::PILOTE)
            ->orderBy('e.id', 'ASC')
            ->setFirstResult($offset)
            ->setMaxResults($parPage)
            ->getQuery()
            ->getResult();

        $totalPages = (int)ceil($totalPilotes / $parPage);

        return $view->render($response, 'gestion_pilotes.html.twig', [
            'gestion_pilotes' => $gestion_pilotes,
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
            $lieu = trim($parsedBody['lieu'] ?? '');
            $email = trim($parsedBody['email'] ?? '');
            $mot_de_passe = trim($parsedBody['mot_de_passe'] ?? '');
            $roleStr = trim($parsedBody['role'] ?? 'etudiant');
            $role = Role::from($roleStr);

            if ($nom !== '' && $prenom !== '') {
                $pilotes = new Utilisateur($nom, $prenom, $lieu, $email, $mot_de_passe, $role);
                $this->em->persist($pilotes);
                $this->em->flush();
            }
        }

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('gestion_pilotes');
        return $response->withHeader('Location', $url)->withStatus(302);
    }

    public function modifier(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        $id = (int)$args['id'];
        $pilotes = $this->em->find(Utilisateur::class, $id);

        if (!$pilotes) {
            return $response->withStatus(404);
        }

        if ($request->getMethod() === 'POST') {
            $parsedBody = $request->getParsedBody();
            $nom = trim($parsedBody['nom'] ?? '');
            $prenom = trim($parsedBody['prenom'] ?? '');
            $lieu = trim($parsedBody['lieu'] ?? '');
            $email = trim($parsedBody['email'] ?? '');
            $mot_de_passe = trim($parsedBody['mot_de_passe'] ?? '');
            $roleStr = trim($parsedBody['role'] ?? 'etudiant');
            $role = Role::from($roleStr);

            if ($nom !== '' && $prenom !== '') {
                $pilotes->setNom($nom);
                $pilotes->setPrenom($prenom);
                $pilotes->setLieu($lieu);
                $pilotes->setEmail($email);
                $pilotes->setMotDePasse($mot_de_passe);
                $pilotes->setRole($role);
                $this->em->flush();
            }

            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            $url = $routeParser->urlFor('gestion_pilotes');
            return $response->withHeader('Location', $url)->withStatus(302);
        }

        return $view->render($response, 'modifier_pilotes.html.twig', [
            'gestion_pilotes' => $pilotes,
        ]);
    }

    public function supprimer(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = (int)$args['id'];
        $pilotes = $this->em->find(Utilisateur::class, $id);

        if ($pilotes) {
            $this->em->remove($pilotes);
            $this->em->flush();
        }

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('gestion_pilotes');
        return $response->withHeader('Location', $url)->withStatus(302);
    }
}
