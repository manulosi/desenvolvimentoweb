<?php
require_once("../classes/Triangulo.class.php");
require_once("../classes/Unidade.class.php");
require_once("../classes/Database.class.php");
require_once("../classes/Equilatero.class.php");
require_once("../classes/Isoceles.class.php");
require_once("../classes/Escaleno.class.php");

$id = isset($_GET['id']) ? $_GET['id'] : 0;
$msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";
if ($id > 0) {
    $triangulo = Triangulo::listar(1, $id)[0];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0;
    $lado1 = isset($_POST['lado1']) ? $_POST['lado1'] : 0;
    $lado2 = isset($_POST['lado2']) ? $_POST['lado2'] : 0;
    $lado3 = isset($_POST['lado3']) ? $_POST['lado3'] : 0;
    $cor = isset($_POST['cor']) ? $_POST['cor'] : "";
    $unidade = isset($_POST['unidade']) ? $_POST['unidade'] : "";
    $arquivo =  isset($_FILES['fundo'])?$_FILES['fundo']:""; 
    $acao = isset($_POST['acao']) ? $_POST['acao'] : 0;
    $destino = "../".IMG."/".$arquivo['name'];


    function graus($rad) {
        return $rad * (180 / M_PI);
    }

    function calcularAngulos($lado1, $lado2, $lado3) {
        
        $anguloA = acos(($lado2 * $lado2 + $lado3 * $lado3 - $lado1 * $lado1) / (2 * $lado2 * $lado3));
        $anguloB = acos(($lado1 * $lado1 + $lado3 * $lado3 - $lado2 * $lado2) / (2 * $lado1 * $lado3));
        $anguloC = acos(($lado1 * $lado1 + $lado2 * $lado2 - $lado3 * $lado3) / (2 * $lado1 * $lado2));

        $anguloA = graus($anguloA);
        $anguloB = graus($anguloB);
        $anguloC = graus($anguloC);

        return [
            'A' => $anguloA,
            'B' => $anguloB,
            'C' => $anguloC
        ];
    }

    $angulos = calcularAngulos($lado1, $lado2, $lado3);

    $soma = $angulos['A'] + $angulos['B'] + $angulos['C'];


    if (($soma - 180) < 0.001) {
        
        if($lado1 === $lado2 && $lado2 === $lado3){
            $tipo = "Equilátero";
            $uni = Unidade::listar(1, $unidade)[0];
            $triangulo = new Equilatero($id, $lado1, $lado2, $lado3, $tipo, $cor, $uni, $destino);
        }
        elseif($lado1 === $lado2 || $lado2 === $lado3 || $lado3 === $lado1){
            $tipo = "Isóceles";
            $uni = Unidade::listar(1, $unidade)[0];
            $triangulo = new Isoceles($id, $lado1, $lado2, $lado3, $tipo, $cor, $uni, $destino);
        }
        else{
            $tipo = "Escaleno";
            $uni = Unidade::listar(1, $unidade)[0];
            $triangulo = new Escaleno($id, $lado1, $lado2, $lado3, $tipo, $cor, $uni, $destino);
        }
        try {
            $resultado = "";
            switch ($acao) {
                case ("Salvar"):
                    if($id > 0){
                        $resultado = $triangulo->alterar();
                        break;
                    }
                    else{
                        $resultado = $triangulo->incluir();
                        break;
                    }
                case ("Excluir"):
                    $resultado = $triangulo->excluir();
                    break;
            }
            $_SESSION['MSG'] = "Dados inseridos/Alterados com sucesso!";
            move_uploaded_file($arquivo['tmp_name'],$destino);
    
            if ($resultado)
                header('Location: index.php?Os.valores.fornecidos.não.formam.um.triângulo.válido');
            else
                echo "erro ao inserir dados!";
            
        } catch (Exception $e) {
            //header('Location:index.php?MSG=ERROR:' . $e->getMessage());
            echo $e->getMessage();
        }
    } else {
        header('Location: index.php?Os.valores.fornecidos.não.formam.um.triângulo.válido');
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $busca = isset($_GET['busca']) ? $_GET['busca'] : "";
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 0;
    $lista = Triangulo::listar($tipo, $busca);
    // if($lado1 === $lado2 && $lado2 === $lado3){
    //     $lista = Equilatero::listar($tipo, $busca);
    // }
    // elseif($lado1 === $lado2 || $lado2 === $lado3 || $lado3 === $lado1){
    //     $lista = Isoceles::listar($tipo, $busca);
    // }
    // else{
    //     $lista = Escaleno::listar($tipo, $busca);
    // }
}

