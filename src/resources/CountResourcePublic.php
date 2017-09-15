<?php
require_once("ResourceUtil.php");
require_once("../services/CountService.php");
require_once("../dto/CountDTO.php");
$countService = new CountService();
$count = new CountDTO();
$count->setByObj(getData());
try{
    if(getRequestMode() == "GET"){
    }else if(getRequestMode() == "POST"){
        $countService->inserir($count);
        http_response_code(201);
    }else if(getRequestMode() == "PUT") {
    }else if(getRequestMode() == "DELETE"){
    }
}catch(BusinessException $e){
    returnError($e->getErros());
}




