<?php
require_once('../classes/autoload.php');
require_once('../config/config.inc.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";
    $formulario = file_get_contents('templates/form.html');
    $livro = Livro::listar();
    $autor = Autor::listar();

    $opcoesA = '';
    $opcoesL = '';
    $opcaoSelecA = 0;
    $opcaoSelecL = 0;

    if ($id > 0) {
        $autorLivro = AutorLivro::listar(1, $id)[0];
        $opcaoSelecA = $autorLivro->getAutor()->getId();
        $opcaoSelecL = $autorLivro->getLivro()->getId();
        $formulario = str_replace('{id}', $autorLivro->getId(), $formulario);
    }

    foreach ($livro as $li) {
        $selected = ($opcaoSelecL == $li->getId()) ? 'selected' : '';
        $opcoesL .= '<option value="' . $li->getId() . '" ' . $selected . '>' . $li->getTitulo() . '</option>';
    }

    foreach ($autor as $au) {
        $selected = ($opcaoSelecA == $au->getId()) ? 'selected' : '';
        $opcoesA .= '<option value="' . $au->getId() . '" ' . $selected . '>' . $au->getNome() . ' ' . $au->getSobrenome() . '</option>';
    }

    $formulario = str_replace('{id}', 0, $formulario);
    $formulario = str_replace('{autor}', $opcoesA, $formulario);
    $formulario = str_replace('{livro}', $opcoesL, $formulario);

    print($formulario);
    include "autorLivro.php";
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0;
    $autorId = isset($_POST['autor']) ? $_POST['autor'] : "";
    $livroId = isset($_POST['livro']) ? $_POST['livro'] : "";

    $acao = isset($_POST['acao']) ? $_POST['acao'] : 0;

    try {
        $autor = Autor::listar(1, $autorId)[0];
        $livro = Livro::listar(1, $livroId)[0];
        $autorLivro = new AutorLivro($id,$livro, $autor );
        $resultado = "";

        if ($acao == 'salvar') {
            if ($id > 0) {
                $resultado = $autorLivro->alterar();
            } else {
                $resultado = $autorLivro->incluir();
            }
        } elseif ($acao == 'deletar') {
            $autorLivro->excluir();
            $resultado = "Autor e Livro excluídos com sucesso!";
        }

        header("Location: index.php?MSG=" . urlencode($resultado));
    } catch (Exception $e) {
        header("Location: index.php?MSG=" . urlencode($e->getMessage()));
    }
}