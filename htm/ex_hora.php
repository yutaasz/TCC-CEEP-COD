<?php
include_once('config.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Criar a consulta SQL para exclusão
    $sql = "DELETE FROM tb_horarios WHERE id_horario = ?";
    
    // Preparar a consulta
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('i', $id);

    // Executar a consulta
    if ($stmt->execute()) {
        header("Location: crud_hora.php"); // Substitua 'crud_horarios.php' pelo arquivo apropriado para redirecionamento.
        exit(); // Encerrar o script após redirecionar
    } else {
        echo "Erro ao excluir o registro.";
    }
} else {
    echo "ID de registro não fornecido.";
}
?>
