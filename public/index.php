<?php

use Slim\Factory\AppFactory;
use Slim\Psr7\Factory\ResponseFactory;

require __DIR__ . '/../vendor/autoload.php';

// Configuration de l'implémentation PSR-17
AppFactory::setResponseFactory(new ResponseFactory());

// Création de l'application Slim
$app = AppFactory::create();

// Configuration de Plates
$container = $app->getContainer();
$container->set('view', function () {
    return new \League\Plates\Engine(__DIR__ . '/../src/View/templates');
});

// Configuration de la base de données (PDO)
$container->set('db', function () {
    $host = 'localhost';
    $dbname = 'blog';
    $user = 'root';
    $pass = '';

    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

    return new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
});

// Routes
$app->get('/articles', 'App\Controller\ArticleController:postIndex');


// Exécution de Slim
$app->run();
