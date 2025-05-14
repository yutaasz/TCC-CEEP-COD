<?php
session_start();
include_once('config.php');

$usuario_id = $_GET['id']; // Renomeando a variável

$sql = "SELECT * FROM tb_cidades WHERE id_cidade = ?";

$stmc = $conexao->prepare($sql);
$stmc->bind_param('i', $usuario_id); // Usando a variável renomeada
$stmc->execute();

$result = $stmc->get_result();
$re = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Alteração de Cidade</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <style>
        body {
            text-align: center;
        }
    </style>

    <script>
        function confirmarAlteracao() {
            return confirm("ATENÇÃO! Deseja realmente alterar? As informações originais serão perdidas e não poderão ser recuperadas");
        }
    </script>
    
</head>

<body>
    <h2>Alteração de Cidade</h2>
    <form method="POST" onsubmit="return confirmarAlteracao();">
        <div class="form-group">

            <label for="nome">Cidade</label><br>
            <input type="text" name="nome" placeholder="Cidade" required value="<?php echo $re['nome']; ?>"><br>

            <label for="estado">Estado</label><br>
            <input type="text" name="estado" placeholder="Estado" required value="<?php echo $re['estado']; ?>"><br><br>

            <button type="submit" name="btnAlterar" class="btn btn-warning">ALTERAR</button>
        </div>
    </form>
</body>

</html>

<?php
if (isset($_POST['btnAlterar'])) {

    $nome = $_POST['nome'];
    $estado = $_POST['estado'];

    if (empty($nome) || empty($estado)) {
        echo "Todos os campos são obrigatórios!";
    } else {
        $sqlup = "UPDATE tb_cidades SET nome = ?, estado = ? WHERE id_cidade = ?";
        $stmup = $conexao->prepare($sqlup);
        $stmup->bind_param('ssi', $nome, $estado, $usuario_id); // Usando a variável renomeada

        if ($stmup->execute()) {
            echo "Alterado com sucesso!";
            header("Location: crud_cid.php");
            exit(); // Importante: Encerrar o script após redirecionar
        } else {
            echo "Erro ao alterar!";
        }
    }
}
?>