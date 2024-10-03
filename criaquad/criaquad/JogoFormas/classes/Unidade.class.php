<?php
require_once("../classes/Database.class.php");

class Unidade
{
    private $id;
    private $unidade;

    public function  __construct($id = 0, $unidade = 1)
    {
        $this->setIdUni($id);
        $this->setUnidade($unidade);
    }

    public function setIdUni($id)
    {
        if ($id < 0)
            throw new Exception("Erro: id inválido!");
        else
            $this->id = $id;
    }


    public function setUnidade($unidade)
    {
        if ($unidade == 0)
            throw new Exception("Erro, unidade indefinida");
        else
            $this->unidade = $unidade;
    }

    public function getIdUni()
    {
        return $this->id;
    }

    public function getUnidade()
    {
        return $this->unidade;
    }

    public function incluir()
    {
        $sql = 'INSERT INTO unidade (iduni, unidade)   
                VALUES (:id, :unidade)';

        $parametros = array(':id' => $this->id, ':unidade' => $this->unidade);
        return Database::executar($sql, $parametros);
    }

    public function excluir()
    {
        $conexao = Database::getInstance();
        $sql = 'DELETE FROM unidade WHERE iduni = :id';
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':id', $this->id);
        return $comando->execute();
    }

    public function alterar()
    {
        $sql = 'UPDATE unidade
                SET unidade = :unidade, iduni = :id
                WHERE iduni = :id';
        $parametros = array( ':unidade' => $this->unidade, ':id' => $this->id);
        return Database::executar($sql, $parametros);
        //return var_dump($parametros);
    }

    public static function listar($tipo = 0, $busca = "")
    {
        $sql = "SELECT * FROM unidade";
        if ($tipo > 0) {
            switch ($tipo) {
                case 1:
                    $sql .= " WHERE iduni = :busca";
                    break;
                case 2:
                    $sql .= "WHERE unidade LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
            }
        }
        // $comando = $conexao->prepare($sql);
        $parametros = [];
        if ($tipo > 0)
            $parametros = array(':busca' => $busca);

        $comando = Database::executar($sql, $parametros);
        $unidades = array();

        while ($forma = $comando->fetch(PDO::FETCH_ASSOC)) {
            $unidade = new Unidade($forma['iduni'], $forma['unidade']);
            array_push($unidades, $unidade);
        }
        return $unidades;
    }

}
