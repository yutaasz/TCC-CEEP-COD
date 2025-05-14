<?php
include_once('config.php');

// consulta, traz dados da tabela tb_horarios
$sql = "SELECT * FROM tb_horarios";
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
    <title>Listagem de Horários</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery.js"></script>
    <script>
        function confirmarExclusao() {
            return confirm("ATENÇÃO! Deseja realmente excluir? As informações serão permanentemente perdidas e não poderão ser recuperadas.");
        }
    </script>
</head>

<body>
    <h2>
        <center>Listagem de Horários</center>
        <a href="add_hora.php" class="btn btn-success">INCLUIR HORA</a>
        <a href="admin.php" class="btn btn-primary">VOLTAR</a>
    </h2>
    <table class="table table-striped table-bordered">
        <tr class="table-dark">

            <th>ID</th>

            <th>Dia da Semana</th>

            <th>Entrada Manhã</th>

            <th>Saída Manhã</th>

            <th>Entrada Tarde</th>

            <th>Saída Tarde</th>
            
            <th>Código do Usuário</th>

        </tr>
        <?php while ($r = $resultado->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $r['id_horario']; ?></td>

                <td><?php echo $r['dia_semana']; ?></td>

                <td><?php echo $r['entrada_manha']; ?></td>

                <td><?php echo $r['saida_manha']; ?></td>

                <td><?php echo $r['entrada_tarde']; ?></td>

                <td><?php echo $r['saida_tarde']; ?></td>
                
                <td><?php echo $r['fk_user']; ?></td>

                <td>
                    <a href="alt_hora.php?id=<?php echo $r['id_horario'] ?>" class="btn btn-warning">ALTERAR</a> - 
                    <a href="ex_hora.php?id=<?php echo $r['id_horario'] ?>" class="btn btn-danger" onclick="return confirmarExclusao();">EXCLUIR</a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <!-- Seus scripts aqui -->
</body>

</html>
