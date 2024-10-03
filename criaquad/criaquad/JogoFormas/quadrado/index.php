<!DOCTYPE html>
<html lang="en">
<?php
    include_once('quadrado.php');
    require_once("../navbar.php");
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Formulário de Criação de Quadrados</title>
</head>

<body class="bg-gray-100">

    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-center mb-6">Formulário de Criação de Quadrados</h1>

        <form action="quadrado.php" method="post" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <input type="hidden" name="id" id="id" value="<?= $id ? $quadrado->getId() : 0 ?>">

            <!-- Altura -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="altura">Altura</label>
                <input type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="altura" id="altura" value="<?= $id ? $quadrado->getAltura() : 0 ?>" placeholder="Altura do quadrado">
            </div>

            <!-- Cor -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="cor">Cor</label>
                <input type="color" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="cor" id="cor" value="<?= $id ? $quadrado->getCor() : 'black' ?>">
            </div>

            <!-- Unidade -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="unidade">Unidade</label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="unidade" id="unidade">
                    <?php
                        $unidades = Unidade::listar();
                        foreach ($unidades as $unidade) {
                            $str = "<option value='{$unidade->getIdUni()}'";
                            if (isset($quadrado) && $quadrado->getUnidade()->getUnidade() == $unidade->getUnidade()) {
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

            <!-- Botões de Ação -->
            <div class="flex items-center justify-between space-x-2">
                <button type="submit" name="acao" value="Salvar" class="bg-black hover:bg-gray-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Salvar</button>
                <button type="submit" name="acao" value="Alterar" class="bg-black hover:bg-gray-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Alterar</button>
                <button type="submit" name="acao" value="Excluir" class="bg-black hover:bg-gray-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Excluir</button>
            </div>
        </form>

        <!-- Tabela de Resultados -->
        <div class="overflow-x-auto">
            <table class="table-auto w-full bg-white shadow-md rounded border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-800 text-white">
                        <th class="px-4 py-2">Id</th>
                        <th class="px-4 py-2">Altura</th>
                        <th class="px-4 py-2">Unidade</th>
                        <th class="px-4 py-2">Quadrado</th>
                        <th class="px-4 py-2">Perímetro</th>
                        <th class="px-4 py-2">Área</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($lista as $quadrado) {
                        echo "<tr class='bg-gray-100'>
                            <td class='border px-4 py-2'><a href='index.php?id=" . $quadrado->getId() . "' class='text-blue-500 hover:underline'>" . $quadrado->getId() . "</a></td>
                            <td class='border px-4 py-2'>" . $quadrado->getAltura() . "</td>
                            <td class='border px-4 py-2'>" . $quadrado->getUnidade()->getUnidade() . "</td>
                            <td class='border px-4 py-2'>" . $quadrado->desenhar() . "</td>
                            <td class='border px-4 py-2'>" . $quadrado->calcularPerimetro() . "</td>
                            <td class='border px-4 py-2'>" . $quadrado->calcularArea() . "</td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>