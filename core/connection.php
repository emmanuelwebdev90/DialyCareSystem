<?php
require_once './core/config.php';
class Connection {
    private mixed $driver = DB_DRIVER;
    private mixed $host = DB_HOST;
    private mixed $user = DB_USER;
    private mixed $password = DB_PASSWORD;
    private mixed $database = DB_NAME;
    private mixed $charset = DB_CHARSET;

    protected function connect() {
        try {
            $dsn = "{$this->driver}:host={$this->host};dbname={$this->database};charset={$this->charset}";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            return new PDO($dsn, $this->user, $this->password, $options);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}