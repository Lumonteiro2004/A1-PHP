<?php 
session_start(); // Inicia a sessão

// Limpa todas as variáveis de sessão
unset($_SESSION);

// Destrói a sessão
session_destroy();

// Redireciona o usuário para a página de login
header('location:index.php');
exit; // Adiciona exit para garantir que o script não continue a execução
?>
