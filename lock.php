<?php
session_start();

// Verifica se o usuário está autenticado para acessar áreas restritas do sistema de receitas
if (!isset($_SESSION['id']) || !isset($_SESSION['usuario']) || !isset($_SESSION['senha'])) {
    header('location:index.php?codigo=1'); // redireciona para página de login com código de erro
    exit;
}
?>
