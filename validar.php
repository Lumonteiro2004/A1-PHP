<?php
require_once 'functions.php';

// se chegarmos na página via GET, retornaremos à home
if (form_nao_enviado()) {
    header('location:index.php?codigo=1');
    exit;
}

// se há campos em branco no form de login
if (form_em_branco()) {
    header('location:index.php?codigo=2');
    exit;
}

// receber dados do form de login
$usuario = $_POST['usuario'];
$senha   = $_POST['senha'];

// acesso ao banco de dados
require_once 'conexao.php';

// conectar ao banco de dados
$conn = conectar_banco();

// criar consulta para selecionar apenas as colunas necessárias
$sql = "SELECT id, usuario, senha FROM tb_usuarios WHERE usuario = ? AND senha = ?";

// preparar declaração (statement) de consulta
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) { // se ocorreu um erro ao preparar a consulta SQL
    header('location:index.php?codigo=4');
    exit;
}

// realizar a associação (bind) dos parâmetros na consulta do statement
mysqli_stmt_bind_param($stmt, "ss", $usuario, $senha);

// executar a consulta com o statement preparado e com o bind realizado
if (!mysqli_stmt_execute($stmt)) { // se retornou 'false', é porque ocorreu algum erro com o SQL
    header('location:index.php?codigo=4');
    exit;
}

// após executar a consulta, vamos solicitar que o statement registre (salve) o 
// número de linhas afetadas pela consulta
mysqli_stmt_store_result($stmt); 

// armazenar o número de linhas afetadas que foram registradas acima
$linhas = mysqli_stmt_num_rows($stmt); // Use num_rows para SELECT

// verificar se as linhas afetadas = zero -> significa que não foi encontrado
// o usuário e senha digitados no form
if ($linhas <= 0) {
    header('location:index.php?codigo=3');
    exit; // finalizamos a execução do script
}

// pedir para associar o retorno do select em variáveis locais
mysqli_stmt_bind_result($stmt, $id, $usuario, $senha);

// agora, é necessário dar um 'fetch' para armazenar o resultado nas variáveis
mysqli_stmt_fetch($stmt);

// iniciar a sessão
session_start();

// registrar dados da sessão
$_SESSION['id']      = $id;
$_SESSION['usuario'] = $usuario;
$_SESSION['senha']   = $senha;

// redirecionar para a página restrita
header('location:restrita.php');
exit;
?>
