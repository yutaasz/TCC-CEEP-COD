<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'bd_vitorh';

// Cria a conexão
$conexao = new mysqli($host, $user, $password, $database);

// Verifica a conexão
if ($conexao->connect_error) {
    die("Erro de conexão: " . $conexao->connect_error);
}

?>
