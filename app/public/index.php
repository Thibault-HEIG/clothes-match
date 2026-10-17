<?php
$sql = "SELECT * FROM users";

$stmt = $pdo->prepare($sql);

$stmt->execute();

$results = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualisation de la garde-robe</title>
</head>

<body>
    <header>
        <div class="top-bar">
            <img src="" id="logo">
        </div>
        <span class="date"></span>
        <h1></h1>
        <span></span>
    </header>
</body>

</html>
