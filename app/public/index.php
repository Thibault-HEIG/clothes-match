<?php
const DB_HOST = 'mariadb';
const DB_PORT = 3306;

$DB_NAME = getenv('DB_NAME');
$DB_USER = getenv('DB_USER');
$DB_PASSWORD = getenv('DB_PASSWORD');

$dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . $DB_NAME . ";charset=utf8mb4";

$pdo = new PDO($dsn, $DB_USER, $DB_PASSWORD);

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
    <title>ProgServ2 Course PHP Template</title>
</head>

<body>
    <h1>ProgServ2 Course PHP Template</h1>

    <p>Bienvenue dans votre projet PHP pour le cours ProgServ2 à la HEIG-VD !</p>

    <h2>Résultats de la base de données :</h2>

    <ul>
        <?php foreach ($results as $row) { ?>
            <li>ID: <?= htmlspecialchars($row['id']) ?>
                <ul>
                    <li>Name: <?= htmlspecialchars($row['name']) ?></li>
                    <li>Email: <?= htmlspecialchars($row['email']) ?></li>
                    <li>Password: <?= htmlspecialchars($row['password']) ?></li>
                </ul>
            </li>
        <?php } ?>
    </ul>
</body>

</html>
