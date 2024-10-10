<!DOCTYPE html>
<html lang="en">

<?php
    include_once('circulo.php');
    require_once("../navbar.php");
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Formulário de Criação de Formas</title>
</head>
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
        input[type="submit"], button {
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
        input[type="submit"]:hover, button:hover {
            background-color: #444; /* Cor cinza ao passar o mouse */
        }
    </style>


<body class="bg-gray-100">
    <div class="container mx-auto p-6">
    <nav class="bg-pink-100 shadow-lg p-4 rounded mb-5">
        <h1 class="text-3xl font-bold text-center mb-6">Formulário de Criação de Circulos</h1>

        <form action="circulo.php" method="post" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <input type="text" hidden name="id" id="id" value="<?= $id ? $circulo->getId() : 0 ?>">

            <!-- Raio -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="raio">Raio</label>
                <input type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="raio" id="raio" value="<?= $id ? $circulo->getRaio() :null ?>" placeholder="Raio de sua forma">
            </div>

            <!-- Cor -->
            <div class="flex flex-col">
                <label class="form-label" for="cor">Cor</label>
                <input type="color" class="color-input" name="cor" id="cor" value="<?= $id ? $circulo->getCor() : 'black' ?>">
            </div>

            <!-- Unidade -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="unidade">Unidade</label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="unidade" id="unidade">
                    <?php
                        $unidades = Unidade::listar();
                        foreach ($unidades as $unidade) {
                            $str = "<option value='{$unidade->getIdUni()}'";
                            if (isset($circulo) && $circulo->getUnidade()->getUnidade() == $unidade->getUnidade()) {
                                $str .= " selected";
                            }
                            $str .= ">{$unidade->getUnidade()}</option>";
                            echo $str;
                        }
                    ?>
                </select>
            </div>

            <!-- Imagem de Fundo -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="fundo">Imagem de Fundo</label>
                <input type="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="fundo" id="fundo">
            </div>

            <!-- Botões de Ação (Pretos e próximos) -->
            <div class="flex items-center justify-between space-x-2">
                <button type="submit" name="acao" value="Salvar" class="bg-black hover:bg-gray-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Salvar</button>
                  <button type="submit" name="acao" value="Excluir" class="bg-black hover:bg-gray-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Excluir</button>
            </div>
        </form>

        <!-- Formulário de Busca -->
        <form method="get" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <h4 class="text-xl font-bold mb-4">Busca</h4>
            <div class="flex mb-4">
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-4" name="busca" id="busca" placeholder="Busca">
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="tipo" id="tipo">
                    <option value="1">ID</option>
                    <option value="2">Raio</option>
                    <option value="3">Unidade</option>
                </select>
            </div>
            <input type="submit" value="Buscar" class="bg-black hover:bg-gray-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
        </form>

        <!-- Tabela de Resultados -->
        <div class="overflow-x-auto">
            <table class="table-auto w-full bg-white shadow-md rounded border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-800 text-white">
                        <th class="px-4 py-2">Id</th>
                        <th class="px-4 py-2">Raio</th>
                        <th class="px-4 py-2">Unidade</th>
                        <th class="px-4 py-2">Círculo</th>
                        <th class="px-4 py-2">Perímetro</th>
                        <th class="px-4 py-2">Área</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($lista as $circulo) {
                        echo "<tr class='bg-gray-100'>
                            <td class='border px-4 py-2'><a href='index.php?id=" . $circulo->getId() . "' class='text-blue-500 hover:underline'>" . $circulo->getId() . "</a></td>
                            <td class='border px-4 py-2'>" . $circulo->getRaio() . "</td>
                            <td class='border px-4 py-2'>" . $circulo->getUnidade()->getUnidade() . "</td>
                            <td class='border px-4 py-2'>" . $circulo->desenhar() . "</td>
                            <td class='border px-4 py-2'>" . $circulo->calcularPerimetro() . "</td>
                            <td class='border px-4 py-2'>" . $circulo->calcularArea() . "</td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
