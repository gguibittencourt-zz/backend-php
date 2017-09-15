<?php
require_once("ResourceUtil.php");
require_once("../services/ContatoService.php");
$contatoService = new ContatoService();
$contato = new ContatoDTO();
$contato->setByObj(getData());
try{
    if(getRequestMode() == "GET"){
    }else if(getRequestMode() == "POST"){
        $contatoService->inserir($contato);
        http_response_code(201);
    }else if(getRequestMode() == "PUT") {
    }else if(getRequestMode() == "DELETE"){
    }
}catch(BusinessException $e){
    returnError($e->getErros());
}




