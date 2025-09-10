<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastre Seus Produtos</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <a href="index.php"><img src="imagens/logo.png" alt="logo" class="logo"></a>
    <h1>Cadastre seus Produtos</h1>
    
    
        <nav>
            <div>
                <ul>
                    <li><a href="index.php">Pagina Principal</a></li>
                    <li><a href="estoque.php">Estoque</a></li>
                </ul>
            </div>
        </nav>
    
    
    
    <form action="cadastro.php" method="post">
        <p>Preencha os campos abaixo para cadastrar um novo produto:</p>

        <label for="id">ID do Produto:</label>
        <input type="number" id="id_produtos" name="id_produtos" required placeholder="Ex: 1, 2, 3, etc.">
        <br>
        <label for="nome">Nome do Produto:</label>
        <input type="text" id="nome" name="nome" required placeholder="Ex: Arroz, Feijão, etc.">
        <br>
        <label for="descricao">Descrição do Produto</label>
        <input type="text" id="descricao" name="descricao" required placeholder="Ex: Produto de limpeza, Alimento, etc.">
        <br>
        <label for="preco">Preço:</label>
        <input type="number" id="preco" name="preco" step="0.01" required placeholder="Ex: 10.99.">
        <br>
        <label for="quantidade">Quantidade em Estoque:</label>
        <input type="number" id="quantidade" name="quantidade" required placeholder="Ex: 50">
        <br>
        <label for="validade">Data de Vencimento?</label>
        <input type="date" id="validade" name="validade" required>
        <br>
        <br>
        <button type="submit" class="botao1">Cadastrar</button>
    </form>
    
</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'conexao.php'; 

    $id = $_POST['id_produtos'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];
    $validade = $_POST['validade'];
    // Formatação da data de validade
    $validade = date('Y-m-d', strtotime($validade)); // Formato para o banco de dados (YYYY-MM-DD)

    // Verifica se o ID já existe
    $verificaId = "SELECT id_produtos FROM produtos WHERE id_produtos = ?";
    $verificaId_stmt = mysqli_prepare($conn, $verificaId);
    mysqli_stmt_bind_param($verificaId_stmt, 'i', $id);
    mysqli_stmt_execute($verificaId_stmt);
    $result = mysqli_stmt_get_result($verificaId_stmt);
    if (mysqli_num_rows($result) > 0) {
        echo "<p>Erro: O ID do produto já existe. Por favor, escolha outro ID.</p>";
        exit();
    } else {
    $sql = "INSERT INTO produtos (id_produtos, nome, descricao, preco, estoque, validade) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    $stmt->bind_param("issdis", $id, $nome,  $descricao, $preco, $quantidade, $validade);
    if (mysqli_stmt_execute($stmt)) {
        header('Location: estoque.php');
        exit();
    } else {
        echo "<p>Erro ao cadastrar produto: " . mysqli_error($conn) . "</p>";
    }    
}
}
?>

