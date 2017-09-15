<?php
class BusinessException extends Exception{

    private $erros = array();

    /**
     * BusinessException constructor.
     * @param array $erros
     */
    public function __construct($erros) {
        if(is_array($erros))
            $this->erros = $erros;
        else
            $this->erros = array($erros);
    }

    /**
     * @return array
     */
    public function getErros() {
        return $this->erros;
    }



}
