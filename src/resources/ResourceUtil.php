<?php
require_once("../util/funcoes_uteis.php");
require_once("../services/RequestService.php");
//require_once("../services/AuthorizationService.php");
session_start();

function getRequestMode(){
    return $_SERVER['REQUEST_METHOD'];
}
function getLocale(){
    if(isset($_SERVER['HTTP_LOCALE_USER']))
        return $_SERVER['HTTP_LOCALE_USER'];

    return "en_us";
}

define("LOCALE", getLocale());
define("GRUPO_USER_ID", 1);

function saveRequest(){
    if(getRequestMode() == "OPTIONS") return;

    $requestService = new RequestService();
    $requestDTO = new RequestDTO();

    $content = file_get_contents("php://input");
    if(!is_null_or_empty($content)){
        $requestDTO->setContent($content);
    }

    if(isset($_SERVER["HTTP_USER_AGENT"])){
        $requestDTO->setUserAgent($_SERVER["HTTP_USER_AGENT"]);
    }

    if(isset($_SERVER["CONTENT_TYPE"])) {
        $requestDTO->setContentType($_SERVER["CONTENT_TYPE"]);
    }

//    if(isset($_SERVER['HTTP_AUTH_TOKEN'])) {
//        $authorizationService = new AuthorizationService();
//        $token = $authorizationService->decriptTokenUser(true);
//        if($token != null) {
//            $requestDTO->setToken($_SERVER['HTTP_AUTH_TOKEN']);
//            $requestDTO->setIdUsuario($token->id_usuario);
//        }
//    }

    $requestDTO->setIp(getIp());

    if(isset($_SERVER["HTTP_REFERER"])) {
        $requestDTO->setOrigin($_SERVER["HTTP_REFERER"]);
    }

    $requestDTO->setRequestMethod($_SERVER['REQUEST_METHOD']);
    $requestDTO->setUrl($_SERVER["REQUEST_SCHEME"]."://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);

    $requestDTO->setHeaders(json_encode(apache_request_headers()));
    $requestService->insert($requestDTO);
}

function getData(){
    return json_decode(file_get_contents("php://input"));
}

function isAutenticado(){
    return isset($_SESSION['usuario']);
}

function resourceWithUserOption(){
    if(getRequestMode() == "OPTIONS") die;

    try{
        $authorizationService = new AuthorizationService();
        $authorizationService->login();
    }catch (BusinessException $e){
    }

}

function resourcePrivate(){
    if(getRequestMode() == "OPTIONS")
        die;

    try{
        $authorizationService = new AuthorizationService();
        $authorizationService->login();
    }catch (BusinessException $e){
    }
    if(!isAutenticado()) {
        http_response_code(401);
        die;
    }
}

function getHttpAuth(){
    return $_SERVER['HTTP_AUTHORIZATION'];
}

function returnError($erros, $code = 400){
    $retorno = createErros($erros, "errors-validation");

    print_r(json_encode($retorno));
    http_response_code($code);
    die;
}

function createErros($erros, $type){
    $error = new StdClass();
    $error->type = $type;
    $error->errors = $erros;

    $data = new StdClass();
    $data->error = $error;

    $retorno = new StdClass();
    $retorno->data = $data;
    return $retorno;
}

function responseJson($dados){
    $retorno = new StdClass();
    $retorno->data = $dados;
    print_r(json_encode($retorno));
}

date_default_timezone_set('America/Sao_Paulo');
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With,authorization, Content-Type,Auth-Token, Accept");
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

try{
    saveRequest();
}catch (BusinessException $bu){
    returnError($bu->getErros());
}