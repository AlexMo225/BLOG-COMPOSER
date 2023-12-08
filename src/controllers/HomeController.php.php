<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\PostModel;
use Carbon\Carbon;
use Respect\Validation\Validator as v;
use Parsedown;

class HomeController
{
    private $view;
    private $postModel;

    public function __construct($view, PostModel $postModel)
    {
        $this->view = $view;
        $this->postModel = $postModel;
    }

    public function home(Request $request, Response $response, $args)
    {
        // ...
    
        foreach ($articles as &$article) {
            $article['created_at_relative'] = Carbon::parse($article['created_at'])->diffForHumans();
            $article['created_at_french'] = Carbon::parse($article['created_at'])->locale('fr_FR')->isoFormat('LLLL');
        }
    
        // ...
    
        return $this->view->render($response, 'articles/index.php', [
            'title' => 'Liste des articles',
            'articles' => $articles,
        ]);
    }

    public function createArticle(Request $request, Response $response, $args)
    {
        // Affichage du formulaire de création d'un article
        return $this->view->render($response, 'articles/create.php', [
            'title' => 'Création d\'un article',
        ]);
    }

    public function storeArticle(Request $request, Response $response, $args)
    {
        // Création d'un article
        $data = $request->getParsedBody();
        $title = $data['title'];
        $body = $data['body'];

        $stmt = $this->db->prepare('INSERT INTO posts (title, body) VALUES (?, ?)');
        $stmt->execute([$title, $body]);

        return $response->withRedirect('/articles');
    }

    public function editArticle(Request $request, Response $response, $args)
    {
        // Affichage du formulaire de modification d'un article
        $id = $args['id'];

        $stmt = $this->db->prepare('SELECT * FROM posts WHERE id = ?');
        $stmt->execute([$id]);
        $article = $stmt->fetch();

        return $this->view->render($response, 'articles/edit.php', [
            'title' => 'Modification de l\'article',
            'article' => $article,
        ]);
    }

    public function updateArticle(Request $request, Response $response, $args)
    {
        // Modification d'un article
        $id = $args['id'];
        $data = $request->getParsedBody();
        $title = $data['title'];
        $body = $data['body'];

        $stmt = $this->db->prepare('UPDATE posts SET title=?, body=? WHERE id=?');
        $stmt->execute([$title, $body, $id]);

        return $response->withRedirect('/articles');
    }

    public function deleteArticle(Request $request, Response $response, $args)
    {
        // Suppression d'un article
        $id = $args['id'];

        $stmt = $this->db->prepare('DELETE FROM posts WHERE id=?');
        $stmt->execute([$id]);

        return $response->withRedirect('/articles');
    }
    public function postStore(Request $request, Response $response, $args)
{
    $data = $request->getParsedBody();

    $validator = v::key('title', v::stringType()->notEmpty())
                ->key('body', v::stringType()->notEmpty());

    $validation = $validator->validate($data);

    if ($validation->failed()) {
    }

    return $response->withRedirect('/articles');
}

public function postShow(Request $request, Response $response, $args)
{
    // ...

    // Convertir le texte Markdown en HTML
    $parsedown = new Parsedown();
    $article['body_html'] = $parsedown->text($article['body']);

    // ...

    return $this->view->render($response, 'articles/show.php', [
        'article' => $article,
    ]);
}

}
