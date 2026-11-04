<?php

class outfitRepository extends Repository implements IInsert {

    #[Override]
    public function insert(object $outfit): int {
        if (!$outfit instanceof Outfit) {
            throw new InvalidArgumentException('Expected an Outfit.');
        }
        return 0; // Not implemented yet
    }

    #[Override]
    public function getById(int $id): ?Outfit {
        return null; // Not implemented yet
    }

    #[Override]
    public function getAll(int $userId = 0): array {
        return []; // Not implemented yet
    }
}
