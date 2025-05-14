<?php
include_once 'config.php';

function obterIdUsuarioLogado() {
    session_start();
    
    if (isset($_SESSION['id_usuario'])) {
        return $_SESSION['id_usuario'];
    } else {
        return 0;
    }
}

$idUsuarioLogado = obterIdUsuarioLogado(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipoServico = $_POST['tipo_nome_servico'];
    $nomeServico = $_POST['tipo_nome_servico']; // Corrigido para usar 'nome_servico'
    $valor = $_POST['valor'];
    $foto = $_FILES['foto']['name'];
    $caminhoFoto = 'img_trab//' . $foto; // Corrigido o caminho com duas barras

    list($tipoServico, $nomeServico) = explode(" - ", $tipoServico);

    move_uploaded_file($_FILES['foto']['tmp_name'], $caminhoFoto);

    if ($idUsuarioLogado == 0) {
        echo "Usuário não está logado.";
        exit(); // Ou redirecione para a página de login, por exemplo
    }

    // Preparar a declaração
    $stmt = $conexao->prepare("INSERT INTO tb_servicos (tipo_serv, nome_serv, valor, foto, fk_user) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdss", $tipoServico, $nomeServico, $valor, $foto, $idUsuarioLogado);

    // Executar a declaração
    if ($stmt->execute()) {
        // Atualize o tipo de usuário para "T" (Trabalhador) após o cadastro bem-sucedido
        $query = "UPDATE tb_usuarios SET tipo_user = 'T' WHERE id_user = $idUsuarioLogado";
        $conexao->query($query); // Execute a consulta de atualização
    
        echo "Dados inseridos com sucesso!";
        
        // Redirecione o usuário para a página inicial após o cadastro bem-sucedido
        header("Location: cadhr.php"); // Substitua "index.php" pelo URL correto da página inicial
        exit();
    } else {
        echo "Erro ao inserir os dados no banco de dados: " . $stmt->error;
    }

    // Fechar a declaração e a conexão
    $stmt->close();
    $conexao->close();
}
?>


        <!DOCTYPE html>
        <html lang="pt-BR">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>Cadastro HireIt</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

            <style>
                @import url('https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital@0;1&display=swap');
                @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap');

                @font-face {
                    font-family: Alef-Regular;
                    src: url(Alef/Alef-Regular.ttf);
                }
                html {
                    height: 100%;
                }
                body{
                    font-size: 100%;
                    background: linear-gradient(225deg, rgba(254, 0, 0, 0.20) 0%, rgba(3, 0, 158, 0.20) 100%);
                    height: 100%;
                }

                .logo{
                    color: rgb(27, 15, 0);
                    font-family: 'Poppins', sans-serif;
                    font-size: 100px;
                }

                .login{
                    background-color: rgba(0, 0, 0, 0.144);
                    position: absolute;
                    top: 50%;
                    left: 50%; 
                    transform: translate(-50%, -50%);
                    padding: 60px;
                    border-radius: 15px;
                }
                input{
                    padding: 15px;
                    border: none;
                    outline: none;
                    font-size: 15px;
                    color: rgb(27, 15, 0);
                    font-family: 'Poppins', sans-serif;
                    width: 100%;
                    background-color: transparent;
                    font-size: 25px;
                }
                .botao1{
                    background-color: transparent;
                    padding: 30px;
                    border: none;
                    outline: none;
                    color: rgb(27, 15, 0);
                    font-family: 'Poppins', sans-serif;
                    width: 50%;
                    font-size: 25px;
                }

                .info{
                    color: rgb(27, 15, 0);
                }

                form{
                    color: rgb(27, 15, 0);
                }
                .select{
                    font-family: 'Poppins', sans-serif;
                    font-size: 18px;
                    background-color: transparent;
                    outline: none;
                }
                .text_opcoes{
                    font-family: 'Poppins', sans-serif;
                    font-size: 18px;
                }
                .opcao{
                    background-color: transparent;
                    outline: none;
                }
                .text_foto{
                    font-family: 'Poppins', sans-serif;
                    font-size: 18px;
                }
                .foto{
                    font-family: 'Poppins', sans-serif;
                    font-size: 18px;
                    background-color: transparent;
                    outline: none;
                }
                .text_valor{
                    font-family: 'Poppins', sans-serif;
                    font-size: 18px;
                }

            </style>
        </head>
        <body>
        <script>
            $(document).ready(function(){
                $('#valor').mask('R$ 0.000,00', {reverse: true});
            });
        </script>
n 
            <div class="fundo-login">
                <div class="login">
                    <h1 class="logo"> HIREit</h1>
                    <br>
                    <h6 class="info">Para finalizar seu cadastro como prestador de serviço necessitamos de algumas informações, que irão ser analisadas e aprovadas, favor preencher o formulario abaixo:</h6>
                    <br><br>

                    <form method="POST" action="cadtrab.php" enctype="multipart/form-data">
                        <label class="text_opcoes" for="opcoes">Qual o serviço prestado?:</label>
                        <select class="select" name="tipo_nome_servico">
                            <option value="Jardineiro - Jardineiro">Jardineiro</option>
                            <option value="Manicure - Manicure">Manicure</option>
                            <option value="Cortador de Cabelo - Cortador de Cabelo">Cabeleireiro</option>
                        </select><br>
                        <label class="text_valor" for="valor">Valor:</label>
                        <input type="text" class="valor" id="valor" name="valor" required>  
                        <label class="text_foto" for="foto">Escolha uma foto:</label>
                        <input type="file" name="foto" accept="image/*">
                        <input type="hidden" name="fk_user" value="<?php echo obterIdUsuarioLogado(); ?>" readonly>

                        <input class="botao1" type="submit" value="Cadastrar Trabalhador" href="index.php">
                    </form>

                </div>
            </div>
        </body>
        </html>