<?php
include_once 'config.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter dados do formulário
    $rua = $_POST['rua'];
    $cep = $_POST['cep'];
    $numero = $_POST['numero'];
    $complemento = $_POST['complemento'];

    // Obter o ID do usuário da sessão
    if (isset($_SESSION['id_usuario'])) {
        $idUsuario = $_SESSION['id_usuario'];

        // Substituir a variável do código da cidade pelo valor fixo (2853)
        $idCidade = 2853;

        // Inserir dados na tabela tb_enderecos usando prepared statement
        $queryEndereco = "INSERT INTO tb_enderecos (rua, cep, numero_casa, complemento, fk_user, fk_cidade) VALUES (?, ?, ?, ?, ?, ?)";
        $stmtEndereco = $conexao->prepare($queryEndereco);
        $stmtEndereco->bind_param("ssssii", $rua, $cep, $numero, $complemento, $idUsuario, $idCidade);

        if ($stmtEndereco->execute()) {
            echo "Dados do endereço foram inseridos com sucesso!";
            header("Location: login.php"); // Redireciona para a página de login após o cadastro bem-sucedido
            exit(); // Termina o script para garantir que o redirecionamento seja feito corretamente
        } else {
            echo "Erro ao inserir os dados na tabela de endereços: " . $stmtEndereco->error;
            // Log the error to a file for debugging purposes
            error_log("Erro ao inserir os dados no banco de dados: " . $stmtEndereco->error);
        }

        $stmtEndereco->close(); // Fechar a declaração após o uso
    } else {
        echo "ID do usuário não encontrado na sessão.";
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
<body>
    <form method="POST" action="cadend.php">
	<div class="fundo-login">
		<div class="login">
			<h1 class="logo"> HiREit</h1>
            <br><br><br>
            <select class="select">
                    <option value="opcao">Paraná</option>
            </select>
            <select name="nome_cidade" class="select">
                <option value="opcao">Cascavel</option>
            </select>
            <input type="hidden" name="id_usuario" value="<?php echo $_SESSION['id_usuario']; ?>">
            <input type="text" name="rua" placeholder="Logradouro" required><br>
            <input type="text" name="cep" placeholder="CEP" required><br>
            <input type="text" name="numero" id="numero" placeholder="Numero" required><br>
            <input type="text" name="complemento" id="complemento" placeholder="Complemento"><br>
            <input class="botao1" value="Cadastrar Cliente" type="submit" name="botao_cliente">
		</div>
	</div>
    </form>
</body>

</html>


