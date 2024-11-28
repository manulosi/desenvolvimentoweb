<?php
class Categoria {
    private $id;
    private $nome;
    private $descricao;
    private static $db;
    

    // Construtor da classe
    public function __construct($id, $nome, $descricao) {
        $this->id = $id;
        $this->nome = $nome;
        $this->descricao = $descricao;
    }

    // Métodos getters
    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    // Método estático para conectar ao banco de dados
    public static function conectar() {
        if (self::$db === null) {
            try {
                // Substitua as informações conforme seu banco de dados
                $host = "localhost";
                $db = "trabalho";
                $usuario = "root";
                $senha = "";

                self::$db = new PDO("mysql:host=$host;dbname=$db", $usuario, $senha);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro de conexão: " . $e->getMessage());
            }
        }
    }

    // Método para listar categorias
    public static function listar($limite = 0, $id = 0) {
        self::conectar();

        $query = "SELECT * FROM categoria";
        if ($id > 0) {
            $query .= " WHERE id = :id";
        }
        if ($limite > 0) {
            $query .= " LIMIT :limite";
        }

        $stmt = self::$db->prepare($query);

        if ($id > 0) {
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        }
        if ($limite > 0) {
            $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        }

        $stmt->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $categorias = [];
        foreach ($resultado as $row) {
            $categorias[] = new Categoria($row['id'], $row['nome'], $row['descricao']);
        }

        return $categorias;
    }

    // Método para incluir uma nova categoria
    public function incluir() {
        self::conectar();

        $query = "INSERT INTO categoria (nome, descricao) VALUES (:nome, :descricao)";
        $stmt = self::$db->prepare($query);

        $stmt->bindParam(':nome', $this->nome, PDO::PARAM_STR);
        $stmt->bindParam(':descricao', $this->descricao, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $this->id = self::$db->lastInsertId(); // Atribui o id gerado automaticamente
            return true;
        } else {
            return false;
        }
    }

    // Método para alterar uma categoria existente
    public function alterar() {
        self::conectar();

        $query = "UPDATE categorias SET nome = :nome, descricao = :descricao WHERE id = :id";
        $stmt = self::$db->prepare($query);

        $stmt->bindParam(':nome', $this->nome, PDO::PARAM_STR);
        $stmt->bindParam(':descricao', $this->descricao, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Método para excluir uma categoria
    public function excluir() {
        self::conectar();
    
        $query = "DELETE FROM categoria WHERE id = :id";
        $stmt = self::$db->prepare($query);
    
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
    
        return $stmt->execute();
    }
}
?>
