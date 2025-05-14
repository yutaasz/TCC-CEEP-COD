<?php
include_once('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Processar o formulário de inclusão
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $senha = md5($_POST['senha']); // Armazenar a senha com hash (neste caso, usando MD5)
    $tipo = $_POST['tipo'];
    $ativo = $_POST['ativo'];

    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    $telefone = preg_replace('/\D/', '', $telefone); 

    // Criptografar a senha
    $senha = md5($_POST['senha']);

    // Execute a inserção no banco de dados
    $sql_inserir = "INSERT INTO tb_usuarios (nome_user, cpf_user, telefone_user, email_user, senha_user, tipo_user, ativo) 
                    VALUES ('$nome', '$cpf', '$telefone', '$email', '$senha', '$tipo', '$ativo')";
    
    if ($conexao->query($sql_inserir) === TRUE) {
        // Redirecionar para a página add_user.php
        header("Location: crud_user.php");
        exit();
    } else {
        echo "Erro ao incluir usuário: " . $conexao->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Incluir Usuário</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.js"></script>
</head>

<script>
    $(document).ready(function() {
        $('#telefone').inputmask('(99) 99999-9999'); // Aplica a máscara ao campo de telefone
        $('#cpf').inputmask('999.999.999-99'); // Aplica a máscara ao campo de CPF
    });

    document.addEventListener("DOMContentLoaded", function () {
        // Obtém o formulário pelo ID
        const form = document.getElementById("seuFormularioID");

        // Adiciona um evento de envio ao formulário
        form.addEventListener("submit", function (event) {
            // Obtém o valor do campo de CPF
            const cpfField = document.getElementById("cpf");
            const cpfValue = cpfField.value.replace(/\D/g, ""); // Remove não dígitos

            // Verifica se o CPF tem exatamente 11 dígitos
            if (cpfValue.length !== 11) {
                alert("O CPF deve conter exatamente 11 dígitos.");
                event.preventDefault(); // Impede o envio do formulário
            }
        });
    });
</script>

<body>
    <h2>
        <center>Incluir Usuário</center>
    </h2>
    <form method="post" action="" id="seuFormularioID">
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" class="form-control" name="nome" required>
        </div>
        <div class="form-group">
            <label for="cpf">CPF:</label>
            <input type="text" class="form-control" name="cpf" id="cpf" required>
        </div>
        <div class="form-group">
            <label for="telefone">Telefone:</label>
            <input type="text" class="form-control" name="telefone" id="telefone" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="form-group">
            <label for="senha">Senha:</label>
            <input type="password" class="form-control" name="senha" required>
        </div>
        <div class="form-group">
            <label for="tipo">Tipo (A, C ou T):</label>
            <input type="text" class="form-control" name="tipo" maxlength="1" required>
        </div>
        <div class="form-group">
            <label for="ativo">Ativo (S ou N):</label>
            <input type="text" class="form-control" name="ativo" maxlength="1" required>
        </div>
        <button type="submit" class="btn btn-primary" name="submit">Incluir Usuário</button>
    </form>
    <!-- Seus scripts aqui -->
</body>
</html>
