<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    

    require 'conexao.php';

    $query = "DELETE FROM produtos WHERE id_produtos = ?";
    $stmt = mysqli_prepare($conexao, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);

    if (mysqli_stmt_execute($stmt)) {
       header("Location: estoque.php"); 
        die;
    } else {
        echo "<p>Erro ao excluir produto: " . mysqli_error($conexao) . "</p>";
    }
} 

?>