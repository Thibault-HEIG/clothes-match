<?php
require_once __DIR__ . '/../src/renderer.php';
require_once __DIR__ . '/../src/userRepository.php';

$currentUserId = 1; // ID de l'utilisateur actuel
$name = getUserById($currentUserId)->getName();
?>

<!DOCTYPE html>
<html lang="fr">

<?php render('head', ['title' => "On met quoi aujourd'hui ?", 'description' => "Clothes Match - Le bon vêtement au bon moment"]); ?>

<body>
    <header>
        <div class="top-bar">
            <img src="" id="logo">
        </div>
        <span class="date"></span>
        <h1>Bonjour <?$name?></h1>
        <span></span>
    </header>
</body>

<?php render('footer'); ?>

</html>
