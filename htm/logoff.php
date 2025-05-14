<?php
// Inicie a sessão (se já não estiver iniciada)
session_start();

// Destrua todas as variáveis de sessão (limpe a sessão)
session_destroy();

// Redirecione o usuário para a página de login ou página inicial (substitua o URL apropriado)
header("Location: index.php"); // Você pode redirecionar para onde preferir após o logoff
exit; // Certifique-se de sair do script para evitar execução adicional
?>