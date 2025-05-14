<?php
include_once('config.php');

// Consulta para obter todos os usuários do tipo 'T'
$sql_usuarios_tecnicos = "SELECT id_user, nome_user FROM tb_usuarios WHERE tipo_user = 'T'";
$result_usuarios_tecnicos = $conexao->query($sql_usuarios_tecnicos);

// Processar o formulário de inclusão
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entrada_manha = $_POST['entrada_manha'];
    $saida_manha = $_POST['saida_manha'];
    $entrada_tarde = $_POST['entrada_tarde'];
    $saida_tarde = $_POST['saida_tarde'];
    $fk_user = $_POST['fk_user'];

    // Processar dias da semana
    $dias_semana = $_POST['dias_semana'];

    // Execute a inserção no banco de dados para cada dia selecionado
    foreach ($dias_semana as $dia) {
        // Construa uma instrução SQL preparada
        $sql_inserir = "INSERT INTO tb_horarios (entrada_manha, saida_manha, entrada_tarde, saida_tarde, dia_semana, fk_user) 
                        VALUES (?, ?, ?, ?, ?, ?)";
        
        // Preparar a declaração usando declaração preparada para evitar SQL Injection
        $stmt = $conexao->prepare($sql_inserir);
        $stmt->bind_param("sssssi", $entrada_manha, $saida_manha, $entrada_tarde, $saida_tarde, $dia, $fk_user);

        // Executar a instrução preparada
        $stmt->execute();

        // Fechar a declaração
        $stmt->close();
    }

    header("Location: crud_hora.php");
    exit();
}
?> 

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Incluir Horário</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
</head>
<body>

<script>
    $(document).ready(function(){
        $('.time').mask('00:00');
    });
</script>

<h2>
    <center>Incluir Horário</center>
</h2>
<form method="post" action="">
    <div class="form-group">
        <label for="entrada_manha">Entrada Manhã:</label>
        <input type="time" class="form-control" name="entrada_manha" required>
    </div>
    <div class="form-group">
        <label for="saida_manha">Saída Manhã:</label>
        <input type="time" class="form-control" name="saida_manha" required>
    </div>
    <div class="form-group">
        <label for="entrada_tarde">Entrada Tarde:</label>
        <input type="time" class="form-control" name="entrada_tarde" required>
    </div>
    <div class="form-group">
        <label for="saida_tarde">Saída Tarde:</label>
        <input type="time" class="form-control" name="saida_tarde" required>
    </div>
    <div class="form-group">
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
    </div>
    <div class="form-group">
        <label for="fk_user">Nome do Técnico:</label>
        <select class="form-control" name="fk_user" required>
            <?php
            // Exibir opções para cada técnico
            while ($row = $result_usuarios_tecnicos->fetch_assoc()) {
                echo "<option value='" . $row['id_user'] . "'>" . $row['nome_user'] . "</option>";
            }
            ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Incluir Horário</button>
</form>
<!-- Seus scripts aqui -->
</body>
</html>
