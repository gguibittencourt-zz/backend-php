<?php
require_once 'funcoes_uteis.php';
@$dado = $_GET['dado'];
if(isset($dado)){
    print_r(gerarHash($dado));
}