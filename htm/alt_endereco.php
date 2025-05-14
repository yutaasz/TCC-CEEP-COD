<?php
session_start();
include_once('config.php');

$endereco_id = $_GET['id']; // Renomeando a variável

$sql = "SELECT * FROM tb_enderecos WHERE id_endereco = ?";

$stmc = $conexao->prepare($sql);
$stmc->bind_param('i', $endereco_id); // Usando a variável renomeada
$stmc->execute();

$result = $stmc->get_result();
$re = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Alteração de Endereços</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <style>
        body {
            text-align: center;
        }
    </style>
    <!-- Adicionando script JavaScript -->
    <script>
        function confirmarAlteracao() {
            return confirm("ATENÇÃO! Deseja realmente alterar? As informações originais serão permanentemente perdidas e não poderão ser recuperadas.");
        }
    </script>
</head>

<body>
    <h2>Alteração de Endereços</h2>
    <form method="POST" onsubmit="return confirmarAlteracao();"> <!-- Adicionando o script ao formulário -->
        <div class="form-group">

            <label for="rua">Logradouro</label><br>
            <input type="text" name="rua" placeholder="Rua" required value="<?php echo $re['rua']; ?>"><br>

            <label for="cep">CEP</label><br>
            <input type="text" name="cep" placeholder="CEP" required value="<?php echo $re['cep']; ?>"><br>

            <label for="numero_casa">Número</label><br>
            <input type="text" name="numero_casa" placeholder="Número" required value="<?php echo $re['numero_casa']; ?>"><br>

            <label for="complemento">Complemento</label><br>
            <input type="text" name="complemento" placeholder="Complemento" required value="<?php echo $re['complemento']; ?>"><br>

            <label for="fk_user">ID do Usuário</label><br>
            <input type="text" name="fk_user" placeholder="ID do Usuário" required value="<?php echo $re['fk_user']; ?>"><br>

            <label for="fk_cidade">ID da Cidade</label><br>
            <input type="text" name="fk_cidade" placeholder="ID da Cidade" required value="<?php echo $re['fk_cidade']; ?>"><br><br>

            <button type="submit" name="btnAlterar" class="btn btn-warning">ALTERAR</button>
        </div>
    </form>
</body>

</html>

<?php
if (isset($_POST['btnAlterar'])) {

    $rua = $_POST['rua'];
    $cep = $_POST['cep'];
    $numero_casa = $_POST['numero_casa'];
    $complemento = $_POST['complemento'];
    $fk_user = $_POST['fk_user'];
    $fk_cidade = $_POST['fk_cidade'];

    if (empty($rua) || empty($cep) || empty($numero_casa) || empty($complemento) || empty($fk_user) || empty($fk_cidade)) {
        echo "Todos os campos são obrigatórios!";
    } else {
        $sqlup = "UPDATE tb_enderecos SET rua = ?, cep = ?, numero_casa = ?, complemento = ?, fk_user = ?, fk_cidade = ? WHERE id_endereco = ?";
        $stmup = $conexao->prepare($sqlup);
        $stmup->bind_param('ssssiii', $rua, $cep, $numero_casa, $complemento, $fk_user, $fk_cidade, $endereco_id);

        if ($stmup->execute()) {
            echo "Alterado com sucesso!";
            header("Location: crud_endereco.php"); // Substitua 'crud_enderecos.php' pelo arquivo apropriado para redirecionamento.
            exit();
        } else {
            echo "Erro ao alterar!";
        }
    }
}
?>
