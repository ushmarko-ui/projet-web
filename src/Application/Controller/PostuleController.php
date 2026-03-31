<?php

namespace App\Application\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Doctrine\ORM\EntityManager;
use App\Domain\Candidature;
use App\Domain\Offres;
use Slim\Views\Twig;
use Slim\Routing\RouteContext;

class PostuleController
{
    private EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function afficher2(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);

        // On récupère l'ID de l'offre pour l'envoyer à la vue (pour le bouton submit)
        $idOffre = $args['id'] ?? null;

        return $view->render($response, 'Formulaire_postule.html.twig', [
            'offre_id' => $idOffre
        ]);
    }

    public function traiter(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $data = $request->getParsedBody();
        $uploadedFiles = $request->getUploadedFiles();
        $idOffre = (int)$args['id'];
        $user = $request->getAttribute('user');

        // Nettoyage des données
        $prenom      = htmlspecialchars($data['prenom']      ?? '', ENT_QUOTES, 'UTF-8');
        $nom         = htmlspecialchars($data['nom']         ?? '', ENT_QUOTES, 'UTF-8');
        $email       = filter_var($data['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $description = htmlspecialchars($data['description'] ?? '', ENT_QUOTES, 'UTF-8');
        $telephone   = htmlspecialchars($data['telephone']   ?? '', ENT_QUOTES, 'UTF-8');

        $error   = null;
        $success = null;

        //validations probleme peut etre sur email mais a changer facon
        if (empty($prenom)) {
            $error = "Le prénom est obligatoire.";
        } elseif (preg_match("/[^A-Za-zÀ-ÿ\s-]/", $prenom)) {
            $error = "Votre prénom ne doit contenir que des lettres.";
        } elseif (empty($nom)) {
            $error = "Le nom est obligatoire.";
        } elseif (preg_match("/[^A-Za-zÀ-ÿ\s-]/", $nom)) {
            $error = "Votre nom ne doit contenir que des lettres.";
        } elseif (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "L'adresse email '$email' n'est pas valide.";
        } elseif (empty($telephone)) {
            $error = "Le numéro est obligatoire.";
        } elseif (!preg_match("/^[0-9]+$/", $telephone)) {
            $error = "Votre numéro ne doit contenir que des chiffres.";
        }

        //si pas erreur
        if ($error === null) {
            if (isset($uploadedFiles['fichier']) && $uploadedFiles['fichier']->getError() === UPLOAD_ERR_OK) {
                $fichier  = $uploadedFiles['fichier'];
                $mimeType = $fichier->getClientMediaType();

                if ($mimeType !== 'application/pdf') {
                    $error = "Type de fichier non autorisé (PDF uniquement).";
                } elseif ($fichier->getSize() > 2 * 1024 * 1024) {
                    $error = "Fichier trop volumineux (max 2MB).";
                } else {
                    $uploadDir = __DIR__ . '/../../../public/uploads/';
                    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

                    $filename = uniqid() . "_" . basename($fichier->getClientFilename());
                    $fichier->moveTo($uploadDir . $filename);

                    //enregistre dans la bdd
                    $offre = $this->em->find(Offres::class, $idOffre);

                    if ($offre && $user) {
                        $candidature = new Candidature(
                            $offre->getNom(),
                            $offre->getDomaine(),
                            $offre->getLieu(),
                            $offre->getEmail(),
                            $offre->getDescription(),
                            $offre->getDuree(),
                            $offre->getNiveau(),
                            $offre->getSalaire(),
                            $user
                        );

                        $this->em->persist($candidature);
                        $this->em->flush();

                        // Redirection vers la liste des candidatures après succès
                        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
                        return $response->withHeader('Location', $routeParser->urlFor('candidature'))->withStatus(302);
                    } else {
                        $error = "Offre introuvable en base de données.";
                    }
                }
            } else {
                $error = "Veuillez joindre votre CV (PDF).";
            }
        }

        // si erreur remet formulaire
        $view = Twig::fromRequest($request);
        return $view->render($response, 'Formulaire_postule.html.twig', [
            'error'       => $error,
            'prenom'      => $prenom,
            'nom'         => $nom,
            'email'       => $email,
            'description' => $description,
            'telephone'   => $telephone,
            'id'          => $idOffre
        ]);
    }
}
