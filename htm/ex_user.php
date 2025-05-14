<?php
include_once('config.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Verificar se o ID é um número inteiro
    if (!ctype_digit($id)) {
        echo "ID inválido.";
        exit();
    }

    // Criar a consulta SQL para exclusão
    $sql = "DELETE FROM tb_usuarios WHERE id_user = ?";
    
    // Preparar a consulta
    $stmt = $conexao->prepare($sql);

    // Verificar se a preparação foi bem-sucedida
    if (!$stmt) {
        echo "Erro na preparação da consulta: " . $conexao->error;
        exit();
    }

    // Vincular o parâmetro ID
    $stmt->bind_param('i', $id);

    // Executar a consulta
    if ($stmt->execute()) {
        header("Location: CRUD_user.php");
        exit(); // Encerrar o script após redirecionar
    } else {
        echo "Erro ao excluir o registro: " . $stmt->error;
    }

    // Fechar a declaração
    $stmt->close();
} else {
    echo "ID de registro não fornecido.";
}
?>