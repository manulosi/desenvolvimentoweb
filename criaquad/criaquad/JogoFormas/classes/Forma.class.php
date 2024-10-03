<?php
require_once("../classes/Database.class.php");

abstract class Forma
{
    private $id;
    private $cor;
    private $unidade;
    private $fundo;

    public function  __construct($id = 0, $cor = "black", Unidade $unidade = null, $fundo = "null")
    {
        $this->setId($id);
        $this->setCor($cor);
        $this->setUnidade($unidade);
        $this->setFundo($fundo);
    } 
    public function setId($id)
    {
        if ($id < 0)
            throw new Exception("Erro: id inválido!");
        else
            $this->id = $id;
    }

    public function setCor($cor)
    {
        if ($cor == "")
            throw new Exception("Erro, cor indefinido");
        else
            $this->cor = $cor;
    }

    public function setUnidade($unidade)
    {
        if (!$unidade)
            throw new Exception("Erro, unidade indefinida");
        else
            $this->unidade = $unidade;
    }

    public function setFundo($fundo)
    {
        if ($fundo == "")
            throw new Exception("Erro, fundo indefinido");
        else
            $this->fundo = $fundo;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCor()
    {
        return $this->cor;
    }

    public function getUnidade()
    {
        return $this->unidade;
    }

    public function getFundo()
    {
        return $this->fundo;
    }
    
    abstract public function incluir();
    abstract public function excluir();
    abstract public function alterar();
    abstract public static function listar($tipo = 0, $busca = "" ):array;
    abstract public function desenhar();
    abstract public function calcularArea();
    abstract public function calcularPerimetro();
}
