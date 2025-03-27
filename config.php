<?php
// Конфигурация MariaDB
define('MARIADB_HOST', 'localhost');
define('MARIADB_DB', 'user_management');
define('MARIADB_USER', 'admin');
define('MARIADB_PASS', 'securepassword');

// Конфигурация SQLite
define('SQLITE_DB', __DIR__ . '/db/users.db');

// Подключение к MariaDB
function getMariaDBConnection() {
    static $mariadb = null;
    if ($mariadb === null) {
        try {
            $mariadb = new PDO(
                "mysql:host=" . MARIADB_HOST . ";dbname=" . MARIADB_DB,
                MARIADB_USER,
                MARIADB_PASS
            );
            $mariadb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("MariaDB connection failed: " . $e->getMessage());
        }
    }
    return $mariadb;
}

// Подключение к SQLite
function getSQLiteConnection() {
    static $sqlite = null;
    if ($sqlite === null) {
        try {
            $sqlite = new PDO("sqlite:" . SQLITE_DB);
            $sqlite->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Создаем таблицу, если ее нет
            $sqlite->exec("CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username TEXT NOT NULL UNIQUE,
                email TEXT NOT NULL UNIQUE,
                password TEXT NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )");
        } catch (PDOException $e) {
            die("SQLite connection failed: " . $e->getMessage());
        }
    }
    return $sqlite;
}
?>
