<?php
require_once("../services/UsuarioService.php");
require_once("../exception/BusinessException.php");
require_once("../util/funcoes_uteis.php");

class AuthorizationService
{
    private $usuarioService;

    public function __construct() {
        $this->usuarioService = new UsuarioService();
    }

    public function decriptTokenUser($regenToken){
        if(!isset($_SERVER['HTTP_AUTH_TOKEN'])) return null;
        $filter = new LoginFilter();
        $filter->setToken($_SERVER['HTTP_AUTH_TOKEN']);
        $login = $this->usuarioService->filtrarLogin($filter);

        $dataValida = strtotime($login->data_expiracao) > strtotime(date("Y-m-d G:i:s"));
        $ipValido = getIp() == $login->ip;

        if($login && $ipValido && $dataValida){
            if($regenToken){
                $this->usuarioService->regenToken($_SERVER['HTTP_AUTH_TOKEN']);
            }
            $tokenString = decriptTokenUser($_SERVER['HTTP_AUTH_TOKEN']);
            return json_decode($tokenString);
        }else if($login && !$ipValido){
            throw new BusinessException("Token inválido.");
        }else if($login && !$dataValida){
            throw new BusinessException("Token expirado.");
        }

        return null;
    }

    public function login() {
        $email = "";
        $senha = "";
        $tokenParam = null;
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            $email = $_SERVER['PHP_AUTH_USER'];
            $senha = $_SERVER['PHP_AUTH_PW'];
        } elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            if (strpos(strtolower($_SERVER['HTTP_AUTHORIZATION']), 'basic') === 0)
                list($email, $senha) = explode(':', base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));
        } else if (isset($_SERVER['HTTP_AUTH_TOKEN'])) {
            $token = $this->decriptTokenUser(true);
            if($token != null) {
                $tokenParam = $_SERVER['HTTP_AUTH_TOKEN'];
                $email = $token->email;
            }
        }

        $filter = new UsuarioFilter();
        $filter->setFieldsToken();
        $filter->addSenha();
        $filter->setEmail($email);
        $usuarios = $this->usuarioService->filtrar($filter);
        if (sizeof($usuarios) == 1) {
            $usuario = $usuarios[0];

            if ($tokenParam == null && decriptSenha($usuario->senha) != $senha) {
                $this->logout();
                return $this->returnUsuario(null);
            }

            unset($usuario->senha);

            $this->setTokenAndIp($usuario, $email, $senha, $tokenParam);
            $this->registraLogin($usuario, $tokenParam);
            return $this->returnUsuario($usuario);
        } else {
            $this->logout();
            return $this->returnUsuario(null);
        }
    }

    private function returnUsuario($usuario){
        if(isset($usuario))
            return $usuario;

        throw new BusinessException("E-mail ou senha inválidos.");
    }

    private function setTokenAndIp(&$usuario, $email, $senha, $tokenParam) {
        $usuario->ip = getIp();
        $token = new StdClass();
        $token->nome = $usuario->nome;
        $token->email = $email;
        $token->id_usuario = $usuario->id_usuario;
        $token->ip = getIp();
        $token->time = time() * 1000;
        if($tokenParam != null){
            $tokenString = $tokenParam;
        }else{
            $tokenString = generateTokenUser(json_encode($token));
        }
        $usuario->token = $tokenString;
    }

    private function registraLogin($usuario, $tokenParam) {
        $_SESSION["usuario"] = json_encode($usuario);
        if($tokenParam != null){
            $this->usuarioService->regenToken($tokenParam);
        }else {
            $this->usuarioService->registraLogin($usuario);
        }
    }

    public function logout() {
        unset($_SERVER['PHP_AUTH_USER']);
        unset($_SERVER['PHP_AUTH_PW']);
        unset($_SERVER['HTTP_AUTHORIZATION']);
        unset($_SESSION['usuario']);
    }

}