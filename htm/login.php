<?php
session_start();
include 'config.php';

if (isset($_SESSION["id_user"])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter dados do formulário
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Consulta SQL para verificar o usuário
    $sql = "SELECT id_user, senha_user, tipo_user FROM tb_usuarios WHERE email_user = '$email'";
    $result = $conexao->query($sql);

    // Verificar se a consulta retornou algum resultado
    if ($result->num_rows == 1) {
        // Obter informações do usuário do resultado da consulta
        $row = $result->fetch_assoc();
        $id_user = $row["id_user"];
        $senhaHash = $row["senha_user"];
        $tipo_user = $row["tipo_user"];

        // Verificar a senha usando md5
        if (md5($senha) === $senhaHash) {
            // Login bem-sucedido, armazenar o código do cliente na sessão
            $_SESSION["id_user"] = $id_user;

            if ($tipo_user === "A") {
                header("Location: admin.php"); // Redirecionar para a página de administrador
                exit();
            } else {
                header("Location: index.php"); // Redirecionar para a página padrão
                exit();
            }
        } else {
            // Login falhou
            $error_message = "Usuário ou senha incorretos!";
        }
    } else {
        // Login falhou
        $error_message = "Usuário ou senha incorretos!";
    }

    // Fechar conexão
    $conexao->close();
}
?>



 <!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Agendamentos Online</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
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

        .fundo{
            width: 100%;
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
            font-family: 'Poppins', sans-serif;
            width: 100%;
            background-color: transparent;
            color: rgb(27, 15, 0);
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
        }
        .botao2{
            background-color: transparent;
            padding: 15px;
            border: none;
            outline: none;
            color: rgb(27, 15, 0);
            font-family: 'Poppins', sans-serif;
            width: 50%;
        }

	</style>
</head>
<body>
    
	<div class="fundo-login">
		<div class="login">
			<h1 class="logo"> HiREit</h1>
            <br><br><br>

                <form method="post" action="login.php">
                <label for="login">E-mail:</label><input type="email" id="email" name="email" required><br>
                <br><br>
                <label for="senha">Senha:</label><input type="password" id="senha" name="senha" required><br>
                <br><br>
                <button class="botao2" onclick="location.href='login.php'">Esqueci a Senha</button>
                <button class="botao1" type="submit" value="entrar" id="entrar" name="entrar">Logar</button><button class="botao2" onclick="location.href='cadastro.php'">Cadastrar</button>
                </form>

                <?php
                // Exemplo de exibição da mensagem de erro ou sucesso
                if (isset($error_message)) {
                    echo '<div class="erro">' . $error_message . '</div>';
                }
                // Exemplo de exibição da mensagem de sucesso
                if (isset($_SESSION['login_success']) && $_SESSION['login_success'] === true) {
                    echo '<div class="sucesso">Login efetuado com sucesso!</div>';
                    // Após exibir a mensagem, limpe a variável de sessão para que ela não seja exibida novamente em futuras recargas da página
                    unset($_SESSION['login_success']);
                }
                ?>


		</div>
	</div>
</body>
</html>