<?php 
require_once 'lock.php'; // garante que somente usuário logado acesse a página

if (!isset($_GET['id_receita'])) {
    header('location:restrita.php?codigo=1');
    exit;
}

// recebe parâmetro via GET convertendo-o para int
$id_receita = (int)$_GET['id_receita'];

require_once 'conexao.php';

$conn = conectar_banco();

$id_usuario = $_SESSION['id'];

// Alterando a consulta SQL para deletar uma receita
$sql = "DELETE FROM tb_receitas WHERE id_receita = $id_receita 
        AND usuario_id = $id_usuario";

mysqli_query($conn, $sql);

$linhas = mysqli_affected_rows($conn);

if ($linhas <= 0) { // verifica se há erro na consulta SQL
    header('location:restrita.php?codigo=5');
    exit;
}

header('location:restrita.php');
?>
