<?php

class Constants
{

    private static $tipo = "dev";

    public function getConstantsDB()
    {
        if (self::$tipo == "dev")
            return self::getConstantsDBDev();
        else
            return self::getConstantsDBProd();
    }

    public static function getConstantsMail()
    {
        $obj = new StdClass();
        $obj->username = "contato@freiredesign.com";
        $obj->password = "";
        $obj->name = "Contato | Freire Design";
        $obj->host = "";
        $obj->port = 587;
        return $obj;
    }

    private function getConstantsDBDev()
    {
        $obj = new StdClass();
        $obj->servidor = "localhost";
        $obj->dbName = "freiredesign";
        $obj->password = "";
        $obj->username = "root";
        return $obj;
    }

    //Para dominio controle.freiredesign.com
    private function getConstantsDBProd()
    {
        $obj = new StdClass();
        $obj->servidor = "";
        $obj->dbName = "";
        $obj->password = "";
        $obj->username = "";
        return $obj;
    }

    public static function getEncriptKey()
    {
        return "EAtu8nERu6HbWh4jSlTq";
    }
}