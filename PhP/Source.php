$container->set('db', function () {
    $host = 'db'; // nom du service docker
    $dbname = 'stage_explorer';
    $user = 'user_stage';
    $pass = 'password_stage';

    return new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
});