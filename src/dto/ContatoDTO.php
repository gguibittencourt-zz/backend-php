<?php

class ContatoDTO{
    private $id_contato;
    private $nome;
    private $email;
    private $assunto;
    private $mensagem;
    private $lido;
    private $ip_endereco;
    private $id_usuario;
    private $data_criacao;

    public function __construct() { }

    public function getIdContato() {
        return $this->id_contato;
    }
    public function setIdContato($id_contato) {
        $this->id_contato = $id_contato;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getAssunto() {
        return $this->assunto;
    }

    public function setAssunto($assunto) {
        $this->assunto = $assunto;
    }

    public function getMensagem() {
        return $this->mensagem;
    }

    public function setMensagem($mensagem) {
        $this->mensagem = $mensagem;
    }

    public function getLido() {
        return $this->lido;
    }

    public function setLido($lido) {
        $this->lido = $lido;
    }

    public function getIpEndereco() {
        return $this->ip_endereco;
    }

    public function setIpEndereco($ip_endereco) {
        $this->ip_endereco = $ip_endereco;
    }

    public function getDataCriacao() {
        return $this->data_criacao;
    }

    public function setDataCriacao($data_criacao) {
        $this->data_criacao = $data_criacao;
    }

    /**
     * @return mixed
     */
    public function getIdUsuario()
    {
        return $this->id_usuario;
    }

    /**
     * @param mixed $id_usuario
     */
    public function setIdUsuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;
    }

    public function setByObj($data) {
        if($data == false) return $this;
        foreach ($data AS $key => $value) $this->{$key} = $value;

        return $this;
    }

    public function toJson(){
        return json_encode(get_object_vars($this));
    }

}