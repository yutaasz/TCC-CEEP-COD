<?php
include_once('config.php');

// consulta, traz dados da tabela
$sql = "SELECT * FROM tb_agendamentos_servicos";
$resultado = $conexao->query($sql);

// Verificando se a consulta teve sucesso
if (!$resultado) {
    die('Erro na consulta: ' . $conexao->error);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Listagem de Agendamentos de Serviços</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery.js"></script>
</head>

<body>
    <h2>
        <center>Listagem de Agendamentos de Serviços</center>
        <a href="add_multival.php" class="btn btn-success">INCLUIR MULTIVALORADA</a>
        <a href="admin.php" class="btn btn-primary">VOLTAR</a>
    </h2>
    <table class="table table-striped table-bordered">
        <tr class="table-dark">
            <th>ID</th>
            <th>Serviço</th>
            <th>Usuário</th>
            <th>Valor</th>
        </tr>
        <?php while ($r = $resultado->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $r['id_agend_serv']; ?></td>
                <td><?php echo $r['fk_serv']; ?></td> <!-- Substitua pelo nome da coluna correspondente à descrição do serviço -->
                <td><?php echo $r['fk_user']; ?></td> <!-- Substitua pelo nome da coluna correspondente ao nome do usuário -->
                <td><?php echo $r['valor']; ?></td>

                <!-- Adicione mais colunas conforme necessário -->

                <td>
                    <!-- Adicione links de alterar/excluir conforme necessário -->
                </td>
            </tr>
        <?php } ?>
    </table>
    <!-- Seus scripts aqui -->
</body>

</html>
