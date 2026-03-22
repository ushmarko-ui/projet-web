<?php

namespace App\Application\Controller;

use App\Domain\Offres;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class StageController
{
    private EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function stage(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        $session = $request->getAttribute('session');
        $repository = $this->em->getRepository(Offres::class);

        $page = isset($args['page']) ? (int)$args['page'] : 1;
        $parPage = 9;
        $offset = ($page - 1) * $parPage;

        $totalEntreprises = $repository->createQueryBuilder('e')
            ->select('COUNT(e.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $stages = $repository->createQueryBuilder('e')
            ->orderBy('e.nom', 'ASC')
            ->setFirstResult($offset)
            ->setMaxResults($parPage)
            ->getQuery()
            ->getResult();

        $totalPages = (int)ceil($totalEntreprises / $parPage);

        return $view->render($response, 'Trouver_mon_stage.html.twig', [
            'role' => $session['userRole'] ?? '',
            'stages' => $stages,
            'page' => $page,
            'totalPages' => $totalPages,
        ]);
    }
}
