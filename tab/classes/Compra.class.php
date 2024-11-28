<?php
require_once('../classes/autoload.php');
class Compra extends Persistencia
{
    private $dtCompra;
    private $valorTotalCompra;

    public function  __construct($id = 0, $dtCompra = "", $valorTotalCompra = "null")

    {
        parent::__construct($id);
        $this->setDt($dtCompra);
        $this->setValorTot($valorTotalCompra);
    }

    // ====================== Seter's ======================== //


    public function setDt($dtCompra)
    {
        if ($dtCompra === "")
            throw new Exception("Erro: nome inválido!");
        else
            $this->dtCompra = $dtCompra;
    }

    public function setValorTot($valorTotalCompra)
    {
        if ($valorTotalCompra === "")
            throw new Exception("Erro: email inválido!");
        else
            $this->valorTotalCompra = $valorTotalCompra;
    }



    // ====================== Geter's ======================== //


    public function getDT()
    {
        return $this->dtCompra;
    }
    public function getValorTot()
    {
        return $this->valorTotalCompra;
    }

    // ====================== DBFunctions ======================== //


    public function incluir()
    {
        $sql = 'INSERT INTO compras (dtCompra, valorTotalCompra)   
        VALUES (:dt, :tot)';

        $parametros = array(
            ':dt' => $this->getDT(),
            ':tot' => $this->getValorTot(),
        );

        return Database::executar($sql, $parametros);
    }

    public function alterar()
    {
        $sql = 'UPDATE compras 
        SET dtCompra = :dt, valorTotalCompra = :tot
      WHERE id = :id';
        $parametros = array(
            ':id' => $this->getId(),
            ':dt' => $this->getDT(),
            ':tot' => $this->getValorTot(),
        );
        Database::executar($sql, $parametros);
        return true;
    }

    public function excluir()
    {
        $sql = 'DELETE 
                  FROM compras
                 WHERE id = :id';
        $parametros = array(':id' => parent::getId());
        return Database::executar($sql, $parametros);
    }

    public static function listar($tipo = 0, $busca = ""): array
    {
        $sql = "SELECT * FROM compras";
        if ($tipo > 0)
            switch ($tipo) {
                case 1:
                    $sql .= " WHERE id = :busca";
                    break;
                case 2:
                    $sql .= " WHERE nome like :busca";
                    $busca = "%{$busca}%";
                    break;
                case 3:
                    $sql .= " WHERE email like :busca";
                    $busca = "%{$busca}%";
                    break;
            }
        $parametros = array();
        if ($tipo > 0)
            $parametros = array(':busca' => $busca);
        $comando = Database::executar($sql, $parametros);
        $formas = array();
        while ($registro = $comando->fetch(PDO::FETCH_ASSOC)) {
            $quadrado = new Compra($registro['id'], $registro['dtCompra'], $registro['valorTotalCompra']);
            array_push($formas, $quadrado);
        }
        return $formas;
    }

    public function ItensParaCompra(){
        
    }
}
