<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Agendamentos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
        }

        .btn-alterar, .btn-excluir {
            padding: 5px 10px;
            margin: 2px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Meus Agendamentos</h1>

        <?php
include 'config.php';
session_start();

// Verifica se o usuário está autenticado
if (isset($_SESSION['id_user'])) {
    // Obtém o ID do usuário
    $user_id = $_SESSION['id_user'];

    // Consulta SQL para buscar todos os agendamentos feitos pelo usuário logado
    $query_agendamentos = "SELECT ag.*, ser.nome_serv, usr.nome_user
                            FROM tb_agendas ag
                            INNER JOIN tb_agendamentos_servicos ags ON ag.fk_agend_serv = ags.id_agend_serv
                            INNER JOIN tb_servicos ser ON ags.fk_serv = ser.id_serv
                            INNER JOIN tb_usuarios usr ON ags.fk_user = usr.id_user
                            WHERE ag.fk_user = $user_id";

    // Executa a consulta
    $result_agendamentos = mysqli_query($conexao, $query_agendamentos);

    if ($result_agendamentos === false) {
        die('Erro na consulta: ' . mysqli_error($conexao));
    }

    // Verifica se há agendamentos
    if (mysqli_num_rows($result_agendamentos) > 0) {
        echo "<h2>Agendamentos do Usuário</h2>";
        echo "<table>";
        echo "<tr>";
        echo "<th>Data</th>";
        echo "<th>Horário</th>";
        echo "<th>Serviço</th>";
        echo "<th>Profissional</th>";
        echo "</tr>";

        while ($row_agendamento = mysqli_fetch_assoc($result_agendamentos)) {
            echo "<tr>";
            echo "<td>" . $row_agendamento['data'] . "</td>";
            echo "<td>" . $row_agendamento['hr_inicio'] . "</td>";
            echo "<td>" . $row_agendamento['nome_serv'] . "</td>";
            echo "<td>" . $row_agendamento['nome_user'] . "</td>";
            echo "<td>";
            
            // Botão Alterar
            echo "<a href='AltAgeUser.php?id=" . $row_agendamento['id_agendamento'] . "' class='btn btn-warning'>Alterar</a>";
            
            // Botão Excluir
            echo "<a href='ExAgeUser.php?id=" . $row_agendamento['id_agendamento'] . "' class='btn btn-danger' onclick=\"return confirm('ATENÇÃO! Deseja realmente excluir? As informações serão permanentemente perdidas e não poderão ser recuperadas.')\">Excluir</a>";
        
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>Você ainda não fez nenhum agendamento.</p>";
    }
} else {
    // Se o usuário não estiver autenticado, redirecione para a página de login
    header("Location: login.php");
    exit();
}
?>





        <br>
        <a href="index.php">Voltar para a Página Inicial</a>
    </div>
</body>

</html>
