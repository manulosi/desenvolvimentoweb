<?php
require_once('../classes/autoload.php');
require_once('../config/config.inc.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $busca = isset($_GET['busca']) ? $_GET['busca'] : "";
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 0;

    $lista = AutorLivro::listar($tipo, $busca);
    $msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";
    $itens = "";

    foreach ($lista as $autorLivro) {
        $item = file_get_contents('templates/itens.html');
        $item = str_replace('{id}', $autorLivro->getId(), $item);
        $item = str_replace('{autor}', $autorLivro->getAutor()->getNome() . " " . $autorLivro->getAutor()->getSobrenome(), $item);
        $item = str_replace('{livro}', $autorLivro->getLivro()->getTitulo(), $item);
        $itens .= $item;
    }

    $templateLista = file_get_contents('templates/listagem.html');
    $templateLista = str_replace('{itens}', $itens, $templateLista);
    print($templateLista);
}