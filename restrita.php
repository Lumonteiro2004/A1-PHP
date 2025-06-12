<?php require_once 'lock.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receitas Culinárias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>
<body class="container">
    
    <h1>Receitas Culinárias</h1>

    <nav>
        <a href="index.php">Home</a> | 
        <a href="restrita.php">Página Restrita</a> | 
        <a href="logout.php">Logout</a>
    </nav>

    <h2>Bem-vindo, <?= $_SESSION['usuario']; ?>!</h2>

    <?php
        require_once 'functions.php';

        validar_codigo();
    ?>

    <form action="cadastrar_receita.php" method="post">
        <p>
            <label for="receita">Nome da Receita:</label> 
            <input type="text" name="receita" id="receita" required> 
            <button type="submit" class="btn btn-outline-success btn-sm">Cadastrar</button>
        </p>
    </form>

    <?php
        require_once 'conexao.php';

        $conn = conectar_banco();

        $id = $_SESSION['id']; // armazena id do usuário logado

        // cria select para buscar receitas do usuário logado
        $sql = "SELECT id_receita, receita FROM tb_receitas 
                WHERE usuario_id = $id";
        
        $resultado = mysqli_query($conn, $sql);

        $linhas = mysqli_affected_rows($conn);

        if ($linhas < 0) { // verifica se há erro na consulta SQL
            exit ("<h3>Erro ao buscar suas receitas. 
            Acione o suporte ou tente novamente mais tarde</h3>");
        }

        if ($linhas == 0) { // verifica se não há receitas cadastradas
            exit("<h3>Você não possui receitas cadastradas</h3>");
        }

        echo '<div class="row">';
        echo '<div class="col-md-4">';
        echo '<table class="table table-striped">';
        while ($receita_atual = mysqli_fetch_assoc($resultado)) {
            $id_receita = $receita_atual['id_receita'];
            echo '<tr>';
            echo '<td>' . $receita_atual['receita'] . '</td>';
            echo '<td>';
            echo '<a class="btn btn-danger btn-sm" href="deletar_receita.php?id_receita='.$id_receita.'">x</a>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
        echo '</div>';
        echo '</div>';
    ?>

</body>
</html>
