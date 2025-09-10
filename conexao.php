<?php
$host = 'localhost';
$usuario = 'root';
$senha = '';
$nome_banco = 'supermercado';
$conexao = mysqli_connect($host, $usuario, $senha, $nome_banco);

// Verifica se a conexão foi bem-sucedida
$conn = mysqli_connect($host, $usuario, $senha, $nome_banco);

if (mysqli_connect_errno()) {
    die("Falha na conexão: " . mysqli_connect_error());
}
?>