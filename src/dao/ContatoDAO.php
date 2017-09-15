<?php
require_once("../config/conexao.php");
require_once("../dto/ContatoDTO.php");

class ContatoDAO{

    function inserir(ContatoDTO $contato) {
        $conn = getPDO();

        $stmt = $conn->prepare('INSERT INTO en_contato(nome,email, mensagem,data_criacao, ip_endereco,  status)
                                    VALUES (:nome,:email,:mensagem,:data_criacao, :ip_endereco, :status)');
        $stmt->execute(array(
            ':nome' => $contato->getNome(),
            ':email' => $contato->getEmail(),
            ':mensagem' => $contato->getMensagem(),
            ':data_criacao' => $contato->getDataCriacao(),
            ':ip_endereco' => $contato->getIpEndereco(),
            ':status' => "ativo"
        ));

        return $conn->lastInsertId();
    }

    function setLido(ContatoDTO $contato) {
        $conn = getPDO();
        $stmt = $conn->prepare('UPDATE en_contato SET lido = :lido WHERE id_contato = :id_contato ');

        $stmt->execute(array(
            ':lido' => $contato->getLido(),
            ':id_contato' => $contato->getIdContato()
        ));

        return $stmt->rowCount();
    }
    function delete(ContatoDTO $contato) {
        $conn = getPDO();
        $stmt = $conn->prepare('UPDATE en_contato SET status = :status WHERE id_contato = :id_contato ');

        $stmt->execute(array(
            ':status' => "inativo",
            ':id_contato' => $contato->getIdContato()
        ));

        return $stmt->rowCount();
    }

    function listar() {
        $conn = getPDO();
        $stmt = $conn->query("SELECT * FROM shop_en_contato WHERE status != 'inativo';");
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
}