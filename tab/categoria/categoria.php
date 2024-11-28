<?php
require_once("../classes/Categoria.class.php");
require_once("../config/config.inc.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') { 
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";

    // Carregar o formulário e preenchê-lo com dados, se uma categoria específica for solicitada
    $formulario = file_get_contents('templates/form.html');

    if ($id > 0) {
        $categoria = Categoria::listar(1, $id)[0];
        $formulario = str_replace('{id}', $categoria->getId(), $formulario); 
        $formulario = str_replace('{nome}', $categoria->getNome(), $formulario); 
        $formulario = str_replace('{descricao}', $categoria->getDescricao(), $formulario); 
    } else {
        $formulario = str_replace('{id}', '0', $formulario); 
        $formulario = str_replace('{nome}', '', $formulario); 
        $formulario = str_replace('{descricao}', '', $formulario); 
    }
    
    print($formulario);
    include "lista.php"; // Página para listar categorias

} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0; 
    $nome = isset($_POST['nome']) ? $_POST['nome'] : ""; 
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : ""; 
    $acao = isset($_POST['acao']) ? $_POST['acao'] : 0; 
    
    try {
        $categoria = new Categoria($id, $nome, $descricao);
        if ($acao == 'salvar') {
            if ($id > 0)
                $categoria->alterar();
            else                     
                $categoria->incluir();
        } elseif ($acao == 'excluir') {
            $categoria->excluir();
        }
        $_SESSION['MSG'] = "Dados inseridos/Alterados com sucesso!";
    } catch (Exception $e) { 
        $_SESSION['MSG'] = 'ERRO: ' . $e->getMessage();
    } finally {
        header('location: index.php'); 
    }
}
?>
