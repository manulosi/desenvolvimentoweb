<?php
require_once('../classes/autoload.php');
class Usuario extends Persistencia
{
    private $nome;
    private $email;
    private $senha;
    private $nivelperm;

    public function  __construct($id = 0, $nome = "", $email = "null", $senha = "null", $nivelperm = "")

    {
        parent::__construct($id);
        $this->setNome($nome);
        $this->setEmail($email);
        $this->setSenha($senha);
        $this->setNivel($nivelperm);
    }

    public function setNome($nome)
    {
        if ($nome === "")
            throw new Exception("Erro: nome inválido!");
        else
            $this->nome = $nome;
    }

    public function setEmail($email)
    {
        if ($email === "")
            throw new Exception("Erro: email inválido!");
        else
            $this->email = $email;
    }

    public function setSenha($senha)
    {
        if ($senha === "")
            throw new Exception("Erro: senha inválido!");
        else
            $this->senha = $senha;
    }
    public function setNivel($nivelperm)
    {
        if ($nivelperm === "")
            throw new Exception("Erro: Nível de permissão inválido!");
        else
            $this->nivelperm = $nivelperm;
    }

    public function getNome()
    {
        return $this->nome;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getSenha()
    {
        return $this->senha;
    }
    public function getNivel()
    {
        return $this->nivelperm;
    }

    public function incluir()
    {
        $sql = 'INSERT INTO usuario (nome, email, senha, nivelPerm, cpf)   
        VALUES (:nome, :email, :senha, :nivelPerm, :cpf)';

        $parametros = array(
            ':nome' => $this->getNome(),
            ':email' => $this->getEmail(),
            ':senha' => $this->getSenha(),
            ':nivelPerm' => $this->getNivel(),
            ':cpf' => null
        );

        return Database::executar($sql, $parametros);
    }

    public function alterar()
    {
        $sql = 'UPDATE usuario 
        SET nome = :nome, email = :email, senha = :senha, nivelPerm = :nivelPerm, cpf = :cpf
      WHERE id = :id';
        $parametros = array(
            ':id' => parent::getId(),
            ':nome' => $this->getNome(),
            ':email' => $this->getEmail(),
            ':senha' => $this->getSenha(),
            ':nivelPerm' => $this->getNivel(),
            ':cpf' => null
        );
        Database::executar($sql, $parametros);
        return true;
    }

    public function excluir()
    {
        $sql = 'DELETE 
                  FROM usuario
                 WHERE id = :id';
        $parametros = array(':id' => parent::getId());
        return Database::executar($sql, $parametros);
    }

    public static function listar($tipo = 0, $busca = ""): array
    {
        $sql = "SELECT * FROM usuario";
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
            $quadrado = new Usuario($registro['id'], $registro['nome'], $registro['email'], $registro['senha'], $registro['nivelPerm']);
            array_push($formas, $quadrado);
        }
        return $formas;
    }

    public function Login($nome, $senha)
    {
        $sql = 'SELECT * FROM usuario WHERE nome = :nome AND senha = :senha';
        $parametros = array(
            ':nome' => $nome,
            ':senha' => $senha
        );

        $comando = Database::executar($sql, $parametros);

        // $registro = $comando->fetch(PDO::FETCH_ASSOC);
        // var_dump($registro); // Verifique os dados retornados

        if ($registro = $comando->fetch(PDO::FETCH_ASSOC)) {
            $this->setNome($registro['nome']);
            $this->setEmail($registro['email']);
            $this->setSenha($registro['senha']);
            $this->setNivel($registro['nivelPerm']);
            return true;
        } else {
            return false;
}
}
}
