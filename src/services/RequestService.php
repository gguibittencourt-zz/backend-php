<?php
require_once("../util/funcoes_uteis.php");
require_once("../dao/RequestDAO.php");
class RequestService{

    private $requestDAO;

    public function __construct() {
        $this->requestDAO = new RequestDAO();
    }

    public function insert(RequestDTO $requestDTO){
        $erros = array();

        if(is_null_or_empty($requestDTO->getRequestMethod())){
            array_push($erros, "Request Method Inválido.");
        }

        if(is_null_or_empty($requestDTO->getUrl())){
            array_push($erros, "URL indefinida.");
        }

        if(is_null_or_empty($requestDTO->getIp())){
            array_push($erros, "IP Indefinido.");
        }

        if(sizeof($erros) > 0){
            throw new BusinessException($erros);
        }

        return $this->requestDAO->insert($requestDTO);
    }
}