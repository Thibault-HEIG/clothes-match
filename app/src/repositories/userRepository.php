<?php
require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/models/User.php';

/**
 * User repository : functions to manage users in the database.
 */
class userRepository extends Repository implements IInsert, IUpdate, IDelete {

    #[Override]
    public function getById(int $userId): ?User {
        $pdo = Database::getPdo();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $userId]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }
        return new User(
            $row['name'],
            (float)$row['last_color_harmony_importance'],
            (float)$row['last_season_harmony_importance'],
            (int)$row['id']
        );
    }

    #[Override]
    public function getAll(): array {
        return []; // Not implemented yet
    }

    #[Override]
    public function insert(Object $user): int {
        if (!$user instanceof User) {
            throw new InvalidArgumentException('Expected a User.');
        }
        return 0; // Not implemented yet
    }

    #[Override]
    public function update(Object $user): bool {
        if (!$user instanceof User) {
            throw new InvalidArgumentException('Expected a User.');
        }
        return false; // Not implemented yet
    }

    #[Override]
    public function deleteById(int $userId): bool {
        return false; // Not implemented yet
    }
}
