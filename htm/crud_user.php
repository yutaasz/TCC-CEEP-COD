<?php
include_once('config.php');

// consulta, traz dados da tabela
$sql = "SELECT * FROM tb_usuarios";
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
    <title>Listagem de Usuarios</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery.js"></script>
</head>

<body>
    <h2>
        <center>Listagem de Usuarios</center>
        <a href="add_user.php" class="btn btn-success">INCLUIR USUÁRIO</a>
        <a href="admin.php" class="btn btn-primary">VOLTAR</a>
    </h2>
    <table class="table table-striped table-bordered">
        <tr class="table-dark">
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>CPF</th>
            <th>Telefone</th>
            <th>Senha</th>
            <th>Tipo</th>
            <th>Ativo</th>
            <th>Ações</th>
        </tr>
        <?php while ($r = $resultado->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $r['id_user']; ?></td>
                <td><?php echo $r['nome_user']; ?></td>
                <td><?php echo $r['email_user']; ?></td>
                <td><?php echo $r['cpf_user']; ?></td>
                <td><?php echo $r['telefone_user']; ?></td>
                <td><?php echo $r['senha_user']; ?></td>
                <td><?php echo $r['tipo_user']; ?></td>
                <td><?php echo $r['ativo']; ?></td>
                <td>
                    <a href="alt_user.php?id=<?php echo $r['id_user'] ?>" class="btn btn-warning">ALTERAR</a>
                    -
                    <a href="ex_user.php?id=<?php echo $r['id_user'] ?>" class="btn btn-danger" onclick="return confirm('ATENÇÃO! Deseja realmente excluir? As informações serão permanentemente perdidas e não poderão ser recuperadas.')" class="btn btn-warning">EXCLUIR</button>
        </div>
                </td>
            </tr>
        <?php } ?>
    </table>
    <!-- Seus scripts aqui -->
</body>

</html>