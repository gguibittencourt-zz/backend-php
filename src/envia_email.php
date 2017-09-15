<?php

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$config = Constants::getConstantsMail();
$contato = new ContatoDTO();

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = $config->host;  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = $config->username;                 // SMTP username
$mail->Password = $config->password;                           // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = $config->port;                                    // TCP port to connect to

$mail->setFrom($config->username, $config->name);
$mail->addAddress($contato->getEmail(), $contato->getNome());     // Add a recipient

$mail->isHTML(false);                                  // Set email format to HTML

$mail->Subject = $contato->getAssunto();
$mail->Body = $contato->getMensagem();
$mail->AltBody = $contato->getMensagem();

if(!$mail->send()) {
    log_contato_sended_fail("ENVIAR EMAIL -> " . $mail->ErrorInfo);
} else {
    log_contato_sended("ENVIAR EMAIL -> " . $contato->getNome() . "\n". $contato->getAssunto());
}



function formatLog(ContatoDTO $contato, $erro = null){
    $nome = $contato->getNome();
    $assunto = $contato->getAssunto();
    $email = $contato->getEmail();
    $mensagem = $contato->getMensagem();


    $log = "-------------------------------------"."\n".
        "Nome: {$nome}"."\n".
        "E-mail: {$email}"."\n".
        "Assunto: {$assunto}"."\n".
        "Mensagem: {$mensagem}"."\n";

    if($erro != null){
        $log .= "Erro: {$erro}"."\n";
    }

    return $log."\n".
        "-------------------------------------";
}