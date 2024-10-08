<?php
require_once("../classes/Database.class.php");
require_once("../classes/Forma.class.php");
require_once("../classes/Unidade.class.php");

abstract class Triangulo extends Forma
{
    private $lado1;
    private $lado2;
    private $lado3;
    private $tipo;

    public function __construct($id = 0, $lado1 = 0, $lado2 = 0, $lado3 = 0, $tipo = "", $cor = "black", Unidade $unidade = null, $fundo = null)
    {
        parent::__construct($id, $cor, $unidade, $fundo);
        $this->setLado1($lado1);
        $this->setLado2($lado2);
        $this->setLado3($lado3);
        $this->setTipo($tipo);
    } 
    public function setLado1($lado1)
    {
        if ($lado1 < 0)
            throw new Exception("Erro: lado1 inválido!");
        else
            $this->lado1 = $lado1;
    }

    public function setLado2($lado2)
    {
        if ($lado2 < 0)
            throw new Exception("Erro, lado2 indefinido");
        else
            $this->lado2 = $lado2;
    }

    public function setLado3($lado3)
    {
        if ($lado3 < 0)
            throw new Exception("Erro, lado3 indefinida");
        else
            $this->lado3 = $lado3;
    }
    public function setTipo($tipo)
    {
        if ($tipo == "")
            throw new Exception("Erro, tipo indefinida");
        else
            $this->tipo = $tipo;
    }

    public function getLado1()
    {
        return $this->lado1;
    }

    public function getLado2()
    {
        return $this->lado2;
    }

    public function getLado3()
    {
        return $this->lado3;
    }

    public function getTipo()
    {
        return $this->tipo;
    }
    
    abstract public function incluir();
    abstract public function excluir();
    abstract public function alterar();
    abstract public function desenhar();
    abstract public function calcularArea();
    abstract public function calcularPerimetro();

    public static function listar($tipo = 0, $busca = ""):array{
        $sql = "SELECT * FROM triangulo";
        if ($tipo > 0) {
            switch ($tipo) {
                case 1:
                    $sql .= " WHERE id_tri = :busca";
                    break;
                case 2:
                    $sql .= " WHERE lado1 LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
                case 3:
                    $sql .= " WHERE lado2 LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
                case 4:
                    $sql .= " WHERE lado3 LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
                case 5:
                    $sql .= " WHERE tipo LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
                case 6:
                    $sql .= " WHERE cor LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
                case 7:
                    $sql .= " INNER JOIN unidade ON (unidade.iduni = triangulo.id_unidade) WHERE unidade.unidade LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
            }
        }
        // $comando = $conexao->prepare($sql);
        $parametros = [];
        if ($tipo > 0)
            $parametros = array(':busca' => $busca);

        $comando = Database::executar($sql, $parametros);
        $formas = array();

        while ($forma = $comando->fetch(PDO::FETCH_ASSOC)) {
            $unidade = Unidade :: listar(1,$forma['id_unidade'])[0]; 

            if( $forma['lado1'] === $forma['lado2'] && $forma['lado2'] === $forma['lado3']){
                $triangulo = new Equilatero($forma['id_tri'], $forma['lado1'], $forma['lado2'], $forma['lado3'], $forma['tipo'], $forma['cor'], $unidade, $forma['fundo']);
            }
            elseif( $forma['lado1'] === $forma['lado2'] || $forma['lado2'] === $forma['lado3'] || $forma['lado3'] ===  $forma['lado1']){
                $triangulo = new Isoceles($forma['id_tri'], $forma['lado1'], $forma['lado2'], $forma['lado3'], $forma['tipo'], $forma['cor'], $unidade, $forma['fundo']);
            }
            else{
                $triangulo = new Escaleno($forma['id_tri'], $forma['lado1'], $forma['lado2'], $forma['lado3'], $forma['tipo'], $forma['cor'], $unidade, $forma['fundo']);
            }
            
            array_push($formas, $triangulo);
        }
        return $formas;
    }

    
}

