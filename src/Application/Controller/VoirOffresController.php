<?php

namespace App\Application\Controller;

use App\Domain\Offres;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class VoirOffresController
{
    private EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function VoirOffres(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        $nom = $args['nom'];
        $repository = $this->em->getRepository(Offres::class);

        $page = isset($args['page']) ? (int)$args['page'] : 1;
        $parPage = 9;
        $offset = ($page - 1) * $parPage;

        $totalOffres = $repository->createQueryBuilder('e')
            ->select('COUNT(e.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $VoirOffres = $repository->createQueryBuilder('e')
            ->where('e.nom = :nom')
            ->setParameter('nom', $nom)
            ->setFirstResult($offset)
            ->setMaxResults($parPage)
            ->getQuery()
            ->getResult();

        $totalPages = (int)ceil($totalOffres / $parPage);
        $session = $request->getAttribute('session');

        return $view->render($response, 'Voir_les_offres.html.twig', [
            'role' => $session['userRole'] ?? '',
            'VoirOffres' => $VoirOffres,
            'page' => $page,
            'totalPages' => $totalPages,
            'nom' => $nom,
        ]);
    }
}
