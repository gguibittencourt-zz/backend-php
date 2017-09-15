<?php
//require_once('../lib/CryptoLib.php');

function gerarHash($dado)
{
    return hash('whirlpool', $dado);
}
function is_null_or_empty($var){
    return $var == null || $var == "";
}


function getUsuario($login, $senha, $conn)
{
    if(is_null($conn))
        $conn = Connection::getInstance();
    try {
        $stmt = $conn->prepare('SELECT usu.*, log.data as dateUltimoLogin, log.ip as ipUltimoLogin FROM en_usuario as usu LEFT JOIN en_login as log ON usu.id_usuario = log.id_usuario WHERE usu.login= :login AND usu.senha = :senha');
        $stmt->execute(array(
            ':login' => $login,
            ':senha' => $senha
        ));
        $result = $stmt->fetch(PDO::FETCH_OBJ);

        if (count($result)) {
            return json_encode($result);
        } else {
            $erro = new StdClass();
            $erro->mensagem = "Nenhum resultado retornado";
            return json_encode($erro);
        }
    } catch (PDOException $e) {
        $mensagem = new StdClass();
        $erro = new StdClass();
        $mensagem->$erro->mensagem = $e->getMessage();
        $mensagem->$erro->tipo = 0;
        return json_encode($erro);
    }
}

function trocar_acentos($imagem)
{
    $imagem = str_replace(' ', '_', $imagem);
    $imagem = str_replace('á', 'a', $imagem);
    $imagem = str_replace('ã', 'a', $imagem);
    $imagem = str_replace('â', 'a', $imagem);
    $imagem = str_replace('ä', 'a', $imagem);
    $imagem = str_replace('à', 'a', $imagem);
    $imagem = str_replace('Á', 'a', $imagem);
    $imagem = str_replace('À', 'a', $imagem);
    $imagem = str_replace('Ã', 'a', $imagem);
    $imagem = str_replace('Â', 'a', $imagem);
    $imagem = str_replace('Ä', 'a', $imagem);
    $imagem = str_replace('ç', 'c', $imagem);
    $imagem = str_replace('Ç', 'c', $imagem);
    $imagem = str_replace('é', 'e', $imagem);
    $imagem = str_replace('É', 'e', $imagem);
    $imagem = str_replace('í', 'i', $imagem);
    $imagem = str_replace('Í', 'i', $imagem);
    $imagem = str_replace('ó', 'o', $imagem);
    $imagem = str_replace('Ó', 'o', $imagem);
    $imagem = str_replace('ú', 'u', $imagem);
    $imagem = str_replace('Ú', 'u', $imagem);
    $imagem = strtolower($imagem);

    return $imagem;
}

function apagarSessoes()
{
    session_destroy();
    session_write_close();
}


function salvar_log($tipo, $message, $arquivo){
    date_default_timezone_set('America/Sao_Paulo');
    $msg = date('d-m-Y H:i:s') . " - ".$tipo." - ".$message;
    error_log("\n".$msg, 3, "../logs/erros-{$arquivo}.log");
}

function log_cliente($message){
    salvar_log("CLIENTE", $message, "cliente");
}
function log_servico($message){
    salvar_log("SERVIÇO", $message, "servico");
}
function log_produto($message){
    salvar_log("PRODUTO", $message, "produto");
}
function log_produto_public($message){
    salvar_log("PRODUTO", $message, "produto-public");
}
function log_contato($message){
    salvar_log("CONTATO", $message, "contato");
}
function log_contato_sended($message){
    salvar_log("CONTATO-SENDED", $message, "contato-sended");
}
function log_contato_sended_fail($message){
    salvar_log("CONTATO-SENDED-FAIL", $message, "contato-sended-fail");
}
function log_count($message){
    salvar_log("COUNT", $message, "count");
}
function log_contato_public($message){
    salvar_log("CONTATO", $message, "contato");
}
function log_despesa($message){
    salvar_log("DESPESA", $message, "despesa");
}
function log_auth($message){
    salvar_log("AUTENTICAÇÃO", $message, "login");
}

function create_class($data){
    $class = new StdClass();
    if($data == false) return $class;
    foreach ($data AS $key => $value) $class->{$key} = $value;

    return $class;
}

function criarImagemProduto($base64, $nome){
    file_put_contents('../../../produtos/'.$nome, base64_decode($base64));
}

function getIp(){
    if(isset($_SERVER["REMOTE_ADDR"])){
        return $_SERVER["REMOTE_ADDR"];
    }
    return null;
}