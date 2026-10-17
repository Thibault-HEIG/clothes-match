<?php
class Database {

    const DB_HOST = 'mariadb';
    const DB_PORT = 3306;

    $DB_NAME = getenv('DB_NAME');
    $DB_USER = getenv('DB_USER');
    $DB_PASSWORD = getenv('DB_PASSWORD');

    $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . $DB_NAME . ";charset=utf8mb4";

    $pdo = new PDO($dsn, $DB_USER, $DB_PASSWORD);

    public static function getPdo(): PDO {
        return self::$pdo;
    }
}
