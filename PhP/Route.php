<?php

return function ($app) {

    $app->get('/', function ($request, $response) {
        return $this->get('view')->render($response, 'home.twig');
    });

    $app->get('/search', function ($request, $response) {
        $mot = $request->getQueryParams()['q'] ?? '';

        $sql = "SELECT * FROM entreprises
                WHERE nom LIKE :mot
                   OR description LIKE :mot
                   OR mots_cles LIKE :mot";

        $stmt = $this->get('db')->prepare($sql);
        $stmt->execute(['mot' => "%$mot%"]);
        $entreprises = $stmt->fetchAll();

        return $this->get('view')->render($response, 'search.twig', [
            'entreprises' => $entreprises,
            'mot' => $mot
        ]);
    });

};
