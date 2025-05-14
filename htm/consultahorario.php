<?php
if (isset($_POST['codprofissional']) && isset($_POST['dayOfWeek'])) {
    include 'config.php';

    $profissionalSelecionado = mysqli_real_escape_string($conexao, $_POST['codprofissional']);
    $dayOfWeek = mysqli_real_escape_string($conexao, $_POST['dayOfWeek']);

    $query_servicos = "SELECT * FROM tb_horarios WHERE fk_user = '$profissionalSelecionado' AND dia_semana LIKE '%$dayOfWeek%'";
    $result_servicos = $conexao->query($query_servicos);

    $options = '<option value="">Selecione um horário</option>';
    
    while ($row_servico = $result_servicos->fetch_assoc()) {
        // Manhã
        $options .= generateTimeOptions($row_servico['entrada_manha'], $row_servico['saida_manha']);

        // Tarde
        $options .= generateTimeOptions($row_servico['entrada_tarde'], $row_servico['saida_tarde']);
    }

    echo $options;

    // Fechar a conexão com o banco de dados
    $conexao->close();
}

function generateTimeOptions($entrada, $saida)
{
    $options = "<option value='$entrada'>$entrada $saida</option>";

    return $options;
}
?>
