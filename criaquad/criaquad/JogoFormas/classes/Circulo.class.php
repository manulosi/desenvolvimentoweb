<?php
require_once("../classes/Database.class.php");
require_once("../classes/Forma.class.php");
require_once("../classes/Unidade.class.php");

class Circulo extends Forma
{
    private $raio;

    public function __construct($id = 0, $raio = 1, $cor = "black", Unidade $unidade = null, $fundo = "null")
    {
        parent::__construct($id, $cor, $unidade, $fundo);
        $this->setRaio($raio);
    }

    public function setRaio($raio)
    {
        if ($raio < 1)
            throw new Exception("Erro, raio indefinido");
        else
            $this->raio = $raio;
    }

    public function getRaio()
    {
        return $this->raio;
    }

    public function incluir()
    {
        $sql = 'INSERT INTO circulo (raio, cor, id_unidade, fundo)   
                VALUES (:raio, :cor, :id_unidade, :fundo)';

        $parametros = array(':raio' => $this->raio, 
                            ':cor' => parent::getCor(), 
                            ':id_unidade' => parent::getUnidade()->getIdUni(),
                            ':fundo' => parent::getFundo());
        return Database::executar($sql, $parametros);
    }

    public function excluir()
    {
        $sql = 'DELETE FROM circulo WHERE id_circulo = :id';
        $parametros = array(':id' => $this->getId());
        return Database::executar($sql, $parametros);
    }

    public function alterar()
    {
        $sql = 'UPDATE circulo SET raio = :raio, cor = :cor, id_unidade = :id_unidade, fundo = :fundo WHERE id_circulo = :id';
        $parametros = array(':raio' => $this->raio, 
                            ':cor' => parent::getCor(), 
                            ':id_unidade' => parent::getUnidade()->getIdUni(), 
                            ':id' => parent::getId(),
                            ':fundo' => parent::getFundo());
        return Database::executar($sql, $parametros);
    }

    public static function listar($tipo = 0, $busca = ""): array
    {
        $sql = "SELECT * FROM circulo";
        if ($tipo > 0) {
            switch ($tipo) {
                case 1:
                    $sql .= " WHERE id_circulo = :busca";
                    break;
                case 2:
                    $sql .= " WHERE raio LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
                case 3:
                    $sql .= " WHERE cor LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
                case 4:
                    $sql .= " INNER JOIN unidade ON (unidade.iduni = circulo.id_unidade) WHERE unidade.unidade LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
                case 5:
                    $sql .= " WHERE fundo LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
            }
        }

        $parametros = [];
        if ($tipo > 0)
            $parametros = array(':busca' => $busca);

        $comando = Database::executar($sql, $parametros);
        $formas = array();

        while ($forma = $comando->fetch(PDO::FETCH_ASSOC)) {
            $unidade = Unidade::listar(1, $forma['id_unidade'])[0];
            $circulo = new Circulo($forma['id_circulo'], $forma['raio'], $forma['cor'], $unidade, $forma['fundo']);
            array_push($formas, $circulo);
        }
        return $formas;
    }

    public function desenhar()
    {
        $diametro = $this->getRaio() * 2;
        return "<div class='quadrado' style='display:block; 
                width:{$diametro}{$this->getUnidade()->getUnidade()};
                height:{$diametro}{$this->getUnidade()->getUnidade()};
                background-color:{$this->getCor()};
                background-image:url(\"{$this->getFundo()}\");background-size:contain; border-radius:50%'></div>";
    }

    // Corrigido para usar o método correto getUnidade
    public function calcularPerimetro()
    {
        return 2 * 3.14 * $this->raio . " " . $this->getUnidade()->getUnidade();
    }

    public function calcularArea()
    {
        return 3.14 * ($this->raio * $this->raio) . " " . $this->getUnidade()->getUnidade() . "²";
    }
}
