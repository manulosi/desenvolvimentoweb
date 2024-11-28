<?php
require_once("../classes/Autor.class.php");
require_once("../config/config.inc.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') { 
    $msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";
    $busca = isset($_GET['busca']) ? $_GET['busca'] : 0; 
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 0;

    // Lista os registros de Autor com base nos critérios de busca e tipo
    $lista = Autor::listar($tipo, $busca); 
    $itens = "";
    foreach ($lista as $autor) { 
        $item = file_get_contents('templates/itens.html');
        $item = str_replace('{id}', $autor->getId(), $item);
        $item = str_replace('{nome}', $autor->getNome(), $item);
        $item = str_replace('{sobrenome}', $autor->getSobrenome(), $item);
        $itens .= $item; 
    }   
    $templatelista = file_get_contents('templates/listagem.html');
    $templatelista = str_replace('{itens}', $itens, $templatelista);
    
    print($templatelista);
}
?>