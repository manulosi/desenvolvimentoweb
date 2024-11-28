<?php
require_once("../classes/Livro.class.php");
require_once("../config/config.inc.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') { 
    $msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";
    $busca = isset($_GET['busca']) ? $_GET['busca'] : 0; 
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 0;

    // Listar livros de acordo com os parâmetros de busca e tipo
    $lista = Categoria::listar($tipo, $busca); // Alterado para Livro
    $itens = "";

    foreach ($lista as $livro) { 
        $item = file_get_contents('templates/itens.html');
        $item = str_replace('{id}', $livro->getId(), $item);
        $item = str_replace('{descricao}', $livro->getDescricao(), $item); // Certifique-se de que o método getDescricao() existe na classe Livro
        
        $itens .= $item; 
    }

    // Carrega o template da lista de livros e insere os itens
    $templatelista = file_get_contents('templates/listagem.html');
    $templatelista = str_replace('{itens}', $itens, $templatelista);
    
    print($templatelista);
}
?>