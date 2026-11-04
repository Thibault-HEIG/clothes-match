<?php
require_once __DIR__ . '/IGet.php';
require_once __DIR__ . '/../Database.php';

abstract class Repository implements IGet {
    protected PDO $pdo;

    public function __construct() {
        $this->pdo = Database::getPdo();
    }
}
