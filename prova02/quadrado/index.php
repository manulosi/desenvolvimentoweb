<!DOCTYPE html>
<html lang="en">
<?php
    include_once('quadrado.php');
    include_once('../navbar.php');
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Formulário de Criação de Formas</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

    .form-label {
        font-family: 'Roboto', sans-serif;
        color: #000; /* Cor preta */
        margin-bottom: 0.25rem; /* Espaçamento inferior */
    }
    .form-control, .form-select {
        font-family: 'Roboto', sans-serif;
        border: 2px solid #000; /* Bordas pretas */
        border-radius: 4px;
        padding: 0.5rem; 
        width: 100%; /* Largura padrão */
        box-sizing: border-box; /* Inclui padding e border na largura total */
    }
    .color-input {
        width: auto; /* Ajusta a largura do seletor de cor */
        height: 2rem; /* Define a altura do seletor de cor */
        border: 2px solid #000; /* Bordas pretas */
        cursor: pointer; /* Muda o cursor ao passar o mouse */
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
    }
    .table-dark {
        background-color: #000; /* Cor preta */
        color: white;
    }
    input[type="submit"] {
        font-family: 'Roboto', sans-serif;
        background-color: #000; /* Cor preta */
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        margin-top: 1rem;
        cursor: pointer;
        width: 100%; /* Tamanho uniforme para os botões */
        transition: background-color 0.3s;
    }
    input[type="submit"]:hover {
        background-color: #444; /* Cor cinza ao passar o mouse */
    }
</style>

</head>

<body class="bg-gray-200">
    <div class="container mx-auto py-4 px-12">
    <nav class="bg-pink-100 shadow-lg p-4 rounded mb-5">
    <h1 class="text-3xl font-bold text-center mb-6">Formulário de Criação de Quadrado</h1>
        <form action="quadrado.php" method="post" enctype="multipart/form-data" class="p-5 bg-white rounded shadow-md space-y-4">
            <input type="text" name="id" id="id" value="<?= $id ? $quadrado->getId() : 0 ?>" hidden readonly>

            <div class="flex flex-col">
                <label class="form-label" for="altura">Altura</label>
                <input type="number" class="form-control" name="altura" id="altura" value="<?= $id ? $quadrado->getAltura() : 0 ?>" placeholder="Digite a altura de sua forma" required>
            </div>

            <div class="flex flex-col">
                <label class="form-label" for="cor">Cor</label>
                <input type="color" class="color-input" name="cor" id="cor" value="<?= $id ? $quadrado->getCor() : 'black' ?>">
            </div>

            <div class="flex flex-col">
                <label class="form-label" for="unidade">Unidade</label>
                <select class="form-select" name="unidade" id="unidade" required>
                    <?php
                        $unidades = Unidade::listar();
                        foreach ($unidades as $unidade) {
                            $str = "<option value='{$unidade->getIdUni()}'";
                            if(isset($quadrado) && $quadrado->getUnidade()->getUnidade() == $unidade->getUnidade())
                                $str .= " selected";
                            $str .= ">{$unidade->getUnidade()}</option>";
                            echo $str;
                        }
                    ?>
                </select>
            </div>

            <div class="flex flex-col">
                <label class="form-label" for="fundo">Imagem de Fundo:</label>
                <input type="file" name="fundo" id="fundo" class="form-control">
            </div>

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
                    <option value="2">Lado</option>
                    <option value="3">Cor</option>
                    <option value="4">Unidade</option>
                </select>
            </div>
            <input type="submit" name="acao" id="acao" value="Buscar" class="form-control">
        </form>

        <table class="table mt-5">
            <thead class="table-dark">
                <tr>
                    <th>Id</th>
                    <th>Altura</th>
                    <th>Cor</th>
                    <th>Unidade</th>
                    <th>Perímetro</th>
                    <th>Área</th>
                    <th>Quadrados</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($lista as $quadrado) {
                    echo "<tr>
                             <td><a href='index.php?id=" . $quadrado->getId() . "' class='text-pink-400 hover:text-purple-500'>" . $quadrado->getId() . "</a></td>
                             <td>" . $quadrado->getAltura() . "</td>
                             <td>" . $quadrado->getCor() . "</td>
                             <td>" . $quadrado->getUnidade()->getUnidade() . "</td>
                             <td>" . $quadrado->calcularPerimetro($quadrado) . " " . $quadrado->getUnidade()->getUnidade() . "</td>
                             <td>" . $quadrado->calcularArea($quadrado) . " " . $quadrado->getUnidade()->getUnidade() . "²</td>
                             <td><a href='index.php?id=" . $quadrado->getId() . "' class='text-pink-400 hover:text-purple-500'>" . $quadrado->desenhar($quadrado) . "</a></td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
