<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <a href="index.php"><img src="imagens/logo.png" alt="logo" class="logo"></a>


    <h1>Estoque de Produtos</h1>
    <div>
        <nav>
            <ul>
                <li><a href="index.php">Pagina Principal</a></li>
                <li><a href="cadastro.php">Cadastrar Produtos</a></li>
            </ul>
        </nav>
    
    
</body>
</html>

<?php
require 'conexao.php';
$query = "SELECT * FROM produtos"; // Consulta para selecionar todos os produtos
$result = mysqli_query($conexao, $query); // Executa a consulta
if ($result) {
    echo "<table>";
    echo "<tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Preço</th>
            <th>Quantidade</th>
            <th>Data de Validade</th>
            <th>Editar</th>
            <th>Excluir</th>
          </tr>";
    
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id_produtos']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
        echo "<td>" . htmlspecialchars($row['descricao']) . "</td>";
        echo "<td>R$ " . number_format($row['preco'], 2, ',', '.') . "</td>";
        echo "<td>" . htmlspecialchars($row['estoque']) . "</td>";
        $dataFormatada = date('d/m/Y', strtotime($row['validade']));
        echo "<td>" . $dataFormatada . "</td>";
        echo "<td><a href='edicao.php?id=" . htmlspecialchars($row['id_produtos']) . "'>Editar</a></td>";
        echo "<td><a href='excluir.php?id=" . htmlspecialchars($row['id_produtos']) . "'>Excluir</a></td>";
        echo "</tr>";
    }
} else {
    echo "Erro ao consultar os produtos: " . mysqli_error($conexao);
    die;
}  


?>
