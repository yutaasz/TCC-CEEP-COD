<?php
include_once 'config.php';

function calcularIdade($dataNascimento) {
    $hoje = new DateTime();
    $nascimento = new DateTime($dataNascimento);
    $idade = $hoje->diff($nascimento);
    return $idade->y; // Retorna a idade em anos
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $senha = $_POST['senha'];
    $data_nascimento = $_POST['data_nascimento'];

    // Restante dos campos do formulário

    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    echo "CPF após remoção de pontos e traço: " . $cpf;
    $telefone = preg_replace('/\D/', '', $telefone); 
    echo "TELEFONE após remoção de pontos e traço: " . $telefone;

    // Criptografar a senha
    $senha = md5($_POST['senha']);
    
    // Verificar a idade
    $idade = calcularIdade($data_nascimento);

    if ($idade < 18) {
        echo "Você deve ter pelo menos 18 anos para se cadastrar.";
    } else {
        // Inserir os dados no banco de dados
        $query = "INSERT INTO tb_usuarios (nome_user, email_user, cpf_user, telefone_user, senha_user, data_nascimento) VALUES ('$nome', '$email', '$cpf', '$telefone', '$senha', '$data_nascimento')";
        $resultado = $conexao->query($query);

        if ($resultado) {
            // Armazenar o ID gerado automaticamente na sessão
            $idUsuario = $conexao->insert_id;
            session_start(); // Inicia a sessão (se ainda não estiver iniciada)
            $_SESSION['id_usuario'] = $idUsuario;
        
            if (isset($_POST['botao_cliente'])) {
                // Redirecionar para a página do cliente
                header("Location: cadend.php");
                exit();
            } elseif (isset($_POST['botao_trabalhador'])) {
                // Redirecionar para a página de admin
                header("Location: cadtrab.php");
                exit();
            }
        } else {
            echo "Erro ao inserir os dados no banco de dados.";
        }
    }

    $conexao->close();
}
?>




<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Cadastro HireIt</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
	<style>
        @import url('https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital@0;1&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap');

        @font-face {
            font-family: Alef-Regular;
            src: url(Alef/Alef-Regular.ttf);
        }
		html {
            height: 100%;
        }

        body{
            font-size: 100%;
            background: linear-gradient(225deg, rgba(254, 0, 0, 0.20) 0%, rgba(3, 0, 158, 0.20) 100%);
            height: 100%;
        }

        .logo{
            color: rgb(27, 15, 0);
            font-family: 'Poppins', sans-serif;
            font-size: 100px;
        }

		.login{
			background-color: rgba(0, 0, 0, 0.144);
            position: absolute;
            top: 50%;
            left: 50%; 
            transform: translate(-50%, -50%);
            padding: 60px;
            border-radius: 15px;
		}
        input{
            padding: 15px;
            border: none;
            outline: none;
            font-size: 15px;
            color: rgb(27, 15, 0);
            font-family: 'Poppins', sans-serif;
            width: 100%;
            background-color: transparent;
            font-size: 25px;
        }
        .botao1{
            background-color: transparent;
            padding: 15px;
            border: none;
            outline: none;
            color: rgb(27, 15, 0);
            font-family: 'Poppins', sans-serif;
            width: 50%;
            font-size: 25px;
        }
        .botao2{
            background-color: transparent;
            padding: 15px;
            border: none;
            outline: none;
            color: rgb(27, 15, 0);
            font-family: 'Poppins', sans-serif;
            width: 50%;
            font-size: 25px;
        }

	</style>
 
</head>
<script>
$(document).ready(function() {
    $('#telefone').inputmask('(99) 99999-9999'); // Aplica a máscara ao campo de telefone
});
$(document).ready(function() {
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
    
<form method="POST" action="cadastro.php" id="seuFormularioID"> 
	<div class="fundo-login">
		<div class="login">
			<h1 class="logo"> HiREit</h1>
            <br><br><br>
            <input type="text" name="nome" placeholder="Nome" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="text" name="cpf" id="cpf" placeholder="CPF" required><br>
            <input type="text" name="telefone" id="telefone" placeholder="Telefone" required><br>
            <input type="date" name="data_nascimento" placeholder="Data de Nascimento" required><br>
            <input type="password" name="senha" placeholder="Senha" required><br>
            <input class="botao1" value="Cliente" type="submit" name="botao_cliente"><input class="botao2" value="Trabalhador" type="submit" name="botao_trabalhador">
            <input type="button" class="botao3" value="Login" name="botao_cliente" onclick="voltarParaLogin()">
            <script>
        function voltarParaLogin() {
            // Redireciona para a página de login.php
            window.location.href = 'login.php';
        }
    </script>
		</div>
	</div>
    </form>
</body>

</html>


