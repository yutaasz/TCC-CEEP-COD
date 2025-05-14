<?php
session_start();
include_once('config.php');

$horario_id = $_GET['id']; // Renomeando a variável

$sql = "SELECT * FROM tb_horarios WHERE id_horario = ?";

$stmc = $conexao->prepare($sql);
$stmc->bind_param('i', $horario_id); // Usando a variável renomeada
$stmc->execute();

$result = $stmc->get_result();
$re = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Alteração de Horários</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <style>
        body {
            text-align: center;
        }
    </style>

    <script>
        function confirmarAlteracao() {
            return confirm("ATENÇÃO! Deseja realmente alterar? As informações originais serão permanentemente perdidas e não poderão ser recuperadas.");
        }
    </script>

</head>

<body>
    <h2>Alteração de Horários</h2>
    <form method="POST" onsubmit="return confirmarAlteracao();">
        <div class="form-group">

            <label for="dia_semana">Dia da Semana</label><br>
            <input type="text" name="dia_semana" placeholder="Dia da Semana" required value="<?php echo $re['dia_semana']; ?>"><br>

            <label for="entrada_manha">Entrada Manhã</label><br>
            <input type="time" name="entrada_manha" placeholder="Entrada Manhã" required value="<?php echo $re['entrada_manha']; ?>"><br>

            <label for="saida_manha">Saída Manhã</label><br>
            <input type="time" name="saida_manha" placeholder="Saída Manhã" required value="<?php echo $re['saida_manha']; ?>"><br>

            <label for="entrada_tarde">Entrada Tarde</label><br>
            <input type="time" name="entrada_tarde" placeholder="Entrada Tarde" required value="<?php echo $re['entrada_tarde']; ?>"><br>

            <label for="saida_tarde">Saída Tarde</label><br>
            <input type="time" name="saida_tarde" placeholder="Saída Tarde" required value="<?php echo $re['saida_tarde']; ?>"><br><br>

            <button type="submit" name="btnAlterar" class="btn btn-warning">ALTERAR</button>
        </div>
    </form>
</body>

</html>

<?php
if (isset($_POST['btnAlterar'])) {

    $entrada_manha = $_POST['entrada_manha'];
    $entrada_tarde = $_POST['entrada_tarde'];
    $saida_tarde = $_POST['saida_tarde'];
    $dia_semana = $_POST['dia_semana'];
    $saida_manha = $_POST['saida_manha'];

    if (empty($entrada_manha) || empty($entrada_tarde) || empty($saida_tarde) || empty($dia_semana) || empty($saida_manha)) {
        echo "Todos os campos são obrigatórios!";
    } else {
        $sqlup = "UPDATE tb_horarios SET entrada_manha = ?, entrada_tarde = ?, saida_tarde = ?, dia_semana = ?, saida_manha = ? WHERE id_horario = ?";
        $stmup = $conexao->prepare($sqlup);
        $stmup->bind_param('sssssi', $entrada_manha, $entrada_tarde, $saida_tarde, $dia_semana, $saida_manha, $horario_id);

        if ($stmup->execute()) {
            echo "Alterado com sucesso!";
            header("Location: crud_hora.php"); // Substitua 'crud_horarios.php' pelo arquivo apropriado para redirecionamento.
            exit();
        } else {
            echo "Erro ao alterar!";
        }
    }
}
?>
