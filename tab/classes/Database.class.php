<?php
class Database {
    private static $db;

    public static function conectar() {
        if (self::$db === null) {
            try {
                $host = "localhost";
                $dbname = "trabalho";
                $username = "root";
                $password = "";

                self::$db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro de conexão: " . $e->getMessage());
            }
        }
    }

    public static function getConnection() {
        self::conectar(); // Garante que a conexão esteja ativa
        return self::$db; // Retorna a conexão PDO
    }

    public static function executar($sql, $parametros = []) {
        self::conectar();
        $stmt = self::$db->prepare($sql);
        $stmt->execute($parametros);
        return $stmt;
    }
}
?>