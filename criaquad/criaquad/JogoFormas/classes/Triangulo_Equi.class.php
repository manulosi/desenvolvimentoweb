<?php
require_once("../classes/Database.class.php");
require_once("../classes/Unidade.class.php");
require_once("../classes/Triangulo.class.php");


class Triangulo_Equi extends Triangulo
{

    public function  __construct($id = 0, $lado1 = 1, $lado2 = 1, $lado3 = 1,  $cor = "null", $imagem = "null", Unidade $unidade = null, $formato = "")
    {
        parent::__construct($id, $cor,$lado1,$lado2,$lado3, $imagem, $unidade,$formato);
      
        //equilatero todos os lados iguais, escaleno todos diferentes , isosceles dois lados iguais
    }

    public function incluir()
    {
        $sql = 'INSERT INTO triangulos (lado1,lado2,lado3, cor, unidades,imagem, idTriangulo , formato)   
                VALUES (:lado1,:lado2,:lado3, :cor, :unidades, :imagem,:id, :formato)';

        $parametros = array(
            ':lado1' => $this->getLado1(),
            ':lado2' => $this->getLado2(),
            ':lado3' => $this->getLado3(),
            ':cor' => parent::getCor(),
            ':unidades' => parent::getUnidade()->getIdUnidade(),
            ':imagem' => parent::getImagem(),
            ":formato" => "1",
            ':id' => parent::getId()
        );

        return Database::executar($sql, $parametros);
    }

    public function excluir()
    {
        $conexao = Database::getInstance();
        $sql = 'DELETE FROM triangulos WHERE idTriangulo = :id';
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':id', parent::getId());
        return $comando->execute();
    }

    public function alterar()
    {
        $sql = 'UPDATE triangulos 
            SET lado1 = :lado1, lado2 = :lado2, lado3 = :lado3, cor = :cor, unidades = :unidades, imagem = :imagem, formato = :formato
            WHERE idTriangulo = :id';
        $parametros = array(
            ':lado1' => $this->getLado1(),
            ':lado2' => $this->getLado2(),
            ':lado3' => $this->getLado3(),
            ':cor' => parent::getCor(),
            ':unidades' => parent::getUnidade()->getIdUnidade(),
            ':imagem' => parent::getImagem(),
            ':id' => parent::getId(),
            ':formato' => "1"
        );
        return Database::executar($sql, $parametros);
    }

    public static function listar($tipo = 0, $busca = ""): array
    {
        $sql = "SELECT * FROM triangulos";
        if ($tipo > 0) {
            switch ($tipo) {
                case 1:
                    $sql .= " WHERE idTriangulo = :busca";
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
                    $sql .= ", unidades WHERE unidades.id = triangulos.unidades and tipo like :busca";
                    break;
            }
        }
        $parametros = [];
        if ($tipo > 0)
            $parametros = array(':busca' => $busca);

        $comando = Database::executar($sql, $parametros);
        $triangulos = array();

        while ($forma = $comando->fetch(PDO::FETCH_ASSOC)) {
            $unidade = Unidade::listar(1, $forma['unidades'])[0];
            $triangulo = new Triangulo_Equi($forma['idTriangulo'], $forma['lado1'], $forma['lado2'], $forma['lado3'], $forma['cor'], $forma['imagem'], $unidade , $forma['formato']);
            array_push($triangulos, $triangulo);
        }
        return $triangulos;
    }
    public function desenhar()
{
    // return "
    //     <a href='index.php?idTriangulo=" . $this->getId() . "'>
    //         <div style='position: relative; display: inline-block;'>
    //             <div style='
    //                 width: 0;
    //                 height: 0;
    //                 border-left: " . $this->getLado1() . $this->getUnidade()->getNome() . " solid transparent;
    //                 border-right: " . $this->getLado2() . $this->getUnidade()->getNome() . " solid transparent;
    //                 border-bottom: " . $this->getLado3() . $this->getUnidade()->getNome() . " solid " . $this->getCor() . ";
    //             '>
    //             </div>
    //             <div style='
    //                 position: absolute;
    //                 top: 0;
    //                 left: 50%;
    //                 transform: translateX(-50%);
    //                 width: " . ($this->getLado3()) . $this->getUnidade()->getNome() . ";
    //                 height: " . ($this->getLado1() + $this->getLado2()) . $this->getUnidade()->getNome() . ";
    //                 background-image: url(" . '"' . $this->getImagem() . '"' . ");
    //                 background-size: cover;
    //                 background-repeat: no-repeat;
    //                 background-position: center;
    //                 clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
    //                 pointer-events: none;
    //             '></div>
    //         </div>
    //     </a>
    //     <br>";
}


    public function calcularPerimetro()
    {
        $peri = 4 * $this->getLado1();
        return "O perímetro é $peri " . parent::getUnidade()->getNome();
    }

    public function calcularArea()
    {
        $area = $this->getLado1() * $this->getLado1();
        return "A área é $area " . parent::getUnidade()->getNome();
    }

}
