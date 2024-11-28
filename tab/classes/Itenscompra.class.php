<?php
require_once('../classes/autoload.php');
class Itenscompra extends Persistencia
{
    private $idLivro;
    private $idCompra;
    private $quantia;
    private $valorTotal;

    public function  __construct($id = 0, Livro $idLivro = null, Compra $idCompra = null, $quantia = 0, $valorTotal = 0)

    {
        parent::__construct($id);
        $this->setIdLivro($idLivro);
        $this->setIdCompra($idCompra);
        $this->setQuantia($quantia);
        $this->setValorTotal($valorTotal);
    }

    // ====================== Seter's ======================== //


    public function setIdLivro(Livro $idLivro)
    {
        if ($idLivro === 0)
            throw new Exception("Erro: id Livro inválido!");
        else
            $this->idLivro = $idLivro;
    }

    public function setIdCompra(Compra $idCompra)
    {
        if ($idCompra === 0)
            throw new Exception("Erro: id Compra inválido!");
        else
            $this->idCompra = $idCompra;
    }

    public function setQuantia($quantia)
    {
        if ($quantia === 0)
            throw new Exception("Erro: Quantidade inválida!");
        else
            $this->quantia = $quantia;
    }
    public function setValorTotal($valorTotal)
    {
        if ($valorTotal === 0)
            throw new Exception("Erro: Valor total inválido!");
        else
            $this->valorTotal = $valorTotal;
    }


    // ====================== Geter's ======================== //


    public function getIdLivro()
    {
        return $this->idLivro;
    }
    public function getIdCompra()
    {
        return $this->idCompra;
    }
    public function getQuantia()
    {
        return $this->quantia;
    }
    public function getValorTotal()
    {
        return $this->valorTotal;
    }


    // ====================== DBFunctions ======================== //


    public function incluir()
    {
        $sql = 'INSERT INTO itenscompras (idLivro, idCompra, valorUnitario, quantidade, valorTotalItem)   
        VALUES (:idL, :idC, :valorU, :quantidade, :valorT)';

        $parametros = array(
            ':idL' => $this->getIdLivro()->getId(),
            ':idC' => $this->getIdCompra()->getId(),
            ':valorU' => $this->getIdLivro()->getPreco(),
            ':quantidade' => $this->getQuantia(),
            ':valorT' => $this->getValorTotal()
        );

        return Database::executar($sql, $parametros);
    }

    public function alterar()
    {
        $sql = 'UPDATE itenscompras 
        SET idLivro = :idL, idCompra = :idC, valorUnitario = :valorU, quantidade = :quantidade, valorTotalItem = :valorT
      WHERE id = :id';
        $parametros = array(
            ':id' => parent::getId(),
            ':idL' => $this->getIdLivro()->getId(),
            ':idC' => $this->getIdCompra()->getId(),
            ':valorU' => $this->getIdLivro()->getPreco(),
            ':quantidade' => $this->getQuantia(),
            ':valorT' => $this->getValorTotal()
        );
        Database::executar($sql, $parametros);
        return true;
    }

    public function excluir()
    {
        $sql = 'DELETE 
                  FROM usuarios
                 WHERE id = :id';
        $parametros = array(':id' => parent::getId());
        return Database::executar($sql, $parametros);
    }

    public static function listar($tipo = 0, $busca = ""): array
    {
        $sql = "SELECT * FROM itenscompras";
        if ($tipo > 0)
            switch ($tipo) {
                case 1:
                    $sql .= " WHERE id = :busca";
                    break;
                case 2:
                    $sql .= " WHERE idCompra = :busca";
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
            $livro = Livro::listar(1,$registro['idLivro'])[0];
            $compra = Compra::listar(1,$registro['idCompra'])[0];
            $quadrado = new Itenscompra($registro['id'], $livro, $compra, $registro['valorUnitario'], $registro['quantidade'], $registro['valorTotalItem']);
            array_push($formas, $quadrado);
        }
        return $formas;
    }

    public function Login() {}
}
