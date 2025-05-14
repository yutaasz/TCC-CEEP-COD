<?php
session_start();
include_once('config.php');

$servico_id = $_GET['id']; // Renomeando a variável

$sql = "SELECT * FROM tb_servicos WHERE id_serv = ?";

$stmc = $conexao->prepare($sql);
$stmc->bind_param('i', $servico_id); // Usando a variável renomeada
$stmc->execute();

$result = $stmc->get_result();
$re = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Alteração de Serviços</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <style>
        body {
            text-align: center;
        }
    </style>

    <script>
        function confirmarAlteracao() {
            return confirm("ATENÇÃO! Deseja realmente alterar? As informações originais serão perdidas e não poderão ser recuperadas.");
        }
    </script>

</head>

<body>
    <h2>Alteração de Serviços</h2>
    <form method="POST" onsubmit="return confirmarAlteracao();">
        <div class="form-group">
            <label for="tipo"></label>Tipo de Serviço<br>
            <input type="text" name="tipo" placeholder="Tipo de Serviço" required value="<?php echo $re['tipo_serv']; ?>"><br>

            <label for="nome">Nome do Serviço</label><br>
            <input type="text" name="nome" placeholder="Nome do Serviço" required value="<?php echo $re['nome_serv']; ?>"><br>

            <label for="valor">Valor</label><br>
            <input type="number" step="0.01" name="valor" placeholder="Valor" required value="<?php echo $re['valor']; ?>"><br>

            <label for="foto">Foto</label><br>
            <input type="text" name="foto" placeholder="Foto" required value="<?php echo $re['foto']; ?>"><br><br>

            <button type="submit" name="btnAlterar" class="btn btn-warning">ALTERAR</button>
        </div>
    </form>
</body>

</html>

<?php
if (isset($_POST['btnAlterar'])) {

    $tipo = $_POST['tipo'];
    $nome = $_POST['nome'];
    $valor = $_POST['valor'];
    $foto = $_POST['foto'];

    if (empty($tipo) || empty($nome) || empty($valor) || empty($foto)) {
        echo "Todos os campos são obrigatórios!";
    } else {
        $sqlup = "UPDATE tb_servicos SET tipo_serv = ?, nome_serv = ?, valor = ?, foto = ? WHERE id_serv = ?";
        $stmup = $conexao->prepare($sqlup);
        $stmup->bind_param('ssdsi', $tipo, $nome, $valor, $foto, $servico_id);

        if ($stmup->execute()) {
            echo "Alterado com sucesso!";
            header("Location: crud_serv.php");
            exit();
        } else {
            echo "Erro ao alterar!";
        }
    }
}
?>