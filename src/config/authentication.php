<?php
require_once '../util/funcoes_uteis.php';
require_once 'conexao.php';
header('Content-Type: text/html; charset=utf-8');
$username = null;
$password = null;

if(isset($_GET['logout']) && $_GET['logout'] = 'yes'){
    unset($_SERVER['PHP_AUTH_USER']);
    unset($_SERVER['PHP_AUTH_PW']);
    unset($_SERVER['HTTP_AUTHORIZATION']);
    die("Token cancelado !");
}

if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
    $username = $_SERVER['PHP_AUTH_USER'];
    $password = gerarHash($_SERVER['PHP_AUTH_PW']);
} elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {
    if (strpos(strtolower($_SERVER['HTTP_AUTHORIZATION']),'basic') === 0)
        list($username,$password) = explode(':',base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));
}

$token = generate_token($username, $password);
if (!valid_user($token) || !isLoginSessionExpired()) {
    header('WWW-Authenticate: Basic realm="Faça login para acessar o recurso."');
    header('HTTP/1.0 401 Unauthorized');
    die("Token Inválido");
}

function valid_user($token){
    list($user, $senha, $time) = explode(":",base64_decode($token));
    $usuario = getUsuario($user, $senha, getPDO());
    if($usuario == 'false')
        return false;
    $usuario = json_decode($usuario);
    return $usuario->id_usuario > 0;
}
function generate_token($username, $password){
    $time = time();
    return base64_encode("{$username}:{$password}:{$time}");
}

function login(){
    $_SESSION['loggedin_time'] = time();
}
function isLoginSessionExpired() {
    $login_session_duration = 10;
    return ((time() - @$_SESSION['loggedin_time']) > $login_session_duration);
}