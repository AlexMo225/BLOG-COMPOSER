<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ArticleController
{
    private $view;
    private $db;

    public function __construct($view, $db)
    {
        $this->view = $view;
        $this->db = $db;
    }

    public function postIndex(Request $request, Response $response, $args)
    {
        // Affichage de tous les articles
        // Implémentez la logique pour récupérer tous les articles depuis la base de données
        $stmt = $this->db->query('SELECT * FROM posts');
        $articles = $stmt->fetchAll();

        return $this->view->render($response, 'articles/index.php', [
            'articles' => $articles,
        ]);
    }

    public function postCreate(Request $request, Response $response, $args)
    {
        // Affichage du formulaire de création d'un article
        return $this->view->render($response, 'articles/create.php');
    }

    public function postShow(Request $request, Response $response, $args)
{
    // Vérifier que le query parameter {id} existe et soit un entier, sinon renvoyer une erreur 400
    $id = $args['id'];
    if (!is_numeric($id)) {
        return $response->withStatus(400)->write('L\'ID doit être un entier.');
    }

    // Vérifier que l'article correspondant au query parameter {id} existe, sinon renvoyer une erreur 404
    $article = $this->postModel->getPostById($id);
    if (!$article) {
        return $response->withStatus(404)->write('Article non trouvé.');
    }

    return $this->view->render($response, 'articles/show.php', [
        'article' => $article,
    ]);
}
public function postStore(Request $request, Response $response, $args)
{
    // Vérifier que les champs title et body existent et soient remplis, sinon renvoyer l'utilisateur sur le formulaire de création en gardant les informations qu'il a rentrées et en affichant un message d'erreur
    $data = $request->getParsedBody();
    $title = $data['title'] ?? '';
    $body = $data['body'] ?? '';

    if (empty($title) || empty($body)) {
        return $response->withRedirect('/articles/create')
            ->withStatus(400)
            ->withJson(['error' => 'Les champs title et body sont obligatoires.']);
    }

    // Insérer l'article dans la base de données
    $this->postModel->createPost($title, $body);

    return $response->withRedirect('/articles');
}

public function postEdit(Request $request, Response $response, $args)
{
    // Vérifier que le query parameter {id} existe et soit un entier, sinon renvoyer une erreur 400
    $id = $args['id'];
    if (!is_numeric($id)) {
        return $response->withStatus(400)->write('L\'ID doit être un entier.');
    }

    // Vérifier que l'{id} passé en paramètre corresponde bien à un article, sinon renvoyer une erreur 404
    $article = $this->postModel->getPostById($id);
    if (!$article) {
        return $response->withStatus(404)->write('Article non trouvé.');
    }

    return $this->view->render($response, 'articles/edit.php', [
        'article' => $article,
    ]);
}

public function postUpdate(Request $request, Response $response, $args)
{
    // Vérifier que le query parameter {id} existe et soit un entier, sinon renvoyer une erreur 400
    $id = $args['id'];
    if (!is_numeric($id)) {
        return $response->withStatus(400)->write('L\'ID doit être un entier.');
    }

    // Vérifier que l'{id} passé en paramètre corresponde bien à un article, sinon renvoyer une erreur 404
    $existingArticle = $this->postModel->getPostById($id);
    if (!$existingArticle) {
        return $response->withStatus(404)->write('Article non trouvé.');
    }

    // Vérifier que les champs title et body existent et soient remplis, sinon renvoyer l'utilisateur sur le formulaire de modification en gardant les informations qu'il a rentrées et en affichant un message d'erreur
    $data = $request->getParsedBody();
    $title = $data['title'] ?? '';
    $body = $data['body'] ?? '';

    if (empty($title) || empty($body)) {
        return $this->view->render($response, 'articles/edit.php', [
            'article' => $existingArticle,
            'error' => 'Les champs title et body sont obligatoires.',
        ]);
    }

    // Mettre à jour l'article dans la base de données
    $this->postModel->updatePost($id, $title, $body);

    return $response->withRedirect('/articles');
}

public function postDestroy(Request $request, Response $response, $args)
{
    // Vérifier que le query parameter {id} existe et soit un entier, sinon renvoyer une erreur 400
    $id = $args['id'];
    if (!is_numeric($id)) {
        return $response->withStatus(400)->write('L\'ID doit être un entier.');
    }

    // Vérifier que l'{id} passé en paramètre corresponde bien à un article, sinon renvoyer une erreur 404
    $existingArticle = $this->postModel->getPostById($id);
    if (!$existingArticle) {
        return $response->withStatus(404)->write('Article non trouvé.');
    }

    // Supprimer l'article de la base de données
    $this->postModel->deletePost($id);

    return $response->withRedirect('/articles');
}




}
