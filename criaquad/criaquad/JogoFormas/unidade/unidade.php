<?php
require_once("../classes/Unidade.class.php");
require_once("../classes/Database.class.php");

$id = isset($_GET['id']) ? $_GET['id'] : 0;
$msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";
if ($id > 0) {
    $unidade = Unidade::listar(1, $id)[0];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0;
    $unidade = isset($_POST['unidade']) ? $_POST['unidade'] : "";
    $acao = isset($_POST['acao']) ? $_POST['acao'] : "";
    
    try {
        $unidade = new Unidade($id, $unidade);
        
        $resultado = "";
        switch ($acao) {
            case ("Salvar"):
                $resultado = $unidade->incluir();
                break;
            case ("Alterar"):
                $resultado = $unidade->alterar();
                break;
            case ("Excluir"):
                $resultado = $unidade->excluir();
                break;
        }
        if ($resultado)
            header('Location: index.php');
        else   
            echo "erro ao inserir dados!";
    } catch (Exception $e) {
        header('Location:index.php?MSG=ERROR:' . $e->getMessage());
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $busca = isset($_GET['busca']) ? $_GET['busca'] : "";
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 0;
    $lista = Unidade::listar($tipo, $busca);
}
