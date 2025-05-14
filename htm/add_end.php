<?php
include_once('config.php');

// Consulta para obter todos os usuários
$sql_usuarios = "SELECT id_user, nome_user FROM tb_usuarios";
$result_usuarios = $conexao->query($sql_usuarios);

// Processar o formulário de inclusão
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rua = $_POST['rua'];
    $cep = $_POST['cep'];
    $numero_casa = $_POST['numero_casa'];
    $complemento = $_POST['complemento'];
    $fk_user = $_POST['fk_user'];
    $fk_cidade = 2853;  // Definir diretamente aqui

    echo "Valor de fk_cidade: $fk_cidade";

    // Execute a inserção no banco de dados
    $sql_inserir = "INSERT INTO tb_enderecos (rua, cep, numero_casa, complemento, fk_user, fk_cidade) 
                    VALUES ('$rua', '$cep', '$numero_casa', '$complemento', '$fk_user', '$fk_cidade')";
    
    if ($conexao->query($sql_inserir) === TRUE) {
        header("Location: crud_endereco.php");
        exit();
    } else {
        echo "Erro ao incluir endereço: " . $conexao->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Incluir Endereço</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
<body>

<h2>
    <center>Incluir Endereço</center>
</h2>
<form method="post" action="">
    <div class="form-group">
        <label for="rua">Rua:</label>
        <input type="text" class="form-control" name="rua" required>
    </div>
    <div class="form-group">
        <label for="cep">CEP:</label>
        <input type="text" class="form-control" name="cep" required>
    </div>
    <div class="form-group">
        <label for="numero_casa">Número da Casa:</label>
        <input type="text" class="form-control" name="numero_casa" required>
    </div>
    <div class="form-group">
        <label for="complemento">Complemento:</label>
        <input type="text" class="form-control" name="complemento">
    </div>
    <div class="form-group">
        <label for="fk_user">Usuário:</label>
        <select class="form-control" name="fk_user" required>
            <?php
            // Exibir opções para cada usuário
            while ($row = $result_usuarios->fetch_assoc()) {
                echo "<option value='" . $row['id_user'] . "'>" . $row['nome_user'] . "</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="fk_cidade">Cidade:</label>
        <select class="form-control" name="fk_cidade">
            <?php
            echo "<option value='" . $fk_cidade . "'>Cascavel</option>";
            ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Incluir Endereço</button>
</form>
<!-- Seus scripts aqui -->
</body>
</html>
                