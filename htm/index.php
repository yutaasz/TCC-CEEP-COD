<?php
include_once 'config.php';

// Verificar se o usuário está logado e obter informações do usuário
$usuario_logado = false;
$nome_usuario = '';
$tipo_usuario = '';

session_start();
if (isset($_SESSION['id_user'])) {
    $usuario_logado = true;
    $id_usuario = $_SESSION['id_user'];

    $sql = "SELECT id_user, nome_user, tipo_user FROM tb_usuarios WHERE id_user = $id_usuario";
    $result = $conexao->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nome_usuario = $row['nome_user'];
        $tipo_usuario = $row['tipo_user'];
    }
}

$sql = "SELECT u.id_user, u.nome_user, s.id_serv, s.valor, s.nome_serv, s.foto FROM tb_servicos s
        JOIN tb_usuarios u ON s.fk_user = u.id_user
        WHERE u.tipo_user = 'T'";

$result = $conexao->query($sql);
?>

<!DOCTYPE html>

<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Um 'iFood' de serviços">
    <title>HiREit - Trabalho de Conclusão de Curso</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap');

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-decoration: none;
        }

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
        .cabecalho{
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-around;
            padding: 24px;
        }
        .cabecalho-titulo{
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            font-size: 64px;
            color:rgb(27, 15, 0);
        }

        .cabecalho-imagem{
            height: 72px;
        }

        .cabecalho-menu {
            display: flex;
            gap: 32px;
            align-items: center; /* Adicione esta linha para alinhar verticalmente os itens do menu */
        }

        .cabecalho-menu-form {
            display: flex;
            align-items: center;
        }

        .cabecalho-menu-item{
            font-family: 'Poppins', sans-serif;
            color:rgb(27, 15, 0);
            font-weight: 400;
            font-size: 18px;
        }
        .select{
            font-family: 'Poppins', sans-serif;
            font-size: 18px;
            background-color: transparent;
            outline: none;
        }
        .opcao{
            background-color: transparent;
            outline: none;
        }

        .conteudo {
            display: flex;
            flex: 1;
            padding: 50px;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 20px; /* Adicione gap para espaçamento entre as colunas */
        }

        .div {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-content: space-between;
            column-gap: 20px;
            margin-bottom: 50px;
        }

        .conteudo-div {
            display: flex;
            width: 280px; /* Aumente o tamanho */
            height: 300px; /* Aumente o tamanho */
            border: 1px solid rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Adicione sombra */
            flex-direction: column; /* Alinhe o conteúdo verticalmente */
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            font-family: 'Poppins', sans-serif;   
        }

        .conteudo-div-imagem {
            width: 150px; /* Aumente o tamanho */
            height: 150px; /* Aumente o tamanho */
            margin-bottom: 10px; /* Adicione margem inferior */
        }

        .conteudo-div-nome {
            font-size: 24px; /* Aumente o tamanho da fonte */
            color: rgb(27, 15, 0);
        }

        .conteudo-div-profissao {
            font-size: 18px; /* Aumente o tamanho da fonte */
            color: rgb(27, 15, 0);
        }

        .rodape {
            border-top: 1px solid black;
            text-align: center;
            padding: 20px;
            /* Outras propriedades de estilo que você deseja adicionar ao seu rodapé */
        }

        .rodape-titulo{
            display: flex;
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            font-size: 20px;
            color:rgb(27, 15, 0);
            justify-content: center;
        }

        .imagem-usuario {
            width: 150px; /* Defina a largura desejada para as imagens */
            height: 150px; /* Defina a altura desejada para as imagens */
            object-fit: cover; /* Preserve as proporções da imagem e corte as bordas para preencher o contêiner */
            border-radius: 50%; /* Aplique bordas arredondadas para criar uma aparência circular */
        }

        .barra-pesquisa {
            font-family: 'Poppins', sans-serif;
            border: none;
            background-color: transparent;
            padding: 10px;
            font-size: 18px;
            color:rgb(27, 15, 0);
            font-weight: 400;
            font-size: 18px;
            outline: none; /* Remove a borda ao focar */
        }


        .btn-busca {
            font-family: 'Poppins', sans-serif;
            background-color: transparent;
            color:rgb(27, 15, 0);
            font-weight: 400;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            padding: 10px 20px; /* Adicione espaçamento interno ao botão */
            cursor: pointer;
            vertical-align: middle; /* Alinha verticalmente com a barra de pesquisa */
        }
    </style>


</head>

<body>

            <header class="cabecalho">
            <h1 class="cabecalho-titulo">HiREit</h1>
            <nav class="cabecalho-menu">
            <?php
            if ($usuario_logado) {
                // Se o usuário estiver logado, exiba o nome do usuário no cabeçalho
                echo '<a class="cabecalho-menu-item" href="profile.php?id_user=' . $id_usuario . '"><strong>' . $nome_usuario . '</strong></a>';
                // Mantenha o <select> com opções visíveis para todos os tipos de usuários
                echo '<div id="servicos-container" class="div">';
                echo "<form class='cabecalho-menu-form' method='post' action='obter_servicos.php'>";
                echo '<input name="termo_pesquisa" class="barra-pesquisa" type="text" id="txtbusca" placeholder="Pesquise por um serviço">';
                echo '<button class="btn-busca" type="submit" id="btnBusca">Pesquisar</button>';
                echo '</form>';
                echo '</div>';

                // Verifique o tipo de usuário e exiba as opções apropriadas
                if ($tipo_usuario === 'C') {
                    // Este é um cliente (tipo "C"), adicione opções específicas para clientes, por exemplo, "Agenda do Cliente"
                    echo '<a class="cabecalho-menu-item" href="agendasUser.php"><strong>Minha Agenda</strong></a>';
                } elseif ($tipo_usuario === 'T') {
                    // Este é um prestador de serviço (tipo "T"), adicione opções específicas para prestadores, por exemplo, "Cadastrar Serviço" ou "Agenda"
                    echo '<a class="cabecalho-menu-item" href="cadastrar_servico.php"><strong>Cadastrar Serviço</strong></a>';
                    echo '<a class="cabecalho-menu-item" href="agendas.php"><strong>Agendamentos</strong></a>';
                }

                // Adicione a opção de "Logoff"
                echo '<a class="cabecalho-menu-item" href="logoff.php"><strong>Logoff</strong></a>';
            } else {
                // Se o usuário não estiver logado, exiba a opção "Cadastrar-se" e "Login"
                echo '<a class="cabecalho-menu-item" href="cadastro.php"><strong>Cadastrar-se</strong></a>';
                echo '<a class="cabecalho-menu-item" href="login.php"><strong>Login</strong></a>';
            }
            ?>
            </nav>
        </header>
        <div class="div">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="conteudo-div">';
            
            // Verificar se a chave 'id_user' existe no array $row
            if (isset($row['id_user'])) {
                // Defina o caminho da imagem como placeholder por padrão
                $caminho_imagem = 'caminho/do/placeholder.jpg';
                if (!empty($row["foto"])) {
                    // Se a foto não estiver vazia, atualize o caminho da imagem
                    $caminho_imagem = 'img_trab//' . $row["foto"];
                    // Verifique se o arquivo da imagem existe
                    if (!file_exists($caminho_imagem)) {
                        // Se a imagem não existir, use o placeholder
                        $caminho_imagem = 'caminho/do/placeholder.jpg';
                    }
                }
                
                // Agora você pode usar $caminho_imagem com segurança
                echo '<a href="agendamento.php?id_profissional=' . $row["id_user"] . '&id_servico=' . $row["id_serv"] . '">';
                echo '<img class="imagem-usuario" src="' . $caminho_imagem . '" alt="Foto do usuário">';
                echo '<p class="conteudo-div-nome">' . $row["nome_user"] . '</p>';
                echo '</a>';
                echo '<p class="conteudo-div-profissao">Valor: R$ ' . $row["valor"] . '</p>';
                echo '<p class="conteudo-div-profissao">' . $row["nome_serv"] . '</p>';
                echo '</div>';
            } else {
                // Se 'id_user' não existe no array $row, exiba uma mensagem de erro ou faça algo apropriado.
                echo 'Registro inválido.';
            }
        }
    } else {
        echo "Nenhum serviço encontrado.";
    }
    ?>
</div>

        </main>

    <footer class="rodape">
        <h1 class="rodape-titulo"><strong>HiREit - Inovando o seu jeito de trabalhar</strong></h1>
    </footer>
</body>

</html>