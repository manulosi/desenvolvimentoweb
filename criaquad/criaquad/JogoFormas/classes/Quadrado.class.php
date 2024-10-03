<?php
require_once("../classes/Database.class.php");
require_once("../classes/Forma.class.php");
require_once("../classes/Unidade.class.php");

class Quadrado extends Forma
{
    private $altura;

    public function  __construct($id = 0, $altura = 1, $cor = "black", Unidade $unidade = null, $fundo = "null")
    {
        parent::__construct($id, $cor, $unidade, $fundo);
        $this->setAltura($altura);
    } 

    public function setAltura($altura)
    {
        if ($altura < 1)
            throw new Exception("Erro, número indefinido");
        else
            $this->altura = $altura;
    }

    public function getAltura()
    {
        return $this->altura;
    }

    public function incluir()
    {
        $sql = 'INSERT INTO quadrado (lado, cor, id_unidade, fundo)   
                VALUES (:lado, :cor, :id_unidade, :fundo)';

        $parametros = array(':lado' => $this->altura, 
                            ':cor' => parent::getCor(), 
                            ':id_unidade' => parent::getUnidade()->getIdUni(),
                            ':fundo' => parent::getFundo());
        return Database::executar($sql, $parametros);
    }

    public function excluir()
    {
        $sql = 'DELETE 
                FROM quadrado 
                WHERE idquad = :id';
        $parametros = array(':id'=> $this->getId());
        return Database::executar($sql, $parametros);
    }

    public function alterar()
    {
        $sql = 'UPDATE quadrado
                SET lado = :lado, cor = :cor, id_unidade = :id_unidade, idquad = :id, fundo = :fundo
                WHERE idquad = :id';
        $parametros = array(':lado' => $this->altura, 
                            ':cor' => parent::getCor(), 
                            ':id_unidade' => parent::getUnidade()->getIdUni(), 
                            ':id' => parent::getId(),
                            ':fundo' => parent::getFundo());
        return Database::executar($sql, $parametros);
        //return var_dump($parametros);
    }

    public static function listar($tipo = 0, $busca = ""):array
    {
        $sql = "SELECT * FROM quadrado";
        if ($tipo > 0) {
            switch ($tipo) {
                case 1:
                    $sql .= " WHERE idquad = :busca";
                    break;
                case 2:
                    $sql .= " WHERE lado LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
                case 3:
                    $sql .= " WHERE cor LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
                case 4:
                    $sql .= " INNER JOIN unidade ON (unidade.iduni = quadrado.id_unidade) WHERE unidade.unidade LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
                case 5:
                    $sql .= " WHERE fundo LIKE :busca";
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
            $quadrado = new Quadrado($forma['idquad'], $forma['lado'], $forma['cor'], $unidade, $forma['fundo']);
            array_push($formas, $quadrado);
        }
        return $formas;
    }

    public function desenhar()
    {
        return "<div class='quadrado' style='display:block; 
                width:{$this->getAltura()}{$this->getUnidade()->getUnidade()};
                height:{$this->getAltura()}{$this->getUnidade()->getUnidade()};
                background-color:{$this->getCor()};
                background-image:url(\"{$this->getFundo()}\");background-size:contain'></div>";
    }

    public function calcularArea()
    {
        $area = $this->getAltura() * $this->getAltura();
        return $area;
    }

    public function calcularPerimetro()
    {
        $perimetro = $this->getAltura() * 4;
        return $perimetro;
    }

}
