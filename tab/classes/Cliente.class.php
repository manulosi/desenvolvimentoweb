<?php
require_once("../classes/autoload.php");
class Cliente extends Usuario
{
    private $cpf;

    public function  __construct($id = 0, $nome = "", $email = "null", $senha = "null", $nivelperm = "",  $cpf = "")

    {
        parent::__construct($id,$nome,$email,$senha,$nivelperm);
        $this->setCpf($cpf);

    }

    // ====================== Seter's ======================== //

    public function setCpf($cpf)
    {
        if ($cpf === "")
            throw new Exception("Erro: CPF inválido!");
        else
            $this->cpf = $cpf;
    }

    // ====================== Geter's ======================== //

    public function getCpf()
    {
        return $this->cpf;
    }

    // ====================== DBFunctions ======================== //


    public function incluir()
    {
        $sql = 'INSERT INTO usuarios (nome, email, senha, nivelPerm, cpf)   
        VALUES (:nome, :email, :senha, :nivelPerm, :cpf)';

        $parametros = array(
            ':nome' => parent::getNome(),
            ':email' => parent::getEmail(),
            ':senha' => parent::getSenha(),
            ':nivelPerm' => parent::getNivel(),
            ':cpf' => $this->getCpf(),
        );

        return Database::executar($sql, $parametros);
    }

    public function alterar()
    {
        $sql = 'UPDATE usuarios 
        SET nome = :nome, email = :email, senha = :senha, nivelPerm = :nivelPerm, cpf = :cpf
      WHERE id = :id';
        $parametros = array(
            ':id' => parent::getId(),
            ':nome' => parent::getNome(),
            ':email' => parent::getEmail(),
            ':senha' => parent::getSenha(),
            ':nivelPerm' => parent::getNivel(),
            ':cpf' => $this->getCpf()
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
        $sql = "SELECT * FROM usuarios";
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
                case 4:
                    $sql .= " WHERE cpf like :busca";
                    $busca = "%{$busca}%";
                    break;
            }
        $parametros = array();
        if ($tipo > 0)
            $parametros = array(':busca' => $busca);
        $comando = Database::executar($sql, $parametros);
        $formas = array();
        while ($registro = $comando->fetch(PDO::FETCH_ASSOC)) {
            $quadrado = new Cliente($registro['id'], $registro['nome'], $registro['email'], $registro['senha'], $registro['nivelPerm'], $registro['cpf']);
            array_push($formas, $quadrado);
        }
        return $formas;
    }

   
}
