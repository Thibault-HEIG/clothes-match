<?php
require_once __DIR__ . '/Repository.php';
require_once __DIR__ . '/../models/Outfit.php';

class OutfitRepository extends Repository {

    public function insert(Outfit $outfit): int {
        return 0; // Not implemented yet
    }

    #[Override]
    public function getById(int $id): ?Outfit {
        return null; // Not implemented yet
    }
}
