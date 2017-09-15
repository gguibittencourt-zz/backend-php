<?php
require_once("../services/EmailService.php");
require_once("../dao/ContatoDAO.php");
require_once("../dto/ContatoDTO.php");
require_once("../exception/BusinessException.php");
class ContatoService{

    private $contatoDAO;
    private $emailService;

    public function __construct() {
        $this->contatoDAO = new ContatoDAO();
        $this->emailService = new EmailService();
    }

    public function inserir(ContatoDTO $contato){
        $erros = array();

        if(is_null_or_empty($contato->getNome())){
            array_push($erros, "Nome indefinido.");
        }
        if(is_null_or_empty($contato->getEmail())){
            array_push($erros, "E-mail indefinido.");
        }
        if(is_null_or_empty($contato->getMensagem())){
            array_push($erros, "Mensagem indefinida.");
        }

        $contato->setDataCriacao(date("Y-m-d G:i:s"));
        if(isset($_SERVER["REMOTE_ADDR"])){
            $contato->setIpEndereco(getIp());
        }
        if(isset($_SESSION["usuario"])){
            $contato->setIdUsuario(json_decode($_SESSION["usuario"])->id_usuario);
        }
        if(sizeof($erros) > 0)
            throw new BusinessException($erros);

        $contato->setAssunto("Contato - Site Freire Design");
        $id_contato = $this->contatoDAO->inserir($contato);
        $this->emailService->send($contato);
        return $id_contato;
    }

    public function alterar($contato){
        return $this->contatoDAO->setLido($contato);
    }

    public function listar(){
        return $this->contatoDAO->listar();
    }

    public function excluir($contato){
        return $this->contatoDAO->delete($contato);
    }
}