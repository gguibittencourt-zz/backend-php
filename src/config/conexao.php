<?php
require_once 'Connection.class.php';
function getPDO (){
   return Connection::getInstance();
}