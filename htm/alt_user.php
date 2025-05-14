<?php
session_start();
include_once('config.php');

$usuario_id = $_GET['id']; // Renomeando a variável

$sql = "SELECT * FROM tb_usuarios WHERE id_user = ?";

$stmc = $conexao->prepare($sql);
$stmc->bind_param('i', $usuario_id); // Usando a variável renomeada
$stmc->execute();

$result = $stmc->get_result();
$re = $result->fetch_assoc();

if (isset($_POST['btnAlterar'])) {

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $tipo = $_POST['tipo'];
    $ativo = $_POST['ativo'];

    if (empty($nome) || empty($email) || empty($cpf) || empty($telefone) || empty($tipo) || empty($ativo)) {
        echo "Todos os campos são obrigatórios!";
    } else {
        $sqlup = "UPDATE tb_usuarios SET nome_user = ?, email_user = ?, cpf_user = ?, telefone_user = ?, tipo_user = ?, ativo = ? WHERE id_user = ?";
        $stmup = $conexao->prepare($sqlup);
        $stmup->bind_param('ssssssi', $nome, $email, $cpf, $telefone, $tipo, $ativo, $usuario_id);

        if ($stmup->execute()) {
            echo "Alterado com sucesso!";
            header("Location: CRUD_user.php");
            exit();
        } else {
            echo "Erro ao alterar!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Alteração de Usuários</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <style>
        body {
            text-align: center;
        }
    </style>
</head>

<body>
    <h2>Alteração de Usuários</h2>
    <form method="POST">
        <div class="form-group">

            <label for="nome">Nome</label><br>
            <input type="text" name="nome" placeholder="Nome" required value="<?php echo $re['nome_user']; ?>"><br>

            <label for="email">Email</label><br>
            <input type="text" name="email" placeholder="Email" required value="<?php echo $re['email_user']; ?>"><br>

            <label for="cpf">CPF</label><br>
            <input type="text" name="cpf" placeholder="CPF" required value="<?php echo $re['cpf_user']; ?>"><br>

            <label for="telefone">Telefone</label><br>
            <input type="text" name="telefone" placeholder="Telefone" required value="<?php echo $re['telefone_user']; ?>"><br>

            <label for="tipo">Tipo de Usuário</label><br>
            <input type="text" name="tipo" placeholder="Tipo" required value="<?php echo $re['tipo_user']; ?>"><br>

            <label for="ativo">Usuário ativo?</label><br>
            <input type="text" name="ativo" placeholder="Ativo" required value="<?php echo $re['ativo']; ?>"><br><br>

            <button type="submit" name="btnAlterar" onclick="return confirm('ATENÇÃO! Deseja realmente alterar? As informações originais serão permanentemente perdidas e não poderão ser recuperadas.')" class="btn btn-warning">ALTERAR</button>
        </div>
    </form>
</body>

</html>