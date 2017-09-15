<?php
require_once("../exception/BusinessException.php");
require_once("../dao/CountDAO.php");

class CountService{

    private $countDAO;

    public function __construct() {
        $this->countDAO = new CountDAO();
    }

    public function inserir(CountDTO $count) {
        $count->setData(date("Y-m-d G:i:s"));

        $erros = array();
        if(!$count->tipoIsValid()){
            array_push($erros, "Tipo inválido.");
        }
        else if($count->getTipo() == "produto" && $count->getIdReferencia() == null){
            array_push($erros, "Produto indefinido.");
        }

        if(sizeof($erros) > 0){
            throw new BusinessException($erros);
        }

        if ($count->getReferrer() != null && sizeof($count->getReferrer()) == 0) {
            $count->setReferrer(null);
        }

        $count->setIp(getIp());
        $this->countDAO->insere($count);
    }

    public function listar() {
        return $this->countDAO->listar();
    }
}