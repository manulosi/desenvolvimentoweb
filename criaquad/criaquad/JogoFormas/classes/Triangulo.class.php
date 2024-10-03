<?php
require_once("../classes/Forma.class.php");

abstract class Triangulo extends Forma
{
    private $lado1;
    private $lado2;
    private $lado3;

    public function __construct($id = 0, $cor = "null", $lado1 = 1, $lado2 = 1, $lado3 = 1, $imagem = "null", Unidade $unidade = null)
    {
        parent::__construct($id, $cor, $imagem, $unidade);

        // Usando os setters para garantir validação
        $this->setLado1($lado1);
        $this->setLado2($lado2);
        $this->setLado3($lado3);
    }

    // Setters com validação
    public function setLado1($lado1)
    {
        if ($lado1 <= 0) {
            throw new Exception("Erro: Lado 1 inválido!");
        }
        $this->lado1 = $lado1;
    }

    public function setLado2($lado2)
    {
        if ($lado2 <= 0) {
            throw new Exception("Erro: Lado 2 inválido!");
        }
        $this->lado2 = $lado2;
    }

    public function setLado3($lado3)
    {
        if ($lado3 <= 0) {
            throw new Exception("Erro: Lado 3 inválido!");
        }
        $this->lado3 = $lado3;
    }

    // Getters
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

    // Métodos abstratos que precisam ser implementados nas subclasses
    abstract public function incluir();
    abstract public function alterar();
    abstract public function excluir();
    abstract public static function listar($tipo = 0, $busca = ""): array;
    abstract public function desenhar();
    abstract public function calcularArea();
    abstract public function calcularPerimetro();
}
