<?php

namespace App\Application\Controller;

use App\Domain\Souhait;
use App\Domain\Offres; // Pour pouvoir afficher les détails de l'offre
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Slim\Routing\RouteContext;
use Slim\Routing\RouteContext;

class SouhaitController
{
    private EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    private EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function souhait(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        $session = $request->getAttribute('session');
        $userId = $session['userId'] ?? 1; // On récupère l'utilisateur connecté

        // On va chercher tous les souhaits de cet utilisateur
        $repository = $this->em->getRepository(Souhait::class);
        $souhaitsEnregistres = $repository->findBy(['userId' => $userId]);

        // Pour chaque souhait, on va récupérer les détails de l'offre correspondante
        $listeOffres = [];
        foreach ($souhaitsEnregistres as $souhait) {
            $offre = $this->em->find(Offres::class, $souhait->getOffreId());
            if ($offre) {
                $listeOffres[] = $offre;
            }
        }

        return $view->render($response, 'liste_de_souhait.html.twig', [
            'role' => $session['userRole'] ?? '',
            'souhaits' => $listeOffres, // On envoie les vraies offres à Twig
        ]);
    }

    // Cette fonction gère l'action du bouton "Enregistrer"
    public function ajouter(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $offreId = (int)$args['id'];
        $session = $request->getAttribute('session');
        $userId = $session['userId'] ?? 1;

        // Création et sauvegarde
        $souhait = new Souhait($offreId, $userId);
        $this->em->persist($souhait);
        $this->em->flush();

        // Redirection vers la liste
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        return $response->withHeader('Location', $routeParser->urlFor('souhait'))->withStatus(302);
    }

    public function ajouter(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = (int)$args['id'];
        $offre = $this->em->find(Offres::class, $id);

        if ($offre) {
            $souhait = new Souhait(
                $offre->getNom(),
                $offre->getDomaine(),
                $offre->getLieu(),
                $offre->getEmail(),
                $offre->getDescription(),
                $offre->getDuree(),
                $offre->getNiveau(),
                $offre->getSalaire()
            );
            $this->em->persist($souhait);
            $this->em->flush();
        }

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('souhait');
        return $response->withHeader('Location', $url)->withStatus(302);
    }

    public function supprimer(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = (int)$args['id'];
        $souhait = $this->em->find(Souhait::class, $id);

        if ($souhait) {
            $this->em->remove($souhait);
            $this->em->flush();
        }

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('souhait');
        return $response->withHeader('Location', $url)->withStatus(302);
    }
}
