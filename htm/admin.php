<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página com Botões</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital@0;1&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap');

        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f0f0f0;
        }

        .button-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .button {
            margin: 10px;
            padding: 15px 30px;
            font-size: 18px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body>
    <div class="button-container">
        <a href="crud_user.php" class="button">Usuários</a><br>
        <a href="crud_cid.php" class="button">Cidades</a><br>
        <a href="crud_serv.php" class="button">Serviços</a><br>
        <a href="crud_hora.php" class="button">Horários</a><br>
        <a href="crud_endereco.php" class="button">Endereços</a><br>
        <a href="crud_agenda.php" class="button">Agendas</a><br>
        <a href="crud_multVal.php" class="button">Multi Valorada </a><br>
    </div>
</body>

</html>
