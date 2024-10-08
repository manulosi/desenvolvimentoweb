<!DOCTYPE html>
<html lang="en">
<?php
    include("../navbar.php");
    require_once("../classes/Triangulo.class.php");
    require_once("triangulo.php");
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Formulário de Criação de Triângulo</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

    .form-label {
        font-family: 'Roboto', sans-serif;
        color: #000; /* Cor preta */
        margin-bottom: 0.25rem;
    }
    .form-control, .form-select {
        font-family: 'Roboto', sans-serif;
        border: 2px solid #000; /* Bordas pretas */
        border-radius: 4px;
        padding: 0.5rem;
        width: 100%;
        box-sizing: border-box;
    }
    .color-input {
        width: auto;
        height: 2rem;
        border: 2px solid #000; /* Bordas pretas */
        cursor: pointer;
    }
    input[type="submit"] {
        font-family: 'Roboto', sans-serif;
        background-color: #000; /* Cor preta */
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        margin-top: 1rem;
        cursor: pointer;
        width: 100%;
        transition: background-color 0.3s;
    }
    input[type="submit"]:hover {
        background-color: #444; /* Cor cinza escuro ao passar o mouse */
    }
    .table {
        border-collapse: collapse;
        width: 100%;
    }
    .table th, .table td {
        border: 1px solid #000; /* Bordas pretas */
        padding: 0.5rem;
        text-align: left;
        font-family: 'Roboto', sans-serif;
        font-size: 0.8rem;
    }
    .table-dark {
        background-color: #000; /* Cor preta */
        color: white;
    }
</style>

</head>

<body class="bg-gray-200">
    <div class="container mx-auto py-4 px-12">
        <form action="triangulo.php" method="post" enctype="multipart/form-data" class="p-5 bg-white rounded shadow-md space-y-4">
            <!-- Campo ID (oculto) -->
            <input type="text" name="id" id="id" value="<?= isset($triangulo) ? $triangulo->getId() : 0 ?>" hidden readonly>

            <!-- Lado 1 -->
            <div class="flex flex-col">
                <label class="form-label" for="lado1">Lado 1</label>
                <input type="number" class="form-control" name="lado1" id="lado1" value="<?= isset($triangulo) ? $triangulo->getLado1() : 0 ?>" placeholder="Digite o valor do lado 1" required>
            </div>

            <!-- Lado 2 -->
            <div class="flex flex-col">
                <label class="form-label" for="lado2">Lado 2</label>
                <input type="number" class="form-control" name="lado2" id="lado2" value="<?= isset($triangulo) ? $triangulo->getLado2() : 0 ?>" placeholder="Digite o valor do lado 2" required>
            </div>

            <!-- Lado 3 -->
            <div class="flex flex-col">
                <label class="form-label" for="lado3">Lado 3</label>
                <input type="number" class="form-control" name="lado3" id="lado3" value="<?= isset($triangulo) ? $triangulo->getLado3() : 0 ?>" placeholder="Digite o valor do lado 3" required>
            </div>

            <!-- Cor -->
            <div class="flex flex-col">
                <label class="form-label" for="cor">Cor</label>
                <input type="color" class="color-input" name="cor" id="cor" value="<?= isset($triangulo) ? $triangulo->getCor() : '#000000' ?>" required>
            </div>

            <!-- Unidade -->
            <div class="flex flex-col">
                <label class="form-label" for="unidade">Unidade</label>
                <select class="form-select" name="unidade" id="unidade" required>
                    <?php
                        $unidades = Unidade::listar();
                        foreach ($unidades as $unidade) {
                            $selected = isset($triangulo) && $triangulo->getUnidade()->getUnidade() == $unidade->getUnidade() ? 'selected' : '';
                            echo "<option value='{$unidade->getIdUni()}' $selected>{$unidade->getUnidade()}</option>";
                        }
                    ?>
                </select>
            </div>

            <!-- Imagem de Fundo -->
            <div class="flex flex-col">
                <label class="form-label" for="fundo">Imagem de Fundo:</label>
                <input type="file" name="fundo" id="fundo" class="form-control">
            </div>

            <!-- Botões de ação -->
            <div class="flex space-x-4 mt-5">
                <input type="submit" name="acao" id="acao" value="Salvar">
                <input type="submit" name="acao" id="acao" value="Excluir">
            </div>
        </form>

        <form method="get" class="p-5 bg-white rounded shadow-md mt-5 space-y-4">
            <h4 class="form-label"><b>Busca</b></h4>
            <div class="flex flex-col">
                <input type="text" class="form-control" name="busca" id="busca" placeholder="Busca" required>
            </div>
            <div class="flex flex-col">
                <select class="form-select" name="tipo" id="tipo" required>
                    <option value="1">ID</option>
                    <option value="2">Lado 1</option>
                    <option value="3">Lado 2</option>
                    <option value="4">Lado 3</option>
                    <option value="5">Tipo</option>
                    <option value="6">Cor</option>
                    <option value="7">Unidade</option>
                </select>
            </div>
            <input type="submit" name="acao" id="acao" value="Buscar" class="form-control">
        </form>

        <table class="table mt-5">
            <thead class="table-dark">
                <tr>
                    <th>Id</th>
                    <th>L1</th>
                    <th>L2</th>
                    <th>L3</th>
                    <th>Tipo</th>
                    <th>Unidade</th>
                    <th>Perímetro</th>
                    <th>Área</th>
                    <th>Triângulo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($lista as $triangulo) {
                    echo "<tr>
                             <td><a href='index.php?id=" . $triangulo->getId() . "' class='text-pink-400 hover:text-purple-500'>" . $triangulo->getId() . "</a></td>
                             <td>" . $triangulo->getLado1() . "</td>
                             <td>" . $triangulo->getLado2() . "</td>
                             <td>" . $triangulo->getLado3() . "</td>
                             <td>" . $triangulo->getTipo() . "</td>
                             <td>" . $triangulo->getUnidade()->getUnidade() . "</td>
                             <td>" . $triangulo->calcularPerimetro($triangulo) . $triangulo->getUnidade()->getUnidade() . "</td>
                             <td>" . $triangulo->calcularArea($triangulo) . $triangulo->getUnidade()->getUnidade() . "²</td>
                             <td>" . $triangulo->desenhar($triangulo)."</td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
