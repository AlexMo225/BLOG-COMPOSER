
<?php $this->layout('layout', ['title' => 'Création d\'un article']) ?>


<div class="container">
    <h1>Création d'un article</h1>

    <form action="/articles" method="post">
        <div class="mb-3">
            <label for="title" class="form-label">Titre:</label>
            <input type="text" id="title" name="title" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label for="body" class="form-label">Contenu:</label>
            <textarea id="body" name="body" class="form-control" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Créer l'article</button>
    </form>

    <a href="/articles" class="btn btn-secondary">Retour à la liste des articles</a>
</div>
