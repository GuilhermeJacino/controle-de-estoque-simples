<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
     <a href="index.php"><img src="imagens/logo.png" alt="logo" class="logo"></a>

    <h1>Edite o seu produto</h1>


    <div>
        <nav>
            
                <a href="index.php">Pagina Principal</a>
                <a href="estoque.php">Estoque</a>
                <a href="cadastro.php">Cadastrar Produtos</a>
            </nav>
    </div>

</body>
</html>
<?php
    if (isset($_GET['id'])){
        $id = $_GET['id'];
    }
    require 'conexao.php';

    $query = "SELECT * FROM produtos WHERE id_produtos = ?";
    $stmt = mysqli_prepare($conexao, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result->num_rows > 0) {
        $produto = mysqli_fetch_assoc($result);
        echo "<h2>Editar Produto: " . htmlspecialchars($produto['nome']) . "</h2>";
        echo "<form action='edicao.php' method='post'>";
        echo "<input type='hidden' name='id_produto' value='" . htmlspecialchars($produto['id_produtos']) . "'>";
        echo "<label for='nome'>Nome:</label>";
        echo "<input type='text' id='nome' name='nome' value='" . htmlspecialchars($produto['nome']) . "' required>";
        echo "<br>";
        echo "<label for='descricao'>Descrição:</label>";
        echo "<input type='text' id='descricao' name='descricao' value='" . htmlspecialchars($produto['descricao']) . "' required>";
        echo "<br>";
        echo "<label for='preco'>Preço:</label>";
        echo "<input type='number' id='preco' name='preco' step='0.01' value='" . htmlspecialchars($produto['preco']) . "' required>";
        echo "<br>";
        echo "<label for='estoque'>Quantidade em Estoque:</label>";
        echo "<input type='number' id='estoque' name='estoque' value='" . htmlspecialchars($produto['estoque']) . "' required>";
        echo "<br>";
        echo "<label for='validade'>Data de Validade:</label>";
        echo "<input type='date' id='validade' name='validade' value='" . htmlspecialchars(date('Y-m-d', strtotime($produto['validade']))) . "' required>";
        echo "<br><br>";
        echo "<button type='submit' class= 'botao1'>Atualizar Produto</button>";
        echo "</form>";

    } else {
        echo "Produto não encontrado.";
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nome'])) {
        // Atualiza o produto no banco de dados
        $id_produto = $_POST['id_produto'];
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $preco = $_POST['preco'];
        $estoque = $_POST['estoque'];
        $validade = $_POST['validade'];

        $update_query = "UPDATE produtos SET nome=?, descricao=?, preco=?, estoque=?, validade=? WHERE id_produtos=?";
        $update_stmt = mysqli_prepare($conexao, $update_query);
        mysqli_stmt_bind_param($update_stmt, 'ssdisi', $nome, $descricao, $preco, $estoque, $validade, $id_produto);

        if (mysqli_stmt_execute($update_stmt)) {
            header("Location: estoque.php");
            exit();
        } else {
            echo "<p>Erro ao atualizar produto: " . mysqli_error($conexao) . "</p>";
        }
        mysqli_stmt_close($update_stmt);
        mysqli_close($conexao);

    }    
?>

