<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento de Serviços</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            background-color: #333;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
        }

        form {
            margin-top: 20px;
        }

        select,
        input[type="date"],
        input[type="submit"] {
            margin: 10px 0;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
    </style>


<script>
        var serviceValue = '<?php echo $valor_servico; ?>';

        function getServiceValue(serviceId) {
            console.log("getServiceValue called with serviceId: " + serviceId);

            if (serviceValue !== null && serviceValue !== undefined) {
                document.getElementById("service_value_display").innerHTML = "Valor do Serviço: R$ " + serviceValue;
            } else {
                document.getElementById("service_value_display").innerHTML = "Valor do Serviço indisponível";
            }
        }

        function carregarHorarios() {
            var selectedDate = document.getElementById("data_escolhida").value;
            var codProfissional = <?php echo $doctorId; ?>;

            // Obter o dia da semana a partir da data selecionada
            var semana = ["domingo", "segunda", "terca", "quarta", "quinta", "sexta", "sabado"];
            var dateObj = new Date(selectedDate + 'T00:00:00');
            var dayOfWeek = semana[dateObj.getUTCDay()];

            $.ajax({
                type: "POST",
                url: "consultahorario.php",
                data: { codprofissional: codProfissional, dayOfWeek: dayOfWeek },
                success: function (data) {
                    // Limpar as opções existentes no segundo select
                    $("#horario_escolhido").empty();

                    // Preencher o segundo select com as opções retornadas pelo servidor
                    $("#horario_escolhido").html(data);
                }
            });
        }
    </script>

</head>

<body>
    <div class="container">
        <h1>Agendar Serviço</h1>

        <?php
        include 'config.php';
        session_start();

        // Verifica se o usuário está autenticado
        if (isset($_SESSION['id_user'])) {
            // Obtém o ID do usuário
            $user_id = $_SESSION['id_user'];
        } else {
            // Se o usuário não estiver autenticado, redirecione para a página de login ou tome outras medidas apropriadas
            header("Location:login.php");
            exit();
        }

        // Verificar se o ID do trabalhador foi passado na URL
        if (isset($_GET['id_profissional']) && isset($_GET['id_servico'])) {
            $doctorId = $_GET['id_profissional'];
            $idserv = $_GET['id_servico'];

            // Consultar o banco de dados para obter informações sobre o trabalhador
            $query_worker = "SELECT * FROM tb_usuarios WHERE id_user = $doctorId";
            $result_worker = mysqli_query($conexao, $query_worker);

            // Verificar se a consulta teve êxito
            if ($result_worker) {
                // Processar os resultados e exibir as informações do trabalhador
                if ($row_worker = mysqli_fetch_assoc($result_worker)) {
                    // Exibir informações do trabalhador
                    echo "Nome do Trabalhador: " . $row_worker['nome_user'] . "<br>";

                    // Consultar os horários do trabalhador usando a chave estrangeira
                    $query_horarios = "SELECT * FROM tb_horarios WHERE fk_user = $doctorId";
                    $result_horarios = mysqli_query($conexao, $query_horarios);
                    // Verificar se a consulta de horários teve êxito
                    if ($result_horarios) {
                        // Exibir o formulário para seleção de horário e data
                        echo "<form action='agendamento.php?id_profissional=$doctorId&id_servico=$idserv' method='POST'>";

                        // Adicionar campo de seleção de data
                        echo "<br>";
                        echo "<label for='data_escolhida'>Escolha a Data:</label>";
                        echo "<input type='date' name='data_escolhida' id='data_escolhida' required onchange='carregarHorarios()'>";
                        echo "<br>";

                        echo "<label for='horario_escolhido'>Escolha o Horário:</label>";
                        echo "<select name='horario_escolhido' id='horario_escolhido'>";

                        // Iterar sobre os horários disponíveis
                        while ($row_horario = mysqli_fetch_assoc($result_horarios)) {
                            // Adicionar opções de horário da manhã e tarde com valores dinâmicos
                            echo "<option value='" . $row_horario['entrada_manha'] . "'>Manhã - " . $row_horario['entrada_manha'] . " às " . $row_horario['saida_manha'] . "</option>";
                            echo "<option value='" . $row_horario['entrada_tarde'] . "'>Tarde - " . $row_horario['entrada_tarde'] . " às " . $row_horario['saida_tarde'] . "</option>";
                        }

                        echo "</select>";
                        echo "<br><br>";

                        // Exibir os horários do trabalhador
                        while ($row_horario = mysqli_fetch_assoc($result_horarios)) {
                            // Exibir todos os horários disponíveis
                            echo "Entrada Manhã: " . $row_horario['entrada_manha'] . "<br>";
                            echo "Entrada Tarde: " . $row_horario['entrada_tarde'] . "<br>";
                            // Adicione aqui outros campos e informações que você deseja exibir
                        }

                        echo'<label for="tipo_pagamento">Escolha o Tipo de Pagamento:</label>';
                        echo'<select name="tipo_pagamento" id="tipo_pagamento" required>';
                        echo'<option value="P">Pix</option>';
                        echo'<option value="D">Dinheiro</option>';
                        echo'</select>';
                        echo'<br><br>';

                        // Consulta para obter o valor do serviço
                        $query_valor_servico = "SELECT valor FROM tb_servicos WHERE id_serv = $idserv";
                        $result_valor_servico = mysqli_query($conexao, $query_valor_servico);

                        if ($result_valor_servico && $row_valor_servico = mysqli_fetch_assoc($result_valor_servico)) {
                            $valor_servico = $row_valor_servico['valor'];
                        } else {
                            // Se não encontrar o valor do serviço, defina um valor padrão ou trate conforme necessário
                            $valor_servico = 0.0;
                        }

                        // Exibir informações do serviço
                        echo "<p id='service_value_display'>Valor do Serviço: R$ " . $valor_servico . "</p>";

                        echo "<label for='cpf_usuario'>CPF:</label>";
                        echo "<input type='text' name='cpf_usuario' required>";
                        echo "<br>";
                        echo "<input type='submit' value='Agendar' class='button'>";
                        echo "<a href='index.php' class='button'>Voltar</a>";
                        echo "</form>";

                        
                        // Verificar se o formulário foi enviado
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            // Obter valores do formulário
                            $horario_escolhido = $_POST['horario_escolhido'];
                            $data_escolhida = $_POST['data_escolhida'];
                            $cpf_usuario = $_POST['cpf_usuario'];
                            $tipo_pagamento = strtoupper($_POST['tipo_pagamento']);  // Converte para maiúsculas por segurança
                        
                            // Obter a data atual
                            $data_atual = date('Y-m-d');
                        
                            // Verificar se a data escolhida é menor que a data atual
                            if ($data_escolhida < $data_atual) {
                                echo "Você não pode agendar para uma data passada.";
                                exit();
                            }
                        
                            // Verificar se o CPF não está vazio
                            if (!empty($cpf_usuario)) {
                                // Consultar o usuário com base no CPF usando uma declaração preparada
                                $query_usuario = "SELECT * FROM tb_usuarios WHERE cpf_user = ?";
                                $stmt_usuario = mysqli_prepare($conexao, $query_usuario);
                        
                                // Vincular parâmetros
                                mysqli_stmt_bind_param($stmt_usuario, "s", $cpf_usuario);
                        
                                // Executar a consulta preparada
                                mysqli_stmt_execute($stmt_usuario);
                        
                                // Obter resultados da consulta
                                $result_usuario = mysqli_stmt_get_result($stmt_usuario);
                        
                                // Verificar se o usuário foi encontrado
                                if (!$result_usuario || !$row_usuario = mysqli_fetch_assoc($result_usuario)) {
                                    // O usuário não foi encontrado, exiba uma mensagem ou tome outra medida apropriada
                                    echo "Usuário não encontrado com o CPF fornecido.";
                                    exit(); // Encerrar o script se o usuário não for encontrado
                                }
                                // O usuário foi encontrado, e você pode usar $row_usuario conforme necessário
                                $id_usuario = $row_usuario['id_user'];
                            }
                        
                            // Verificar se o horário está disponível para agendamento
                            $query_verificar_agendamento = "SELECT * FROM tb_agendas ag
                                                            INNER JOIN tb_agendamentos_servicos ags ON ag.fk_agend_serv = ags.id_agend_serv
                                                            WHERE ag.hr_inicio = ?
                                                            AND ag.data = ?";
                        
                            // Preparar a consulta para verificar o agendamento
                            $stmt_verificar_agendamento = mysqli_prepare($conexao, $query_verificar_agendamento);
                        
                            // Vincular parâmetros
                            mysqli_stmt_bind_param($stmt_verificar_agendamento, "ss", $horario_escolhido, $data_escolhida);
                        
                            // Executar a consulta preparada
                            mysqli_stmt_execute($stmt_verificar_agendamento);
                        
                            // Obter resultados da consulta
                            $result_verificar_agendamento = mysqli_stmt_get_result($stmt_verificar_agendamento);
                        
                            // Verificar se o horário está disponível para agendamento
                            if (mysqli_num_rows($result_verificar_agendamento) > 0) {
                                echo "Desculpe, o horário escolhido já está ocupado. Por favor, escolha outro horário.";
                                exit(); // Encerrar o script se o horário já estiver ocupado
                            }
                        
                            // Inserir dados na tabela tb_agendamentos_servicos
                            $query_insert_agend_serv = "INSERT INTO tb_agendamentos_servicos (fk_serv, fk_user, valor) VALUES (?, ?, ?)";
                            $stmt_insert_agend_serv = mysqli_prepare($conexao, $query_insert_agend_serv);
                        
                            // Obter os IDs necessários dinamicamente (substituir pelos valores corretos)
                            $fk_serv = $idserv; // Substitua pelo valor apropriado
                            $fk_user = $doctorId; // Use o ID do usuário encontrado
                            // Vincular parâmetros
                            mysqli_stmt_bind_param($stmt_insert_agend_serv, "iid", $fk_serv, $fk_user, $valor_servico);
                        
                            // Executar a consulta preparada
                            if (mysqli_stmt_execute($stmt_insert_agend_serv)) {
                                // Obter o ID recém-inserido
                                $id_agend_serv = mysqli_insert_id($conexao);
                        
                                // Inserir agendamento na tabela tb_agendas
                                $query_agenda = "INSERT INTO tb_agendas (data, hr_inicio, tipo_pagamento, fk_agend_serv, fk_user) 
                                                VALUES (?, ?, ?, ?, ?)";
                                $stmt_agenda = mysqli_prepare($conexao, $query_agenda);
                        
                                // Vincular parâmetros
                                mysqli_stmt_bind_param($stmt_agenda, "ssssi", $data_escolhida, $horario_escolhido, $tipo_pagamento, $id_agend_serv, $id_usuario);
                        
                                // Executar a consulta preparada
                                if (mysqli_stmt_execute($stmt_agenda)) {
                                // Inclua esta linha no lugar do header
                                echo '<meta http-equiv="refresh" content="0;url=index.php">';
                                exit();  // Certifique-se de sair do script após o redirecionamento
                                } else {
                                    echo "Erro ao inserir na tabela tb_agendas: " . mysqli_error($conexao);
                                }
                            } else {
                                echo "Erro ao inserir na tabela tb_agendamentos_servicos: " . mysqli_error($conexao);
                            }
                        } else {
                            echo "Erro na consulta de horários: " . mysqli_error($conexao);
                        }}}}}
        ?>

        <!-- Div para exibir informações sobre o dia da semana -->
        <div id="demo">
        <script>
        function carregarHorarios() {
            var selectedDate = document.getElementById("data_escolhida").value;
            var codProfissional = <?php echo $doctorId; ?>;
            
            // Obter o dia da semana a partir da data selecionada
            var semana = ["domingo", "segunda", "terca", "quarta", "quinta", "sexta", "sabado"];
            var dateObj = new Date(selectedDate + 'T00:00:00');
            var dayOfWeek = semana[dateObj.getUTCDay()];

            $.ajax({
                type: "POST",
                url: "consultahorario.php",
                data: { codprofissional: codProfissional, dayOfWeek: dayOfWeek },
                success: function (data) {
                console.log(data); // Adicione esta linha para depuração

                // Limpar as opções existentes no segundo select
                $("#horario_escolhido").empty();

                // Preencher o segundo select com as opções retornadas pelo servidor
                $("#horario_escolhido").html(data);
            }
            });
        }
        </script>
        </div>
        </div>

    <script>
        function getServiceValue(serviceId) {
            console.log("getServiceValue called with serviceId: " + serviceId);
            var selectedOption = document.querySelector('#service option[value="' + serviceId + '"]');

            if (selectedOption) {
                var serviceValue = selectedOption.getAttribute('data-value');

                if (serviceValue !== null && serviceValue !== undefined) {
                    document.getElementById("service_value_display").innerHTML = "Valor do Serviço: R$ " + serviceValue;
                } else {
                    document.getElementById("service_value_display").innerHTML = "Valor do Serviço indisponível";
                }
            } else {
                document.getElementById("service_value_display").innerHTML = "Opção de Serviço não encontrada";
            }
        }
    </script>
</body>

</html>