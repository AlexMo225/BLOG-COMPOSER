
<div class="container">
    <h1>Liste des articles</h1>

    <?php foreach ($articles as $article): ?>
        <div class="card my-2">
            <div class="card-body">
                <h2 class="card-title"><?= $article['title'] ?></h2>
                <p class="card-text"><?= $article['body'] ?></p>
                <a href="/articles/<?= $article['id'] ?>" class="btn btn-primary">Voir l'article</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
