<?php
include_once('config.php');

// consulta, traz dados da tabela
$sql = "SELECT * FROM tb_agendas";
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
    <title>Listagem de Agendas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery.js"></script>
</head>

<body>
    <h2>
        <center>Listagem de Agendas</center>
        <a href="add_agenda.php" class="btn btn-success">INCLUIR AGENDA</a>
        <a href="admin.php" class="btn btn-primary">VOLTAR</a>
    </h2>
    <table class="table table-striped table-bordered">
        <tr class="table-dark">
            <th>ID Agendamento</th>
            <th>Data</th>
            <th>Hora de Início</th>
            <th>Tipo de Pagamento</th>
            <th>ID Serviço</th>
            <th>Ações</th>
        </tr>
        <?php while ($r = $resultado->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $r['id_agendamento']; ?></td>
                <td><?php echo date('d/m/Y', strtotime($r['data'])); ?></td>
                <td><?php echo $r['hr_inicio']; ?></td>
                <td><?php echo $r['tipo_pagamento']; ?></td>
                <td><?php echo $r['fk_agend_serv']; ?></td>
                <!-- Add other columns as needed -->
                <td>
                    <a href="alt_agenda.php?id=<?php echo $r['id_agendamento'] ?>" class="btn btn-warning">ALTERAR</a>
                    -
                    <a href="ex_agenda.php?id=<?php echo $r['id_agendamento'] ?>" class="btn btn-danger" onclick="return confirm('ATENÇÃO! Deseja realmente excluir? As informações serão permanentemente perdidas e não poderão ser recuperadas.')" class="btn btn-warning">EXCLUIR</a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <!-- Seus scripts aqui -->
</body>

</html>
