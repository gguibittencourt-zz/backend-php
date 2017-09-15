<?php
require_once("../config/conexao.php");
require_once("../dto/RequestDTO.php");

class RequestDAO{

    function insert(RequestDTO $requestDTO) {
        $conn = getPDO();

        $stmt = $conn->prepare('INSERT INTO audit_en_request(request_method,user_agent,headers, content, url, content_type, ip, token, id_usuario, origin, data)
                                    VALUES (:request_method, :user_agent,:headers, :content, :url, :content_type, :ip, :token, :id_usuario, :origin, now())');
        $stmt->execute(array(
            ':request_method' => $requestDTO->getRequestMethod(),
            ':content' => $requestDTO->getContent(),
            ':user_agent' => $requestDTO->getUserAgent(),
            ':url' => $requestDTO->getUrl(),
            ':headers' => $requestDTO->getHeaders(),
            ':content_type' => $requestDTO->getContentType(),
            ':ip' => $requestDTO->getIp(),
            ':token' => $requestDTO->getToken(),
            ':id_usuario' => $requestDTO->getIdUsuario(),
            ':origin' => $requestDTO->getOrigin()
        ));

        return $stmt->rowCount();
    }
}