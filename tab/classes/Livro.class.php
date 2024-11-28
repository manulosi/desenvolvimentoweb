<?php
require_once("Database.class.php");
require_once("Categoria.class.php");

class Livro {
    // Propriedades da classe
    private $id;
    private $titulo;
    private $anopublicacao;
    private $fotocapa;
    private $idcategoria; // Este deve ser um objeto da classe Categoria
    private $preco;

    // Construtor
    public function __construct($id = null, $titulo = null, $anopublicacao = null, $fotocapa = null, Categoria $idcategoria = null, $preco = null) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->anopublicacao = $anopublicacao;
        $this->fotocapa = $fotocapa;
        $this->idcategoria = $idcategoria;
        $this->preco = $preco;
    }


    // Getters
    public function getId() {
        return $this->id;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getAnoPublicacao() {
        return $this->anopublicacao;
    }

    public function getFotoCapa() {
        return $this->fotocapa;
    }

    public function getIdCategoria() {
        return $this->idcategoria; // Retorna o objeto Categoria
    }

    public function getPreco() {
        return $this->preco;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function setAnoPublicacao($anopublicacao) {
        $this->anopublicacao = $anopublicacao;
    }

    public function setFotoCapa($fotocapa) {
        $this->fotocapa = $fotocapa;
    }

    public function setIdCategoria(Categoria $idcategoria) {
        $this->idcategoria = $idcategoria;
    }

    public function setPreco($preco) {
        $this->preco = $preco;
    }

    // Método para incluir um novo livro
 // Método para listar livros
public static function listar($tipo = 0, $busca = ""): array {
    $sql = "SELECT * FROM livro";
    $parametros = [];

    if ($tipo > 0) {
        switch ($tipo) {
            case 1:
                $sql .= " WHERE idLivro = :busca";
                break;
            case 2:
                $sql .= " WHERE titulo LIKE :busca";
                $busca = "%{$busca}%";
                break;
            case 3:
                $sql .= " WHERE anopublicacao = :busca";
                break;
        }
        $parametros[':busca'] = $busca;
    }

    $comando = Database::executar($sql, $parametros);
    $livros = [];

    while ($registro = $comando->fetch(PDO::FETCH_ASSOC)) {
        $idcategoria = Categoria::listar(0, $registro['idCategoria'])[0];
        $livro = new Livro(
            $registro['idLivro'],
            $registro['titulo'],
            $registro['anoPublicacao'],
            $registro['fotoCapa'],
            $idcategoria,
            $registro['preco']
        );
        array_push($livros, $livro);
    }

    return $livros;
}

    // Método para excluir um livro
    public function excluir(): bool {
        $sql = "DELETE FROM livro WHERE idLivro = :id";
        $parametros = [':id' => $this->id];
        return Database::executar($sql, $parametros);
    }

    public function incluir(): bool {
        $sql = "INSERT INTO livro (titulo, anopublicacao, fotoCapa, idcategoria, preco) VALUES (:titulo, :anopublicacao, :fotocapa, :idcategoria, :preco)";
        $parametros = [
            ':titulo' => $this->titulo,
            ':anopublicacao' => $this->anopublicacao,
            ':fotocapa' => $this->fotocapa,
            ':idcategoria' => $this->idcategoria->getId(), // Supondo que idcategoria é um objeto da classe Categoria
            ':preco' => $this->preco
        ];
    
        // Executa a consulta
        $stmt = Database::executar($sql, $parametros);
    
        // Verifica se a execução foi bem-sucedida
        return $stmt !== false; // Retorna true se a execução foi bem-sucedida, false caso contrário
    }
}
?>