<?php
require_once('../classes/autoload.php');
require_once('../config/config.inc.php');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";
    $formulario = file_get_contents('templates/form.html');
    $cat = Categoria::listar();

    $categoriaOptions = '';
    $categoriaSelected = 0;

    if ($id > 0) {
        $autor = Livro::listar(1, $id)[0];
        $categoriaSelected = $autor->getIdCategoria()->getId();

        $formulario = str_replace('{id}', $autor->getId(), $formulario);
        $formulario = str_replace('{titulo}', $autor->getTitulo(), $formulario);
        $formulario = str_replace('{pub}', $autor->getAnoPublicacao(), $formulario);
        $formulario = str_replace('{capa}', $autor->getFotoCapa(), $formulario);
        $formulario = str_replace('{preco}', $autor->getPreco(), $formulario);
    }

    foreach ($cat as $categoria) {
        $selected = ($categoriaSelected == $categoria->getId()) ? 'selected' : '';
        $categoriaOptions .= '<option value="' . $categoria->getId() . '" ' . $selected . '>'
            . $categoria->getDescricao() . '</option>';
    }

    $formulario = str_replace('{id}', 0, $formulario);
    $formulario = str_replace('{titulo}', '', $formulario);
    $formulario = str_replace('{pub}', '', $formulario);
    $formulario = str_replace('{capa}', '', $formulario);
    $formulario = str_replace('{categoria}', $categoriaOptions, $formulario);
    $formulario = str_replace('{preco}', '', $formulario);


    print($formulario);
    include "lista.php";
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0;
    $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : "";
    $pub = isset($_POST['pub']) ? $_POST['pub'] : "";
    $capa = isset($_FILES['capa']) ? $_FILES['capa'] : "";
    $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : "";
    $preco = isset($_POST['preco']) ? $_POST['preco'] : "";
    $acao = isset($_POST['acao']) ? $_POST['acao'] : 0;
    $destino = "../" . IMG . "/" . $capa['name'];

    try {
        $categoria = Categoria::listar(1, $categoria)[0];
        $livro = new Livro($id, $titulo, $pub, $destino, $categoria, $preco);
        $resultado = "";
        
        if ($acao == 'salvar') {
            if ($id > 0) {
                $resultado = $livro->alterar();
            } else {
                $resultado = $livro->incluir();
            }
            move_uploaded_file($capa['tmp_name'], $destino);
        } elseif ($acao == 'excluir') {
            $resultado = $livro->excluir();
        }
        var_dump($livro);
        if ($resultado)
            header('Location: index.php');
        else
            echo "erro ao inserir dados!";
    } catch (Exception $e) {

        echo $e;
    }

}
