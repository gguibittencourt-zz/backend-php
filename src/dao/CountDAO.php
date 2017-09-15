<?php
require_once("../config/conexao.php");

class CountDAO{

    public function insere(CountDTO $countDTO) {
        $conn = getPDO();
        $stmt = $conn->prepare('INSERT INTO en_count (tipo, data, ip, code, referrer, id_referencia) VALUES (:tipo, :data, :ip,:code, :referrer, :id_referencia)');
        $stmt->execute(array(
            ':data' => $countDTO->getData(),
            ':id_referencia' => $countDTO->getIdReferencia(),
            ':ip' => $countDTO->getIp(),
            ':code' => $countDTO->getCode(),
            ':referrer' => $countDTO->getReferrer(),
            ':tipo' => $countDTO->getTipo()
        ));
        return $stmt->rowCount();
    }

    function listar() {
        $conn = getPDO();
        $stmt = $conn->query("SELECT * FROM en_count ORDER BY data DESC ;");
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

}