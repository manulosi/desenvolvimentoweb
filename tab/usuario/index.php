<?php
require_once('../classes/autoload.php');
require_once('../config/config.inc.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";
    $formulario = file_get_contents('templates/form.html');
    if ($id > 0) {
        $usuario = Cliente::listar(1, $id)[0];
        $formulario = str_replace('{id}', $usuario->getId(), $formulario);
        $formulario = str_replace('{nome}', $usuario->getNome(), $formulario);
        $formulario = str_replace('{email}', $usuario->getEmail(), $formulario);
        $formulario = str_replace('{senha}', $usuario->getSenha(), $formulario);
        $formulario = str_replace('{cpf}',  $usuario->getCpf(), $formulario);

        if ($usuario->getNivel() == 0) {
            $formulario = str_replace('{selected_0}', 'selected', $formulario);
            $formulario = str_replace('{selected_1}', '', $formulario);
        } else {
            $formulario = str_replace('{selected_0}', '', $formulario);
            $formulario = str_replace('{selected_1}', 'selected', $formulario);
        }
    } else {
        $formulario = str_replace('{id}', 0, $formulario);
        $formulario = str_replace('{nome}', '', $formulario);
        $formulario = str_replace('{email}', '', $formulario);
        $formulario = str_replace('{senha}', '', $formulario);
        $formulario = str_replace('{cpf}', '', $formulario);
        $formulario = str_replace('{selected_0}', 'selected', $formulario);
        $formulario = str_replace('{selected_1}', '', $formulario);
    }

    print($formulario);
    include "lista.php";
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0;
    $nome = isset($_POST['nome']) ? $_POST['nome'] : "";
    $email = isset($_POST['email']) ? $_POST['email'] : "";
    $senha = isset($_POST['senha']) ? $_POST['senha'] : "";
    $nivel = isset($_POST['nivel']) ? $_POST['nivel'] : "";
    $cpf = null;

    $acao = isset($_POST['acao']) ? $_POST['acao'] : 0;

    if ($nivel == 0)
        $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : "";

    try {
        // $cliente = new Cliente($id,$cpf);
        // $adm = new Administrador($id,$nivel);

        if ($nivel == 0) {
            $user = new Cliente($id, $nome, $email, $senha, $nivel, $cpf);
        } else
            $user = new Usuario($id, $nome, $email, $senha, $nivel);
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
