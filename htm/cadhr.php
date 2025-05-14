<?php
include_once 'config.php';

function obterIdUsuarioLogado() {
    session_start();
    
    if (isset($_SESSION['id_usuario']) && is_numeric($_SESSION['id_usuario'])) {
        return $_SESSION['id_usuario'];
    } else {
        return 0;
    }   
}

$idUsuarioLogado = obterIdUsuarioLogado(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $diasSemana = $_POST['dias_semana'];
    $entradaManha = $_POST['entrada_manha'];
    $saidaManha = $_POST['saida_manha'];
    $entradaTarde = $_POST['entrada_tarde'];
    $saidaTarde = $_POST['saida_tarde'];

    // Verificar se o usuário está logado
    if ($idUsuarioLogado == 0) {
        echo "Usuário não está logado.";
        exit();
    }

    // Preparar a declaração usando declaração preparada para evitar SQL Injection
    $stmt = $conexao->prepare("INSERT INTO tb_horarios (entrada_manha, saida_manha, entrada_tarde, saida_tarde, dia_semana, fk_user) VALUES (?, ?, ?, ?, ?, ?)");
    
    // Inserir registros para cada dia selecionado
    foreach ($diasSemana as $dia) {
        $stmt->bind_param("sssssi", $entradaManha, $saidaManha, $entradaTarde, $saidaTarde, $dia, $idUsuarioLogado);
        $stmt->execute();
    }

    echo "Dados inseridos com sucesso!";
    header("Location: login.php");

    $stmt->close();
    $conexao->close();
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital@0;1&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap">
    <style>
        html {
            height: 100%;
        }

        body {
            background: linear-gradient(225deg, rgba(254, 0, 0, 0.20) 0%, rgba(3, 0, 158, 0.20) 100%);
            margin: 0;
            padding: 0;
            font-size: 100%;
            color: rgb(27, 15, 0);
            font-family: 'Poppins', sans-serif;
            background-attachment: fixed;
            flex-direction: column;
            min-height: 100vh;
            display: flex;
        }

        .fundo-login {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login {
            background-color: rgba(0, 0, 0, 0.144);
            padding: 60px;
            border-radius: 15px;
            text-align: center;
        }

        .text_opcoes {
            font-family: 'Poppins', sans-serif;
            font-size: 20px;
        }

        input, select, .botao1 {
            width: 100%;
            padding: 15px;
            margin-bottom: 10px;
            font-size: 25px;
            border: none;
            outline: none;
            background-color: transparent;
            color: rgb(27, 15, 0);
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body>
    <div class="fundo-login">
        <div class="login">
            <form method="POST" action="cadhr.php">
                <label class="text_opcoes">Dias da Semana:</label><br>
                <p class="text_opcoes">Domingo</p>
                <input type="checkbox" name="dias_semana[]" value="domingo"><br>
                <p class="text_opcoes">Segunda-feira</p>
                <input type="checkbox" name="dias_semana[]" value="segunda"><br>
                <p class="text_opcoes">Terça-feira</p>
                <input type="checkbox" name="dias_semana[]" value="terca"><br>
                <p class="text_opcoes">Quarta-feira</p>
                <input type="checkbox" name="dias_semana[]" value="quarta"><br>
                <p class="text_opcoes">Quinta-feira</p>
                <input type="checkbox" name="dias_semana[]" value="quinta"><br>
                <p class="text_opcoes">Sexta-feira</p>
                <input type="checkbox" name="dias_semana[]" value="sexta"><br>
                <p class="text_opcoes">Sábado</p>
                <input type="checkbox" name="dias_semana[]" value="sabado"><br>

                <label class="text_opcoes" for="entrada_manha">Entrada Manhã:</label>
                <input type="time" class="entrada_manha" name="entrada_manha" required>

                <label class="text_opcoes" for="saida_manha">Saída Manhã:</label>
                <input type="time" class="saida_manha" name="saida_manha" required>

                <label class="text_opcoes" for="entrada_tarde">Entrada Tarde:</label>
                <input type="time" class="entrada_tarde" name="entrada_tarde" required>

                <label class="text_opcoes" for="saida_tarde">Saída Tarde:</label>
                <input type="time" class="saida_tarde" name="saida_tarde" required>

                <input class="botao1" type="submit" value="Salvar Horário">
            </form>
        </div>
    </div>
</body>
</html>