<?php
include_once('config.php');

// Consulta para obter todos os serviços
$sql_servicos = "SELECT id_serv, nome_serv FROM tb_servicos";
$result_servicos = $conexao->query($sql_servicos);

// Consulta para obter todos os usuários
$sql_usuarios = "SELECT id_user, nome_user FROM tb_usuarios";
$result_usuarios = $conexao->query($sql_usuarios);

// Processar o formulário de inclusão
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST['data'];
    $hr_inicio = $_POST['hr_inicio'];
    $tipo_pagamento = $_POST['tipo_pagamento'];
    $fk_agend_serv = $_POST['fk_agend_serv'];
    $fk_user = $_POST['fk_user'];

    // Execute a inserção no banco de dados
    $sql_inserir = "INSERT INTO tb_agendas (data, hr_inicio, tipo_pagamento, fk_agend_serv, fk_user) 
                    VALUES ('$data', '$hr_inicio', '$tipo_pagamento', '$fk_agend_serv', '$fk_user')";
    
    if ($conexao->query($sql_inserir) === TRUE) {
        header("Location: crud_agenda.php"); // Redirecione para a página desejada após a inserção bem-sucedida
        exit();
    } else {
        echo "Erro ao incluir agendamento: " . $conexao->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Incluir Agendamento</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>

<body>

<h2>
    <center>Incluir Agendamento</center>
</h2>
<form method="post" action="">
    <div class="form-group">
        <label for="data">Data:</label>
        <input type="date" class="form-control" name="data" required>
    </div>
    <div class="form-group">
        <label for="hr_inicio">Hora de Início:</label>
        <input type="time" class="form-control" name="hr_inicio" required>
    </div>
    <div class="form-group">
        <label for="tipo_pagamento">Tipo de Pagamento:</label>
        <select class="form-control" name="tipo_pagamento" required>
            <option value="D">Dinheiro</option>
            <option value="P">Pix</option>
        </select>
    </div>
    <div class="form-group">
        <label for="fk_agend_serv">Serviço:</label>
        <select class="form-control" name="fk_agend_serv" required>
            <?php
            // Exibir opções para cada serviço
            while ($row = $result_servicos->fetch_assoc()) {
                echo "<option value='" . $row['id_serv'] . "'>" . $row['nome_serv'] . "</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="fk_user">Usuário:</label>
        <select class="form-control" name="fk_user" required>
            <?php
            // Exibir opções para cada usuário
            while ($row = $result_usuarios->fetch_assoc()) {
                echo "<option value='" . $row['id_user'] . "'>" . $row['nome_user'] . "</option>";
            }
            ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Incluir Agendamento</button>
</form>
<!-- Seus scripts aqui -->
</body>
</html>
