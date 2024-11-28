<?php
require_once('../classes/autoload.php');
require_once('../config/config.inc.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $idCompra = isset($_GET['idCompra']) ? $_GET['idCompra'] : "";
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : "";
    $busca = isset($_GET['busca']) ? $_GET['busca'] : "";
    $msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";
    $formulario = file_get_contents('templates/form_cadastro_itens.html');
    if ($idCompra > 0) {
        $itensCompra = Itenscompra::listar(2, $idCompra);
        foreach ($itensCompra as $item) {
            $formulario = str_replace('{id}', $item->getId(), $formulario);
            $formulario = str_replace('{idLivro}', $item->getIdLivro()->getId(), $formulario);
            $formulario = str_replace('{idCompra}', $item->getIdCompra()->getId(), $formulario);
            $formulario = str_replace('{valorUnitario}', $item->getIdLivro()->getPreco(), $formulario);
            $formulario = str_replace('{quantidade}',  $item->getQuantia(), $formulario);
            $formulario = str_replace('{valorTotalItem}',  $item->getValorTotal(), $formulario);
        }
    }
    $itensCompra = Itenscompra::listar($tipo, $busca);
    foreach ($itensCompra as $item =>$key) {
        $formulario = str_replace('{id}', $key->getId(), $formulario);
        $formulario = str_replace('{idLivro}', $key->getIdLivro()->getId(), $formulario);
        $formulario = str_replace('{idCompra}', $key->getIdCompra()->getId(), $formulario);
        $formulario = str_replace('{valorUnitario}', $key->getIdLivro()->getId(), $formulario);
        $formulario = str_replace('{quantidade}',  $key->getQuantia(), $formulario);
        $formulario = str_replace('{valorTotalItem}',  $key->getValorTotal(), $formulario);
    }
    print($formulario);
    include "listaritenscompras.php";
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0;
    $idLivro = isset($_POST['idLivro']) ? $_POST['idLivro'] : 0;
    $idCompra = isset($_POST['idCompra']) ? $_POST['idCompra'] : 0;
    $valorUnitario = isset($_POST['valorUnitario']) ? $_POST['valorUnitario'] : "";
    $quantidade = isset($_POST['quantidade']) ? $_POST['quantidade'] : "";
    $valorTotal = isset($_POST['valorTotal']) ? $_POST['valorTotal'] : "";

    $acao = isset($_POST['acao']) ? $_POST['acao'] : 0;

    try {
        $user = new Itenscompra($id, $idLivro, $idCompra, $valorUnitario, $quantidade, $valorTotal);
        $resultado = "";
        if ($acao == 'salvar') {
            if ($id > 0) {
                $resultado = $user->alterar();
            } else {
                $resultado = $user->incluir();
            }
        } elseif ($acao == 'excluir') {
            $resultado = $user->excluir();
        }
        var_dump($user);
        if ($resultado)
            header('Location: index.php');
        else
            echo "erro ao inserir dados!";
    } catch (Exception $e) {

        echo $e;
    }
}
