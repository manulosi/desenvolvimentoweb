<?php
    require_once("unidade.php");
    include_once('../navbar.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Cadastro de Unidade</title>
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
    input[type="submit"], input[type="reset"] {
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
    input[type="submit"]:hover, input[type="reset"]:hover {
        background-color: #444; /* Cor cinza ao passar o mouse */
    }
</style>

</head>

<body class="bg-gray-200">
    <div class="container mx-auto py-4 px-12">
        <form action="unidade.php" method="post" class="p-5 bg-white rounded shadow-md space-y-4">
            <input type="text" name="id" id="id" value="<?= $id ? $unidade->getIdUni() : 0 ?>" hidden readonly>

            <div class="flex flex-col">
                <label class="form-label" for="unidade">Unidade</label>
                <input type="text" class="form-control" name="unidade" id="unidade" value="<?= $id ? $unidade->getUnidade() : '' ?>" placeholder="Digite a unidade" required>
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
                    <option value="2">Unidade</option>
                </select>
            </div>
            <input type="submit" name="acao" id="acao" value="Buscar" class="form-control">
        </form>

        <table class="table mt-5">
            <thead class="table-dark">
                <tr>
                    <th>Id</th>
                    <th>Unidade</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($lista as $unidade) {
                    echo "<tr>
                             <td><a href='index.php?id=" . $unidade->getIdUni() . "' class='text-pink-400 hover:text-purple-500'>" . $unidade->getIdUni() . "</a></td>
                             <td>" . $unidade->getUnidade() . "</td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>
