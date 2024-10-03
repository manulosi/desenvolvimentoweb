<?php
require_once("unidade.php");
require_once("../navbar.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Unidade</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Optional: You can include your own styles here -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .form-section {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h4 {
            color: #343a40;
        }

        .btn-custom {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <!-- Formulário de Cadastro -->
        <div class="form-section mb-5">
            <h4><b>Cadastro de Unidade</b></h4>
            <form action="unidade.php" method="post" class="mt-3">
                <input type="hidden" name="id" id="id" value="<?= $id ? $unidade->getIdUni() : 0 ?>" readonly>
                
                <div class="mb-3">
                    <label for="unidade" class="form-label">Unidade</label>
                    <input type="text" class="form-control" name="unidade" id="unidade" value="<?= $id ? $unidade->getUnidade() : '' ?>" placeholder="Digite o nome da unidade">
                </div>
                
                <div class="mb-3">
                    <button type="submit" name="acao" class="btn btn-dark btn-custom" value="Salvar">Salvar</button>
                    <button type="submit" name="acao" class="btn btn-dark btn-custom" value="Alterar">Alterar</button>
                    <button type="reset" class="btn btn-dark btn-custom">Resetar</button>
                    <button type="submit" name="acao" class="btn btn-dark" value="Excluir">Excluir</button>
                </div>
            </form>
        </div>

        <!-- Formulário de Busca -->
        <div class="form-section mb-5">
            <h4><b>Busca de Unidade</b></h4>
            <form method="get" class="mt-3">
                <div class="row g-3">
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="busca" id="busca" placeholder="Digite sua busca">
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" name="tipo" id="tipo">
                            <option value="1">ID</option>
                            <option value="2">Unidade</option>
                        </select>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" name="acao" class="btn btn-dark" value="Buscar">Buscar</button>
                </div>
            </form>
        </div>

        <!-- Tabela de Resultados -->
        <div class="table-container">
            <h4><b>Unidades Cadastradas</b></h4>
            <table class="table table-striped table-hover mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>Id</th>
                        <th>Unidade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($lista as $quadrado) {
                        echo "<tr>
                            <td><a href='index.php?id=" . $quadrado->getIdUni() . "'>" . $quadrado->getIdUni() . "</a></td>
                            <td>" . $quadrado->getUnidade() . "</td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS (opcional, mas recomendado para componentes dinâmicos) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
