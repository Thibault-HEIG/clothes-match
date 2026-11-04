<?php
require_once '../src/outfitRepository.php';

// Default values for the form fields
$seedImagePath = null;

// Gestion de la soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {}
?>

<!DOCTYPE html>
<html lang="fr">

<?php render('head', ['title' => "Créer un outfit sur mesure", 'description' => "Clothes Match - La bonne tenue au bon moment"]); ?>

<body>
    <h1>Créer un outfit</h1>
    <section>
        <form action="./generateOutfit.php" method="POST">
    </section>
</body>

<?php render('footer'); ?>

</html>
