<?php $this->layout('layout', ['title' => $article['title']]) ?>

<div class="container">
    <h1><?= $article['title'] ?></h1>
    <p><?= $article['body'] ?></p>
    <a href="/articles" class="btn btn-secondary">Retour à la liste des articles</a>
</div>
