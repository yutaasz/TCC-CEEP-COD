<?php
include_once('config.php');

// consulta, traz dados da tabela tb_enderecos
$sql = "SELECT * FROM tb_enderecos";
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
    <title>Listagem de Endereços</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>

<body>
    <h2>
        <center>Listagem de Endereços</center>
        <a href="add_end.php" class="btn btn-success">INCLUIR USUÁRIO</a>
        <a href="admin.php" class="btn btn-primary">VOLTAR</a>
    </h2>
    <table class="table table-striped table-bordered">
        <tr class="table-dark">
            <th>ID</th>
            <th>Rua</th>
            <th>CEP</th>
            <th>Número</th>
            <th>Complemento</th>
            <th>Usuário</th>
            <th>Cidade</th>
        </tr>
        <?php while ($r = $resultado->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $r['id_endereco']; ?></td>
                <td><?php echo $r['rua']; ?></td>
                <td><?php echo $r['cep']; ?></td>
                <td><?php echo $r['numero_casa']; ?></td>
                <td><?php echo $r['complemento']; ?></td>
                <td><?php echo $r['fk_user']; ?></td>
                <td><?php echo $r['fk_cidade']; ?></td>
                <td>
                    <a href="alt_endereco.php?id=<?php echo $r['id_endereco'] ?>" class="btn btn-warning">ALTERAR</a> - 
                    <a href="ex_endereco.php?id=<?php echo $r['id_endereco'] ?>" class="btn btn-danger" onclick="return confirmarExclusao()">EXCLUIR</a>
                </td>
            </tr>
        <?php } ?>
    </table>
    
    <!-- Seus scripts aqui -->
    <script>
        function confirmarExclusao() {
            return confirm("ATENÇÃO! Deseja realmente excluir? As informações serão permanentemente perdidas e não poderão ser recuperadas.");
        }
    </script>
</body>

</html>

