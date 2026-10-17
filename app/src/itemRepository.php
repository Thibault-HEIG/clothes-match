<?php

/**
 * Item repository : functions to manage items in the database.
 */

function getItemById(int $id): ?Item {
    $pdo = Database::getPdo();
    $stmt = $pdo->prepare("SELECT * FROM items WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $row = $stmt->fetch();

    if (!$row) {
        return null;
    }
    return new Item(
        (int)$row['id'],
        $row['category'],
        (float)$row['hue'],
        (float)$row['saturation'],
        (float)$row['brightness'],
        (int)$row['season'],
        (int)$row['rate']
    );
}
