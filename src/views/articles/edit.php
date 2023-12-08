
<?php $this->layout('layout', ['title' => 'Modification de l\'article']) ?>

<div class="container">
    <h1>Modification de l'article</h1>
    <form action="/articles/<?= $article['id'] ?>" method="post">
        <div class="mb-3">
            <label for="title" class="form-label">Titre:</label>
            <input type="text" id="title" name="title" class="form-control" value="<?= $article['title'] ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="body" class="form-label">Contenu:</label>
            <textarea id="body" name="body" class="form-control" required><?= $article['body'] ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Modifier l'article</button>
    </form>

    <a href="/articles" class="btn btn-secondary">Retour à la liste des articles</a>
</div>
