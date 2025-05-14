<?php
include_once('config.php');

// consulta, traz dados da tabela
$sql = "SELECT * FROM tb_cidades";
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
    <title>Listagem de Cidades</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery.js"></script>
</head>

<body>
    <h2>
        <center>Listagem de Cidades</center>
        <a href="add_cid.php" class="btn btn-success">INCLUIR CIDADE</a>
        <a href="admin.php" class="btn btn-primary">VOLTAR</a>
    </h2>
    <table class="table table-striped table-bordered">
        <tr class="table-dark">
            <th>ID</th>
            <th>Nome</th>
            <th>Estado</th>
        </tr>
        <?php while ($r = $resultado->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $r['id_cidade']; ?></td>
                <td><?php echo $r['nome']; ?></td>
                <td><?php echo $r['estado']; ?></td>

                <td><a href="alt_cid.php?id=<?php echo $r['id_cidade'] ?>" class="btn btn-warning">ALTERAR</a> - <a href="ex_cidade.php?id=<?php echo $r['id_cidade'] ?>" class="btn btn-danger">EXCLUIR</a> </td>
            </tr>
        <?php } ?>
    </table>
    <!-- Seus scripts aqui -->
</body>

</html>