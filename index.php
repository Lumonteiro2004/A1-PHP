<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receitas Culinárias - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>
<body class="container">

    <h1>Receitas Culinárias - Login</h1>

    <nav>
        <a href="index.php">Home</a> |
        <a href="restrita.php">Página Restrita</a>
    </nav>

    <?php
        require_once 'functions.php';

        validar_codigo();

        // se não estiver vazia a sessão (significa que está logado)
        if (!empty($_SESSION)) {
            exit("<h3>Bem-vindo, ". $_SESSION['usuario'] ."! Acesse a área de receitas!</h3>"); // então não exiba mais nada nesse script
        }
        // se a sessão está vazia, significa que não está logado.
        // então, mostramos o form de login
    ?>

    <h2>Para acessar a área de receitas, informe seus dados abaixo:</h2>

    <form action="validar.php" method="post">

        <p>
            <label for="usuario">Usuário:</label><br>
            <input type="text" name="usuario" id="usuario" required>
        </p>

        <p>
            <label for="senha">Senha:</label><br>
            <input type="password" name="senha" id="senha" required>
        </p>

        <button type="submit" class="btn btn-outline-success">Logar</button>

    </form>
    
</body>
</html>
