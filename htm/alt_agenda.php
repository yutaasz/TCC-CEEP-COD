<?php
session_start();
include_once('config.php');

$agendamento_id = $_GET['id'];
$dadosAgenda = $data_do_banco = $hr_inicio_do_banco = $tipo_pagamento_do_banco = $fkUser = '';

// Consultar fk_agend_serv da tabela tb_agendas
$sqlFkAgendServ = "SELECT fk_agend_serv FROM tb_agendas WHERE id_agendamento = ?";
$stmtFkAgendServ = $conexao->prepare($sqlFkAgendServ);
$stmtFkAgendServ->bind_param('i', $agendamento_id);
$stmtFkAgendServ->execute();
$resultFkAgendServ = $stmtFkAgendServ->get_result();
$fkAgendServRow = $resultFkAgendServ->fetch_assoc();

if ($fkAgendServRow !== null && isset($fkAgendServRow['fk_agend_serv'])) {
    $fkAgendServ = $fkAgendServRow['fk_agend_serv'];

    // Agora, com o fk_agend_serv, você pode consultar os demais dados
    $sqlFkUser = "SELECT fk_user FROM tb_agendamentos_servicos WHERE id_agend_serv = ?";
    $stmtFkUser = $conexao->prepare($sqlFkUser);
    $stmtFkUser->bind_param('i', $fkAgendServ);
    $stmtFkUser->execute();
    $resultFkUser = $stmtFkUser->get_result();
    $fkUserRow = $resultFkUser->fetch_assoc();

    if ($fkUserRow !== null && isset($fkUserRow['fk_user'])) {
        $fkUser = $fkUserRow['fk_user'];

        // Agora, com o fk_user, você pode consultar os horários disponíveis
        $sqlHorarios = "SELECT id_horario, entrada_manha, entrada_tarde FROM tb_horarios WHERE fk_user = ?";
        $stmtHorarios = $conexao->prepare($sqlHorarios);
        $stmtHorarios->bind_param('i', $fkUser);
        $stmtHorarios->execute();
        $resultHorarios = $stmtHorarios->get_result();

        // Obter dados da agenda para preencher os campos
        $sqlDadosAgenda = "SELECT data, hr_inicio, tipo_pagamento FROM tb_agendas WHERE id_agendamento = ?";
        $stmtDadosAgenda = $conexao->prepare($sqlDadosAgenda);
        $stmtDadosAgenda->bind_param('i', $agendamento_id);
        $stmtDadosAgenda->execute();
        $resultDadosAgenda = $stmtDadosAgenda->get_result();
        $dadosAgenda = $resultDadosAgenda->fetch_assoc();

        $data_do_banco = $dadosAgenda['data'];
        $hr_inicio_do_banco = $dadosAgenda['hr_inicio'];
        $tipo_pagamento_do_banco = $dadosAgenda['tipo_pagamento'];
    } else {
        die("Erro ao obter fk_user da tabela multivalorada.");
    }
} else {
    die("Erro ao obter fk_agend_serv da tabela tb_agendas.");
}

// Verificar se o formulário foi enviado
if (isset($_POST['btnAlterar'])) {
    $data = $_POST['data_escolhida'];
    $hr_inicio = $_POST['horario_escolhido'];
    $tipo_pagamento_do_banco = $_POST['tipo_pagamento'];

    if (empty($data) || empty($hr_inicio) || empty($tipo_pagamento_do_banco)) {
        echo "Todos os campos são obrigatórios!";
    } else {
        $sqlup = "UPDATE tb_agendas SET data = ?, hr_inicio = ?, tipo_pagamento = ? WHERE id_agendamento = ?";
        $stmt_up = $conexao->prepare($sqlup);
        $stmt_up->bind_param('sssi', $data, $hr_inicio, $tipo_pagamento_do_banco, $agendamento_id);

        if ($stmt_up->execute()) {
            header("Location: crud_agenda.php");
            exit();
        } else {
            echo "Erro ao alterar: " . $stmt_up->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Alteração de Agendamentos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <style>
        body {
            text-align: center;
        }
    </style>

    <script>
        function confirmarAlteracao() {
            return confirm("ATENÇÃO! Deseja realmente alterar? As informações originais serão perdidas e não poderão ser recuperadas.");
        }

        function carregarHorarios() {
            var selectedDate = document.getElementById("data_escolhida").value;
            var agendamentoId = <?php echo $agendamento_id; ?>;
            var fkUser = <?php echo $fkUser; ?>;
            var hrInicio = document.getElementById("hr_inicio").value;

            var semana = ["domingo", "segunda", "terca", "quarta", "quinta", "sexta", "sabado"];
            var dateObj = new Date(selectedDate + 'T00:00:00');
            var dayOfWeek = semana[dateObj.getUTCDay()];

            $.ajax({
                type: "POST",
                url: "consultahorario.php",
                data: { codprofissional: fkUser, dayOfWeek: dayOfWeek, hrInicio: hrInicio },
                success: function (data) {
                    $("#horario_escolhido").empty();
                    $("#horario_escolhido").html(data);
                }
            });
        }
    </script>
</head>

<body>
    <h2>Alteração de Agendamentos</h2>
    <form method='POST' onsubmit="return confirmarAlteracao();">
        <div class="form-group">
            <br>
            <label for='data_escolhida'>Escolha a Data:</label>
            <input type='date' name='data_escolhida' id='data_escolhida' required onchange='carregarHorarios()' value="<?php echo $data_do_banco; ?>">
            <br>
            <br>

            <input type="hidden" name="hr_inicio" id="hr_inicio" value="<?php echo $hr_inicio_do_banco; ?>">

            <label for='horario_escolhido'>Escolha o Horário:</label>
            <select name='horario_escolhido' id='horario_escolhido'>
                <?php
                if ($resultHorarios) {
                    while ($row_horario = mysqli_fetch_assoc($resultHorarios)) {
                        echo "<option value='" . $row_horario['entrada_manha'] . "'>Manhã - " . $row_horario['entrada_manha'] . " às " . $row_horario['saida_manha'] . "</option>";
                        echo "<option value='" . $row_horario['entrada_tarde'] . "'>Tarde - " . $row_horario['entrada_tarde'] . " às " . $row_horario['saida_tarde'] . "</option>";
                    }
                } else {
                    echo "<option value=''>Nenhum horário disponível</option>";
                }
                ?>
            </select>
            <br><br>

            <label for="tipo_pagamento">Tipo de Pagamento</label><br>
            <select name="tipo_pagamento" required>
                <option value="D" <?php echo ($tipo_pagamento_do_banco == "D") ? 'selected' : ''; ?>>Dinheiro</option>
                <option value="P" <?php echo ($tipo_pagamento_do_banco == "P") ? 'selected' : ''; ?>>Pix</option>
            </select>
            <br><br>

            <button type="submit" name="btnAlterar" class="btn btn-warning">ALTERAR</button>
        </div>
    </form>
</body>

</html>
