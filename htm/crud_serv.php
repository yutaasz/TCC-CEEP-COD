<?php
include_once('config.php');

// consulta, traz dados da tabela
$sql = "SELECT * FROM tb_servicos";
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
    <title>Listagem de Serviços</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery.js"></script>
</head>

<body>
    <h2>
        <center>Listagem de Serviços</center>
        <a href="add_serv.php" class="btn btn-success">INCLUIR TRABALHADOR</a>
        <a href="admin.php" class="btn btn-primary">VOLTAR</a>
    </h2>
    <table class="table table-striped table-bordered">
        <tr class="table-dark">
            <th>ID</th>
            <th>Tipo de Serviço</th>
            <th>Nome do Serviço</th>
            <th>Valor</th>
            <th>Foto</th>
            <th>Usuário</th>
        </tr>
        <?php while ($r = $resultado->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $r['id_serv']; ?></td>
                <td><?php echo $r['tipo_serv']; ?></td>
                <td><?php echo $r['nome_serv']; ?></td>
                <td><?php echo 'R$ ' . number_format($r['valor'], 2, ',', '.'); ?></td>
                <td><?php echo $r['foto']; ?></td>
                <td><?php echo $r['fk_user']; ?></td>
                <td><a href="alt_serv.php?id=<?php echo $r['id_serv'] ?>" class="btn btn-warning">ALTERAR</a> - <a href="ex_serv.php?id=<?php echo $r['id_serv'] ?>" class="btn btn-danger">EXCLUIR</a> </td>
            </tr>
        <?php } ?>
    </table>
    <!-- Seus scripts aqui -->
</body>

</html>
