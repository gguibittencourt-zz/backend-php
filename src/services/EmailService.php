<?php
require_once("../dto/ContatoDTO.php");
require_once '../lib/phpmailer/PHPMailerAutoload.php';
require_once '../config/Constants.class.php';
require_once '../util/funcoes_uteis.php';

class EmailService
{

    public function __construct(){
    }

    public function send(ContatoDTO $contato){

        $mail = new PHPMailer;

        //$mail->SMTPDebug = 3;                               // Enable verbose debug output

        $config = Constants::getConstantsMail();

//        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = $config->host;  // Specify main and backup SMTP servers
//        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $config->username;                 // SMTP username
//        $mail->Password = $config->password;                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = $config->port;                                    // TCP port to connect to
        $mail->CharSet = "UTF-8";

        $mail->setFrom($config->username, $config->name);
        $mail->addAddress($config->username, $contato->getNome());     // Add a recipient

        $mail->isHTML(false);                                  // Set email format to HTML

        $mail->Subject = $contato->getAssunto();
        $mail->Body = $this->getTemplateHtml($contato);
        $mail->AltBody = $this->formatLog($contato, null);

        if (!$mail->send()) {
            log_contato_sended_fail($this->formatLog($contato, $mail->ErrorInfo));
        } else {
            log_contato_sended($this->formatLog($contato, null));
        }

    }

    function getTemplateHtml(ContatoDTO $contato){

        $nome = $contato->getNome();
        $email = $contato->getEmail();
        $assunto = $contato->getAssunto();
        $mensagem = $contato->getMensagem();

        ob_start();
        include "../email/contato_template.php";
        $template = ob_get_contents();
        ob_end_clean();

        return $template;
    }

    private function formatLog(ContatoDTO $contato, $erro = null)
    {
        $nome = $contato->getNome();
        $assunto = $contato->getAssunto();
        $email = $contato->getEmail();
        $mensagem = $contato->getMensagem();


        $log = "-------------------------------------" . "\n" .
            "Nome: {$nome}" . "\n" .
            "E-mail: {$email}" . "\n" .
            "Assunto: {$assunto}" . "\n" .
            "Mensagem: {$mensagem}" . "\n";

        if ($erro != null) {
            $log .= "Erro: {$erro}" . "\n";
        }

        return $log . "\n" .
        "-------------------------------------";
    }
}