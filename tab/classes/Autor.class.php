<?php
require_once("Database.class.php");

class Autor {
    private $id;
    private $nome;
    private $sobrenome;

    public function __construct($id = null, $nome = null, $sobrenome = null) {
        $this->id = $id;
        $this->nome = $nome;
        $this->sobrenome = $sobrenome;
    }

    // Método getter para o ID
    public function getId() {
        return $this->id;
    }

    // Método getter para o Nome
    public function getNome() {
        return $this->nome;
    }

    // Método getter para o Sobrenome
    public function getSobrenome() {
        return $this->sobrenome;
    }

    public static function listar($tipo = 0, $busca = ""): array {
        $sql = "SELECT * FROM autor";
        $parametros = [];

        if ($tipo > 0) {
            switch ($tipo) {
                case 1:
                    $sql .= " WHERE idAuto = :busca";
                    break;
                case 2:
                    $sql .= " WHERE nome LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
            }
            $parametros[':busca'] = $busca;
        }

        $comando = Database::executar($sql, $parametros);
        $autores = [];

        while ($registro = $comando->fetch(PDO::FETCH_ASSOC)) {
            $autor = new Autor($registro['idAuto'], $registro['nome'], $registro['sobrenome']);
            array_push($autores, $autor);
        }

        return $autores;
    }

    public function incluir(): bool {
        $sql = "INSERT INTO autor (nome, sobrenome) VALUES (:nome, :sobrenome)";
        $parametros = [
            ':nome' => $this->nome,
            ':sobrenome' => $this->sobrenome
        ];
        return Database::executar($sql, $parametros);
    }

    public function alterar(): bool {
        $sql = "UPDATE autor SET nome = :nome, sobrenome = :sobrenome WHERE idAuto = :id";
        $parametros = [
            ':id' => $this->id,
            ':nome' => $this->nome,
            ':sobrenome' => $this->sobrenome
        ];
        return Database::executar($sql, $parametros);
    }

    public function excluir(): bool {
        $sql = "DELETE FROM autor WHERE idAuto = :id";
        $parametros = [':id' => $this->id]; // Certifique-se de que $this->id contém o ID correto
        return Database::executar($sql, $parametros);
    }
}
?>