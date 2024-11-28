<?php
require_once('../classes/autoload.php');
require_once('../config/config.inc.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $busca = isset($_GET['busca']) ? $_GET['busca'] : "";
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 0;
    $idCompra = isset($_GET['idCompra']) ? $_GET['idCompra'] : "";

    // Listar itens com base nos parâmetros de busca
    $itenss = "";

    // Se idCompra for maior que 0, listar itens da compra
    if ($idCompra > 0) {
        $itensCompra = Itenscompra::listar(2, $idCompra);
        foreach ($itensCompra as $itens) {
            $item = file_get_contents('templates/itens_itens.html');
            $item = str_replace(
                ['{id}', '{idLivro}', '{idCompra}', '{valorUnitario}', '{quantidade}', '{valorTotalItem}'],
                [
                    $itens->getId(),
                    $itens->getIdLivro()->getId(),
                    $itens->getIdCompra()->getId(),
                    $itens->getIdLivro()->getPreco(),
                    $itens->getQuantia(),
                    $itens->getIdLivro()->getPreco() * $itens->getQuantia()
                ],
                $item
            );
            $itenss .= $item;
        }
    } else {
        $lista = Itenscompra::listar($tipo, $busca);

        foreach ($lista as $itens) {
            $item = file_get_contents('templates/itens_itens.html');
            $item = str_replace(
                ['{id}', '{idLivro}', '{idCompra}', '{valorUnitario}', '{quantidade}', '{valorTotalItem}'],
                [
                    $itens->getId(),
                    $itens->getIdLivro()->getId(),
                    $itens->getIdCompra()->getId(),
                    $itens->getIdLivro()->getPreco(),
                    $itens->getQuantia(),
                    $itens->getIdLivro()->getPreco() * $itens->getQuantia()
                ],
                $item
            );
            $itenss .= $item;
        }
    }

    // Carregar e substituir o template da lista de itens
    $templateLista = file_get_contents('templates/lista_itens.html');
    $templateLista = str_replace('{itens}', $itenss, $templateLista);
    print($templateLista);
}
