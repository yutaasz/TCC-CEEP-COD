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
    $fk_serv = $_POST['fk_serv'];
    $fk_user = $_POST['fk_user'];
    $valor = $_POST['valor'];

    // Execute a inserção no banco de dados
    $sql_inserir = "INSERT INTO tb_agendamentos_servicos (fk_serv, fk_user, valor) 
                    VALUES ('$fk_serv', '$fk_user', '$valor')";
    
    if ($conexao->query($sql_inserir) === TRUE) {
        header("Location: crud_multival.php"); // Redirecione para a página desejada após a inserção bem-sucedida
        exit();
    } else {
        echo "Erro ao incluir agendamento de serviço: " . $conexao->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Incluir Agendamento de Serviço</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
</head>

<body>

<script>
    $(document).ready(function(){
        $('#valor').mask('R$ 0.000,00', {reverse: true});
    });
</script>

<h2>
    <center>Incluir Agendamento de Serviço</center>
</h2>
<form method="post" action="">
    <div class="form-group">
        <label for="fk_serv">Serviço:</label>
        <select class="form-control" name="fk_serv" required>
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
    <div class="form-group">
        <label for="valor">Valor:</label>
        <input type="text" class="form-control" name="valor" id="valor" required>
    </div>
    <button type="submit" class="btn btn-primary">Incluir Agendamento de Serviço</button>
</form>
<!-- Seus scripts aqui -->
</body>
</html>
