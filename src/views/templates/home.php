<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Blog</title>
</head>
<body>
    <h1>Mon Blog</h1>

    <?php foreach ($notifications as $notification): ?>
        <div class="notification"><?= $notification['message'] ?></div>
    <?php endforeach; ?>

    <!-- Contenu du blog ici -->

</body>
</html>
