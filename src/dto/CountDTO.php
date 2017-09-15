<?php

class CountDTO{
    private $id_count;
    private $count;
    private $tipo;
    private $data;
    private $ip;
    private $referrer;
    private $code;
    private $id_referencia;

    public function __construct() { }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param mixed $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * @return mixed
     */
    public function getIdCount() {
        return $this->id_count;
    }

    /**
     * @param mixed $id_count
     */
    public function setIdCount($id_count) {
        $this->id_count = $id_count;
    }

    /**
     * @return mixed
     */
    public function getCount() {
        return $this->count;
    }

    /**
     * @param mixed $count
     */
    public function setCount($count) {
        $this->count = $count;
    }

    /**
     * @return mixed
     */
    public function getTipo() {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    /**
     * @return mixed
     */
    public function getData() {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data) {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getIdReferencia() {
        return $this->id_referencia;
    }

    /**
     * @param mixed $id_referencia
     */
    public function setIdReferencia($id_referencia) {
        $this->id_referencia = $id_referencia;
    }

    /**
     * @return mixed
     */
    public function getReferrer()
    {
        return $this->referrer;
    }

    /**
     * @param mixed $referrer
     */
    public function setReferrer($referrer)
    {
        $this->referrer = $referrer;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    public function tipoIsValid(){
        return $this->tipo == "site" || $this->tipo == "produto";
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