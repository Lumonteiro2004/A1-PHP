<?php 
require_once 'lock.php'; // garante que somente usuário logado acesse a página

require_once 'functions.php';

if (form_nao_enviado()) { // acessamos a página via GET
    header('location:restrita.php?codigo=1');
    exit;
}

if (receita_em_branco()) { // submetemos o form vazio
    header('location:restrita.php?codigo=2');
    exit;
}

$receita = $_POST['receita']; // armazena receita enviada via post
$id = $_SESSION['id']; // armazena id do usuário registrado na sessão

require_once 'conexao.php';

$conn = conectar_banco();
    
$sql = "INSERT INTO tb_receitas (receita, usuario_id)
        VALUES (?, ?)";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) { // se ocorreu um erro ao preparar o comando SQL
    header('location:restrita.php?codigo=4');
    exit;
}

// se ocorreu um erro ao associar os parâmetros à declaração
if (!mysqli_stmt_bind_param($stmt, "si", $receita, $id)) {
    header('location:restrita.php?codigo=4');
    exit;
}

// se ocorreu um erro ao executar o comando SQL declarado
if (!mysqli_stmt_execute($stmt)){
    header('location:restrita.php?codigo=4');
    exit;
}

// se passou por todas as validações acima, conseguimos realizar
// o INSERT com sucesso. Neste caso, apenas retornamos à página
// restrita, mas sem a necessidade de devolver qualquer código de erro
header('location:restrita.php');
?>
