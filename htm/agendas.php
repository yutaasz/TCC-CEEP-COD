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

        .redirect-button {
            display: inline-block;
            padding: 5px 10px;
            margin: 5px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
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

            $query_agendamentos = "SELECT ag.*, ser.nome_serv, usr.nome_user, usr.tipo_user
            FROM tb_agendas ag
            INNER JOIN tb_agendamentos_servicos ags ON ag.fk_agend_serv = ags.id_agend_serv
            INNER JOIN tb_servicos ser ON ags.fk_serv = ser.id_serv
            INNER JOIN tb_usuarios usr ON ags.fk_user = usr.id_user
            WHERE ags.fk_user = $user_id AND (usr.tipo_user = 'C' OR usr.tipo_user = 'T')";

            $result_agendamentos = mysqli_query($conexao, $query_agendamentos);

            if (!$result_agendamentos) {
                die('Erro na consulta: ' . mysqli_error($conexao));
            }

            // Verifica se há agendamentos
            if (mysqli_num_rows($result_agendamentos) > 0) {
                echo "<table>";
                echo "<tr>";
                echo "<th>Data</th>";
                echo "<th>Horário</th>";
                echo "<th>Serviço</th>";
                echo "<th>Profissional ou Cliente</th>";
                echo "<th>Ação</th>";
                echo "</tr>";

                while ($row_agendamento = mysqli_fetch_assoc($result_agendamentos)) {
                    echo "<tr>";
                    echo "<td>" . $row_agendamento['data'] . "</td>";
                    echo "<td>" . $row_agendamento['hr_inicio'] . "</td>";
                    echo "<td>" . $row_agendamento['nome_serv'] . "</td>";

                    // Obtém o nome do cliente ou profissional, dependendo do tipo de usuário
                    $user_id = $row_agendamento['fk_user'];
                    $tipo_user = $row_agendamento['tipo_user'];

                    $nome_query = "SELECT nome_user FROM tb_usuarios WHERE id_user = $user_id";
                    $nome_result = mysqli_query($conexao, $nome_query);

                    if ($nome_result && $nome_row = mysqli_fetch_assoc($nome_result)) {
                        $nome_usuario = $nome_row['nome_user'];
                        echo "<td>" . $nome_usuario . "</td>";
                    } else {
                        echo "<td>Usuário não encontrado</td>";
                    }

                    // Adiciona um botão de redirecionamento para cada linha
                    echo "<td><a href='EndUser.php?user_id=" . $user_id . "' class='redirect-button'>Ver Detalhes</a></td>";

                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "Você ainda não fez nenhum agendamento.";
            }
        }
        ?>
        <br>
        <a href="index.php">Voltar para a Página Inicial</a>
    </div>
</body>

</html>

