<?php

namespace App\Application\Controller;

use App\Domain\Candidature;
use App\Domain\Role;
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
        $userConnecte = $request->getAttribute('user');
        $roleConnecte = $userConnecte->getRole();
        $repository = $this->em->getRepository(Candidature::class);

        $qb = $repository->createQueryBuilder('c')->join('c.utilisateur', 'u');

        if ($roleConnecte === Role::ETUDIANT) {
            $qb->where('c.utilisateur = :user')
                ->setParameter('user', $userConnecte);
        } elseif ($roleConnecte === Role::PILOTE) {
            $qb->where('u.campus = :campus')
                ->setParameter('campus', $userConnecte->getCampus());
        }

        $candidatures = $qb->getQuery()->getResult();

        return $view->render($response, 'MaCandidature.html.twig', [
            'candidatures' => $candidatures,
            'role' => $roleConnecte->value,
        ]);
    }

    public function changerStatut(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = (int)$args['id'];
        $statut = $args['statut'];
        $candidature = $this->em->find(Candidature::class, $id);

        if ($candidature) {
            $candidature->setStatut($statut);
            $this->em->flush();
        }

        return $response->withHeader('Location', '/candidature')->withStatus(302);
    }
}
