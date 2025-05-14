<?php
session_start();
include 'config.php';

// Verifica se o ID do usuário foi passado via URL
if (!isset($_GET['id_user'])) {
    header("Location: index.php"); // Redireciona para a página de login se o ID do usuário não foi fornecido
    exit();
}

// Obtém o ID do usuário da variável de consulta
$idUsuario = $_GET['id_user'];

// Obtém informações do usuário e seus serviços do banco de dados usando o ID fornecido
$sql = "SELECT u.*, s.* FROM tb_usuarios u
        LEFT JOIN tb_servicos s ON u.id_user = s.fk_user
        WHERE u.id_user = $idUsuario";

$resultado = mysqli_query($conexao, $sql);

// Verifica se a consulta foi bem-sucedida e se o usuário está logado
if ($resultado && mysqli_num_rows($resultado) > 0) {
    $usuario = mysqli_fetch_assoc($resultado);

    // Exibe informações do usuário
    $nome = $usuario['nome_user'];
    $cpf = $usuario['cpf_user'];
    $telefone = $usuario['telefone_user'];
    $email = $usuario['email_user'];
    // Adicione outras informações do usuário conforme necessário

    // Exibe informações dos serviços que o usuário oferece
    while ($row = mysqli_fetch_assoc($resultado)) {
        $tipoServico = $row['tipo_serv'];
        $nomeServico = $row['nome_serv'];
        $valorServico = $row['valor'];
        $fotoServico = $row['foto'];
        // Adicione o código para exibir as informações do serviço
    }
} else {
    header("Location: index.php"); // Redireciona para a página de login se o usuário não foi encontrado
    exit();
}

mysqli_close($conexao);
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - HiREit</title>
    <style>

        @import url('https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital@0;1&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap');

        body{

            font-size: 100%;
            background: linear-gradient(225deg, rgba(254, 0, 0, 0.20) 0%, rgba(3, 0, 158, 0.20) 100%);
            height: 100%;

        }

        .profile{

            background-color: rgba(0, 0, 0, 0.144);
            position: absolute;
            top: 50%;
            left: 50%; 
            transform: translate(-50%, -50%);
            padding: 60px;
            border-radius: 15px;

        }

        .profile-hireit{
            font-size: 100px;
            font-family:'Poppins', sans-serif;
        }

        .a{

            font-size: 30px;
            font-family:'Poppins', sans-serif;
        
        }

        .botao1{
            background-color: transparent;
            padding: 30px;
            border: none;
            outline: none;
            color: rgb(27, 15, 0);
            font-family: 'Poppins', sans-serif;
            width: 50%;
            font-size: 25px
        }

    </style>
</head>
<body>
    <div class="profile-fundo">
        <div class="profile">
            <a class="profile-hireit">HiREit</a>
            <br>
            <a class="a">Nome: <?php echo $usuario['nome_user']; ?></a>
            <br>
            <a class="a">CPF: <?php echo $usuario['cpf_user']; ?></a>
            <br>
            <a class="a">Telefone: <?php echo $usuario['telefone_user']; ?></a>
            <br>
            <a class="a">Email: <?php echo $usuario['email_user']; ?></a>
            <br>

            <!-- Adicione código para exibir informações do serviço aqui -->
            <?php
            if (!empty($usuario['tipo_serv'])) {
                echo '<a class="a">Tipo de Serviço: ' . $usuario['tipo_serv'] . '</a><br>';
                echo '<a class="a">Nome do Serviço: ' . $usuario['nome_serv'] . '</a><br>';
                echo '<a class="a">Valor: R$ ' . $usuario['valor'] . '</a><br>';
                // Adicione código para exibir outras informações do serviço, como a foto, se necessário
            }
            ?>

            <br>
            <input class="botao1" type="button" value="Alterar" onclick="window.location.href='index.php'">
        </div>
    </div>
</body>

</html>