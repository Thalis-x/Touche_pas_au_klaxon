<?php
/**
 * Layout principal.
 * Variables disponibles : $content, $appName, $copyright, $user, $flash
 * 
 * Le layout principal qui enveloppe toutes les pages. 
 * Il inclut Bootstrap, le header, le footer, et affiche le contenu ($content) au milieu.
 */

use App\Core\View;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= View::e($appName) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="/assets/css/main.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

    <?php View::renderPartial('partials/header', [
        'appName' => $appName,
        'user'    => $user,
    ], false); ?>

    <?php View::renderPartial('partials/flash', [
        'flash' => $flash,
    ], false); ?>

    <main class="container my-4 flex-grow-1">
        <?= $content ?>
    </main>

    <?php View::renderPartial('partials/footer', [
        'copyright' => $copyright,
    ], false); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>