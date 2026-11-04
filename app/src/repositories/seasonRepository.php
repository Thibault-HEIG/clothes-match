<?php

class seasonRepository extends Repository {

    #[Override]
    public function getAll(): array {
        $pdo = Database::getPdo();
        $stmt = $pdo->query("SELECT * FROM seasons ORDER BY id");
        $rows = $stmt->fetchAll();

        $seasons = [];
        foreach ($rows as $row) {
            $seasons[] = new Season(
                (int)$row['id'],
                $row['name'],
                (int)$row['avg_temperature'],
                $row['icon_url']
            );
        }
        return $seasons;
    }

    #[Override]
    public function getById(int $seasonId): ?Season {
        $pdo = Database::getPdo();
        $stmt = $pdo->query("SELECT * FROM seasons WHERE id = :id");
        $stmt->execute(['id' => $seasonId]);
        $row = $stmt->fetch();
        return new Season((int)$row['id'], $row['name'], (int)$row['avg_temperature'], $row['icon_url']);
    }
}
