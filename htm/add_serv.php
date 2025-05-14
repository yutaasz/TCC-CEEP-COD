<?php
include_once('config.php');

// Consulta para obter todos os usuários do tipo 'T'
$sql_usuarios_tecnicos = "SELECT id_user, nome_user FROM tb_usuarios WHERE tipo_user = 'T'";
$result_usuarios_tecnicos = $conexao->query($sql_usuarios_tecnicos);

// Processar o formulário de inclusão
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo_serv = $_POST['tipo_serv'];
    $nome_serv = $_POST['nome_serv'];
    $valor = $_POST['valor'];
    $foto = $_POST['foto'];
    $fk_user = $_POST['fk_user'];

    // Execute a inserção no banco de dados
    $sql_inserir = "INSERT INTO tb_servicos (tipo_serv, nome_serv, valor, foto, fk_user) 
                    VALUES ('$tipo_serv', '$nome_serv', '$valor', '$foto', '$fk_user')";
    
    if ($conexao->query($sql_inserir) === TRUE) {
        header("Location: crud_serv.php");
        exit();
    } else {
        echo "Erro ao incluir serviço: " . $conexao->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Incluir Serviço</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
</head>
<body>

<script>
    $(document).ready(function(){
        $('#valor').mask('R$ 0.000,00', {reverse: true});
    });
</script>

<h2>
    <center>Incluir Serviço</center>
</h2>
<form method="post" action="">
    <div class="form-group">
        <label for="tipo_serv">Tipo de Serviço:</label>
        <input type="text" class="form-control" name="tipo_serv" required>
    </div>
    <div class="form-group">
        <label for="nome_serv">Nome do Serviço:</label>
        <input type="text" class="form-control" name="nome_serv" required>
    </div>
    <div class="form-group">
        <label for="valor">Valor:</label>
        <input type="text" class="form-control" name="valor" id="valor" required>
    </div>
    <div class="form-group">
        <label class="text_foto" for="foto">Escolha uma foto:</label>
        <input type="file" name="foto" accept="image/*">
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
    <button type="submit" class="btn btn-primary">Incluir Serviço</button>
</form>
<!-- Seus scripts aqui -->
</body>
</html>
