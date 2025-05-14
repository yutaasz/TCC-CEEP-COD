<?php
include 'config.php';

// Verifica se o parâmetro user_id foi passado na URL
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Consulta para obter informações do usuário e seu endereço
    $query_detalhes_usuario = "SELECT usr.*, end.*, 'Cascavel' as nome_cidade, 'Paraná' as estado
        FROM tb_usuarios usr
        LEFT JOIN tb_enderecos end ON usr.id_user = end.fk_user
        WHERE usr.id_user = $user_id";

    $result_detalhes_usuario = mysqli_query($conexao, $query_detalhes_usuario);

    if (!$result_detalhes_usuario) {
        die('Erro na consulta: ' . mysqli_error($conexao));
    }

    // Verifica se há informações para exibir
    if (mysqli_num_rows($result_detalhes_usuario) > 0) {
        $row_detalhes_usuario = mysqli_fetch_assoc($result_detalhes_usuario);

        // Exibe as informações
        echo "<h2>Detalhes do Usuário</h2>";
        echo "<p><strong>Nome:</strong> " . $row_detalhes_usuario['nome_user'] . "</p>";
        echo "<p><strong>E-mail:</strong> " . $row_detalhes_usuario['email_user'] . "</p>";
        echo "<p><strong>Telefone:</strong> " . $row_detalhes_usuario['telefone_user'] . "</p>";
        echo "<h3>Endereço</h3>";
        echo "<p><strong>Rua:</strong> " . $row_detalhes_usuario['rua'] . "</p>";
        echo "<p><strong>CEP:</strong> " . $row_detalhes_usuario['cep'] . "</p>";
        echo "<p><strong>Número:</strong> " . $row_detalhes_usuario['numero_casa'] . "</p>";
        echo "<p><strong>Complemento:</strong> " . $row_detalhes_usuario['complemento'] . "</p>";
        echo "<p><strong>Cidade:</strong> " . $row_detalhes_usuario['nome_cidade'] . "</p>";
        echo "<p><strong>Estado:</strong> " . $row_detalhes_usuario['estado'] . "</p>";

        // Adicione mais campos conforme necessário

    } else {
        echo "Nenhuma informação encontrada para o usuário com ID " . $user_id;
    }
} else {
    echo "ID do usuário não especificado na URL.";
}
?>

