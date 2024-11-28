<?php
require_once('../classes/autoload.php');
require_once('../config/config.inc.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Captura os parâmetros da URL
    $check = isset($_GET['comprar']) ? $_GET['comprar'] : "";
    $acao = isset($_GET['acao']) ? $_GET['acao'] : "";
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";

    // Exibe o formulário de compra se houver livros selecionados
    if ($check) {
        echo "<form method='post' id='compraForm'>";
        echo "<table>";
        echo "<tr><th>Id</th><th>Titulo</th><th>Publicação</th><th>Capa</th><th>Categoria</th><th>Preço</th><th>Quantia</th></tr>";
        $valorTotal = 0; // Inicializa o valor total
        foreach ($check as $c) {
            $livro = Livro::listar(1, $c)[0];
            $preco = $livro->getPreco();
            echo "<tr>";
            echo "<td><input type='text' name='idLivro[]' readonly value='" . $livro->getId() . "'></td>";
            echo "<td><input type='text' name='tit[]' readonly value='" . $livro->getTitulo() . "'></td>";
            echo "<td><input type='text' name='pub[]' readonly value='" . $livro->getAnoPublicacao() . "'></td>";
            echo "<td><input type='text' name='capa[]' readonly value='" . $livro->getFotoCapa() . "'></td>";
            echo "<td><input type='text' name='categoria[]' readonly value='" . $livro->getIdCategoria()->getDescricao() . "'></td>";
            echo "<td><input type='text' name='preco[]' readonly value='" . $preco . "'></td>";
            echo "<td><input type='number' name='quantia[]' value='1' min='1' class='quantidade' onchange='calcularTotal()'></td>";
            echo "</tr>";
            $valorTotal += $preco; // Adiciona o preço do livro ao valor total
        }
        echo "</table>";
        echo "<h3>Valor Total a Pagar: R$ <span id='valorTotal'>" . number_format($valorTotal, 2, ',', '.') . "</span></h3>";
       
        echo "</form>";
    }
}
?>

<script>
function calcularTotal() {
    let total = 0;
    const quantidades = document.querySelectorAll('.quantidade');
    const precos = document.querySelectorAll('input[name="preco[]"]');

    for (let i = 0; i < quantidades.length; i++) {
        const quantidade = parseInt(quantidades[i].value);
        const preco = parseFloat(precos[i].value);
        total += quantidade * preco;
    }

    document.getElementById('valorTotal').innerText = total.toFixed(2).replace('.', ',');
}
</script>