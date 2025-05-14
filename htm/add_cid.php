<?php
include_once('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Processar o formulário de inclusão
    $id_cidade = $_POST['id_cidade'];
    $nome = $_POST['nome'];
    $estado = $_POST['estado'];

    // Execute a inserção no banco de dados
    $sql_inserir = "INSERT INTO tb_cidades (id_cidade, nome, estado) VALUES ('$id_cidade', '$nome', '$estado')";
    
    if ($conexao->query($sql_inserir) === TRUE) {
        header("Location: crud_cid.php");
        exit();
    } else {
        echo "Erro ao incluir cidade: " . $conexao->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Incluir Cidade</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>

<body>
    <h2>
        <center>Incluir Cidade</center>
    </h2>
    <form method="post" action="">
        <div class="form-group">
            <label for="id_cidade">ID da Cidade:</label>
            <input type="text" class="form-control" name="id_cidade" required>
        </div>
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" class="form-control" name="nome" required>
        </div>
        <div class="form-group">
            <label for="estado">Estado (PR):</label>
            <input type="text" class="form-control" name="estado" maxlength="2" required>
        </div>
        <button type="submit" class="btn btn-primary">Incluir Cidade</button>
    </form>
    <!-- Seus scripts aqui -->
</body>
</html>
