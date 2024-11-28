<?php
require_once('../classes/autoload.php');
require_once('../config/config.inc.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $busca = isset($_GET['busca']) ? $_GET['busca'] : "";
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 0;
    $lista = Livro::listar($tipo, $busca);

    $msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";
    $itens = "";
  
foreach ($lista as $livro) {
    $item = file_get_contents('templates/itens.html');
    $item = str_replace('{id}', $livro->getId(), $item);
    $item = str_replace('{titulo}', $livro->getTitulo(), $item);
    $item = str_replace('{pub}', $livro->getAnoPublicacao(), $item);
    $item = str_replace('{categoria}', $livro->getIdCategoria() ? $livro->getIdCategoria()->getDescricao() : 'N/A', $item);
    $item = str_replace('{preco}', $livro->getPreco(), $item);
    // Adicionando a capa do livro
    $item = str_replace('{capa}',$livro->getFotoCapa(), $item);

    $itens .= $item;
    echo $livro->getFotoCapa();
}
    $templateLista = file_get_contents('templates/listagem.html');
    $templateLista = str_replace('{itens}', $itens, $templateLista);
    print($templateLista);
}
