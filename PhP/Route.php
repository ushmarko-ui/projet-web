<?php
use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use PDO;

return function ($app, $db) {

    // --- ACCUEIL ---
    $app->get('/', function (Request $request, Response $response) {
        return Twig::fromRequest($request)->render($response, 'Index.html');
    });

    // --- RECHERCHE ET OFFRES ---
    $app->get('/trouver-stage', function (Request $request, Response $response) {
        return Twig::fromRequest($request)->render($response, 'HTML/Trouver_mon_stage.html');
    });

    $app->get('/trouver-entreprise', function (Request $request, Response $response) {
        return Twig::fromRequest($request)->render($response, 'HTML/Trouver_une_entreprise.html');
    });

    // --- GESTION ENTREPRISE (AFFICHAGE) ---
    $app->get('/gestion-entreprise', function (Request $request, Response $response) use ($db) {
        $query = $db->query("SELECT * FROM entreprises");
        $entreprises = $query->fetchAll(PDO::FETCH_ASSOC);

        return Twig::fromRequest($request)->render($response, 'HTML/creation_entreprise.html', [
            'entreprises' => $entreprises
        ]);
    });

    // --- GESTION ENTREPRISE (AJOUT RÉEL EN BASE) ---
    $app->post('/gestion-entreprise/ajouter', function (Request $request, Response $response) use ($db) {
        $data = $request->getParsedBody();

        // On insère TOUTES les données du formulaire
        $sql = "INSERT INTO entreprises (nom, secteur, localite, email, description) 
                VALUES (:nom, :secteur, :localite, :email, :description)";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':nom'         => $data['nom'],
            ':secteur'     => $data['secteur'],
            ':localite'    => $data['localite'],
            ':email'       => $data['email'],
            ':description' => $data['description']
        ]);

        return $response->withHeader('Location', '/gestion-entreprise')->withStatus(302);
    });

    // --- AUTRES ROUTES ---
    $app->get('/connexion', function (Request $request, Response $response) {
        return Twig::fromRequest($request)->render($response, 'HTML/page_connexion.html');
    });

    $app->get('/inscription', function (Request $request, Response $response) {
        return Twig::fromRequest($request)->render($response, 'HTML/page_creation_compte.html');
    });

    $app->get('/gestion-etudiants', function (Request $request, Response $response) {
        return Twig::fromRequest($request)->render($response, 'HTML/gestion_etudiants.html');
    });

    $app->get('/gestion-offres', function (Request $request, Response $response) {
        return Twig::fromRequest($request)->render($response, 'HTML/gestion_offres.html');
    });

    $app->get('/mentions-legales', function (Request $request, Response $response) {
        return Twig::fromRequest($request)->render($response, 'HTML/mentions.html');
    });

}; // <--- L'ACCOLADE DOIT BIEN ÊTRE ICI À LA FIN