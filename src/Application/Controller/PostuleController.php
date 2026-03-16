<?php

namespace App\Application\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class PostuleController
{
    public function afficher2(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'Formulaire_postule.html.twig', ['role' => $session['userRole'] ?? '']);
    }

    public function traiter(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {

        $data        = $request->getParsedBody();
        $uploadedFiles = $request->getUploadedFiles();

        $prenom      = htmlspecialchars($data['prenom']      ?? '', ENT_QUOTES, 'UTF-8');
        $nom         = htmlspecialchars($data['nom']         ?? '', ENT_QUOTES, 'UTF-8');
        $email       = filter_var($data['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $description = htmlspecialchars($data['description'] ?? '', ENT_QUOTES, 'UTF-8');
        $telephone = htmlspecialchars($data['telephone'] ?? '', ENT_QUOTES, 'UTF-8');

        $error   = null;
        $success = null;

        if (empty($prenom)) {
            $error = "le prenom est obligatoire";
        } elseif (preg_match("/([^A-Za-z])/", $prenom)) {
            $error = "Votre prénom ne doit contenir que des lettres.";
        } elseif (empty($nom)) {
            $error = 'le nom est obligatoire';
        } elseif (preg_match("/([^A-Za-z])/", $nom)) {
            $error = "Votre nom ne doit contenir que des lettres.";
        } elseif (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "L'adresse email '$email' n'est pas valide";
        } elseif (empty($telephone)) {
            $error = "le numero est obligatoire";
        } elseif (!preg_match("/^[0-9]+$/", $telephone)) {
            $error = "Votre numero ne doit pas contenir de lettre.";
        }
        // Gestion fichier
        if ($error === null) {
            if (isset($uploadedFiles['fichier'])) {
                $fichier  = $uploadedFiles['fichier'];
                $mimeType = $fichier->getClientMediaType();

                if ($fichier->getError() !== UPLOAD_ERR_OK) {
                    $error = "Erreur lors de l'upload du fichier.";
                } elseif ($mimeType !== 'application/pdf') {
                    $error = "Type de fichier non autorisé (PDF uniquement).";
                } elseif ($fichier->getSize() > 2 * 1024 * 1024) {
                    $error = "Fichier trop volumineux (max 2MB).";
                } else {
                    $uploadDir = __DIR__ . '/../../../public/uploads/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    $filename = basename($fichier->getClientFilename());
                    $fichier->moveTo($uploadDir . $filename);
                    $success = "Candidature envoyée avec succès, $prenom $nom !";
                }
            } else {
                $error = "Aucun fichier reçu.";
            }
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, 'Formulaire_postule.html.twig', [
            'error'       => $error,
            'success'     => $success,
            'prenom'      => $prenom,
            'nom'         => $nom,
            'email'       => $email,
            'description' => $description,
            'telephone' => $telephone,
        ]);
    }
}
