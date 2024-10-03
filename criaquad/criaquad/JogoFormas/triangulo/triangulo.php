<?php
require_once("../classes/Triangulo_Equi.class.php");
require_once("../classes/Triangulo.class.php");
require_once("../classes/Triangulo_Iso.class.php");
require_once("../classes/Triangulo_Esca.class.php");
require_once("../classes/Database.class.php");
require_once("../classes/Unidade.class.php");

$id = isset($_GET['idTriangulo']) ? $_GET['idTriangulo'] : 0;
$msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";
if ($id > 0) {
    $contato = Triangulo_Esca::listar(1, $id)[0];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0;
    $altura1 = isset($_POST['altura1']) ? $_POST['altura1'] : 0;
    $altura2 = isset($_POST['altura2']) ? $_POST['altura2'] : 0;
    $altura3 = isset($_POST['altura3']) ? $_POST['altura3'] : 0;
    $cor = isset($_POST['cor']) ? $_POST['cor'] : "null";
    $idUnida = isset($_POST['idUnida']) ? $_POST['idUnida'] : 0;
    $tipo = isset($_POST['escolhaQuad']) ? $_POST['escolhaQuad'] : "";
    $acao = isset($_POST['acao']) ? $_POST['acao'] : 0;
    $formato = isset($_POST['forma']) ? $_POST['forma'] : "";

    try {
        $validacao = VerificarForma($altura1, $altura2, $altura3, $formato);
        if ($validacao !== $formato) {
            echo $formato;
            throw new Exception("Formato informado inválido");
        }

        if ($tipo == "img") {
            $nome_arquivo = $_FILES['imagem']['name'];
            $tmp_nome = $_FILES['imagem']['tmp_name'];
            $nome_unico = uniqid() . '.' . pathinfo($nome_arquivo, PATHINFO_EXTENSION);

            $caminho_relativo = IMG . $nome_unico;
            $unid = Unidade::listar(1, $idUnida)[0];
            if ($formato == "1")
                $Triangulo = new Triangulo_Equi($id, $altura1, $altura2, $altura3, null, $caminho_relativo, $unid, $validacao);
            elseif ($formato == "2")
                $Triangulo = new Triangulo_Iso($id, $altura1, $altura2, $altura3, null, $caminho_relativo, $unid, $validacao);
            else
                $Triangulo = new Triangulo_Esca($id, $altura1, $altura2, $altura3, null, $caminho_relativo, $unid, $validacao);
        } else {
            $unid = Unidade::listar(1, $idUnida)[0];
            if ($formato == "1")
                $Triangulo = new Triangulo_Equi($id, $altura1, $altura2, $altura3, $cor, null, $unid, $validacao);
            elseif ($formato == "2")
                $Triangulo = new Triangulo_Iso($id, $altura1, $altura2, $altura3, $cor, null, $unid, $validacao);
            else
                $Triangulo = new Triangulo_Esca($id, $altura1, $altura2, $altura3, $cor, null, $unid, $validacao);
        }

        $resultado = "";
        if ($acao == 'salvar') {
            if ($id > 0) {
                $resultado = $Triangulo->alterar();
            } else {
                $resultado = $Triangulo->incluir();
            }
        } elseif ($acao == 'excluir') {
            $resultado = $Triangulo->excluir();
        }
        if ($resultado) {
            header('Location: index.php');
        } else {
            echo "Erro ao inserir dados!";
        }
        move_uploaded_file($tmp_nome, IMG . $nome_unico);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $busca = isset($_GET['busca']) ? $_GET['busca'] : "";
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 0;
    $lista = Triangulo_Esca::listar($tipo, $busca);
}

function VerificarForma($lado1, $lado2, $lado3, $formato)
{
    $shape = "";

    if ($lado1 == $lado2 && $lado2 == $lado3) {
        $shape = "1";
    } elseif ($lado1 == $lado2 || $lado1 == $lado3 || $lado2 == $lado3) {
        $shape = "2";
    } else {
        $shape = "3";
    }

    if ($shape == $formato) {
        return $shape;
    } else {
        return "Formato informado inválido";
    }
}
