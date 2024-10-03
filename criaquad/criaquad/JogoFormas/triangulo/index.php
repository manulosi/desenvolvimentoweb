<!DOCTYPE html>
<html lang="pt-br">
<?php
include_once('triangulo.php');
require_once("../navbar.php");
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Formulário de Criação de Triângulos</title>
</head>

<body class="bg-gray-100">

    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-center mb-6">Formulário de Criação de Triângulos</h1>

        <form action="triangulo.php" method="post" enctype='multipart/form-data' class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <input type="hidden" name="id" id="id" value="<?= isset($contato) ? $contato->getId() : 0 ?>">

            <!-- Lado 1 -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="altura1">Lado 1</label>
                <input type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="altura1" id="altura1" value="<?= isset($contato) ? $contato->getLado1() : 0 ?>" placeholder="Digite o lado 1 do triângulo">
            </div>

            <!-- Lado 2 -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="altura2">Lado 2</label>
                <input type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="altura2" id="altura2" value="<?= isset($contato) ? $contato->getLado2() : 0 ?>" placeholder="Digite o lado 2 do triângulo">
            </div>

            <!-- Lado 3 -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="altura3">Lado 3</label>
                <input type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="altura3" id="altura3" value="<?= isset($contato) ? $contato->getLado3() : 0 ?>" placeholder="Digite o lado 3 do triângulo">
            </div>

            <!-- Tipo de Triângulo -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="forma">Tipo de Triângulo</label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="forma" id="forma">
                    <option value="1" <?= (isset($contato) && $contato->getFormato() == "1") ? "selected" : "" ?>>Equilátero</option>
                    <option value="2" <?= (isset($contato) && $contato->getFormato() == "2") ? "selected" : "" ?>>Escaleno</option>
                    <option value="3" <?= (isset($contato) && $contato->getFormato() == "3") ? "selected" : "" ?>>Isósceles</option>
                </select>
            </div>

            <!-- Escolha de Imagem ou Cor -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="escolha">Escolha de Imagem ou Cor</label>
                <input type="radio" name="escolhaQuad" id="escolhaQuadImg" value="img"> Imagem
                <input type="radio" name="escolhaQuad" id="escolhaQuadCor" value="color"> Cor
            </div>

            <div class="mb-4">
                <input type="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="imagem" id="imagem">
                <input type="color" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="cor" id="cor" value="<?= isset($contato) ? $contato->getCor() : '#000000' ?>">
            </div>

            <!-- Unidade -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="unidade">Unidade</label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="idUnida" id="idUnida">
                    <option value="0">Selecione</option>
                    <?php
                    $uniLista = Unidade::listar();
                    foreach ($uniLista as $unidade) {
                        $selected = isset($contato) && $contato->getUnidade()->getIdUnidade() == $unidade->getIdUnidade() ? "selected" : "";
                        echo "<option value='{$unidade->getIdUnidade()}' $selected>{$unidade->getNome()}</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Botões de Ação -->
            <div class="flex items-center justify-between space-x-2">
                <button type="submit" name="acao" value="Salvar" class="bg-black hover:bg-gray-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Salvar</button>
                <button type="submit" name="acao" value="Alterar" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Alterar</button>
                <button type="submit" name="acao" value="Excluir" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Excluir</button>
                <button type="reset" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Resetar</button>
            </div>
        </form>

        <!-- Tabela de Resultados -->
        <div class="overflow-x-auto">
            <h2 class="text-2xl font-bold mt-6 mb-4">Buscar Triângulos</h2>
            <form action="" method="get" class="mb-4 flex items-center space-x-4">
                <input type="text" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="busca" id="busca" placeholder="Digite sua busca">
                <select name="tipo" id="tipo" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="1">ID</option>
                    <option value="2">Lado</option>
                    <option value="3">Cor</option>
                    <option value="4">Unidade</option>
                </select>
                <button type="submit" name="acao" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Buscar</button>
            </form>

            <table class="table-auto w-full bg-white shadow-md rounded border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-800 text-white">
                        <th class="px-4 py-2">Lado 1</th>
                        <th class="px-4 py-2">Lado 2</th>
                        <th class="px-4 py-2">Lado 3</th>
                        <th class="px-4 py-2">Cor</th>
                        <th class="px-4 py-2">Unidade</th>
                        <th class="px-4 py-2">Perímetro</th>
                        <th class="px-4 py-2">Área</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($lista as $triangulo) {
                        echo "<tr class='bg-gray-100'>
                            <td class='border px-4 py-2'>{$triangulo->getLado1()}</td>
                            <td class='border px-4 py-2'>{$triangulo->getLado2()}</td>
                            <td class='border px-4 py-2'>{$triangulo->getLado3()}</td>
                            <td class='border px-4 py-2'>{$triangulo->getCor()}</td>
                            <td class='border px-4 py-2'>{$triangulo->getUnidade()->getNome()}</td>
                            <td class='border px-4 py-2'>{$triangulo->perimetro()}</td>
                            <td class='border px-4 py-2'>{$triangulo->area()}</td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
