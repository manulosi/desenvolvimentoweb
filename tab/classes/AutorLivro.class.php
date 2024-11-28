<?php
require_once("Database.class.php");
require_once("Livro.class.php");
require_once("Autor.class.php");

class AutorLivro {
    private $id;
    private $livro; // Objeto Livro
    private $autor; // Objeto Autor

    // Construtor
    public function __construct($id = null, Livro $livro = null, Autor $autor = null) {
        $this->id = $id;
        $this->livro = $livro;
        $this->autor = $autor;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getLivro(): Livro {
        return $this->livro;
    }

    public function getAutor(): Autor {
        return $this->autor;
    }

    // Setters
    public function setLivro(Livro $livro) {
        $this->livro = $livro;
    }

    public function setAutor(Autor $autor) {
        $this->autor = $autor;
    }

    // Método para incluir um novo autor-livro
    public function incluir(): bool {
        $sql = "INSERT INTO autorlivro (idLivro, idAuto) VALUES (:idLivro, :idAutor)";
        $parametros = [
            ':idLivro' => $this->livro->getId(),
            ':idAutor' => $this->autor->getId()
        ];

        Database::executar($sql, $parametros);
        return true;
    }

    // Método para excluir um autor-livro
    public function excluir(): bool {
        $sql = "DELETE FROM autorlivro WHERE id = :id";
        $parametros = [':id' => $this->id];
        return Database::executar($sql, $parametros);
    }

    // Método para alterar um autor-livro
    public function alterar(): bool {
        $sql = "UPDATE autorlivro SET idLivro = :idLivro, idAuto = :idAutor WHERE id = :id";
        $parametros = [
            ':idLivro' => $this->livro->getId(),
            ':idAuto' => $this->autor->getId(),
            ':id' => $this->id
        ];

        return Database::executar($sql, $parametros);
    }

    // Método para listar autor-livros
    public static function listar($tipo = 0, $busca = ""): array {
        $sql = "SELECT * FROM autorlivro";
        $parametros = [];

        if ($tipo > 0) {
            switch ($tipo) {
                case 1:
                    $sql .= " WHERE id = :busca";
                    break;
                case 2:
                    $sql .= " JOIN livro ON livro.id = autorlivro.idLivro WHERE livro.titulo LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
                case 3:
                    $sql .= " JOIN autor ON autor.id = autorlivro.idAutor WHERE CONCAT(autor.nome, ' ', autor.sobrenome) LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
            }
            $parametros[':busca'] = $busca;
        }

        $comando = Database::executar($sql, $parametros);
        $autorLivros = [];

        while ($registro = $comando->fetch(PDO::FETCH_ASSOC)) {
            $livro = Livro::listar(1, $registro['idLivro'])[0];
            $autor = Autor::listar(1, $registro['idAuto'])[0];
            $autorLivro = new AutorLivro($registro['id'], $livro, $autor);
            array_push($autorLivros, $autorLivro);
        }

        return $autorLivros;
    }
}
?>