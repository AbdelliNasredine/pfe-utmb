<?php

namespace App\Email;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;


class Emailer
{
    /*
     * méthod send qui envoi un email vers un autre email
     *      @from : e-mail de envoiyeur
     *      @to : e-mail de distanitaire
     *      @name : nom de distanitaire
     *      @title : titre de message e-mail
     *      @messsage : contenu d'e-mail
     */
    public function send($from, $to, $name, $title, $message)
    {
        $config = require 'config.phpmailer.php';
        $mail = new PHPMailer(true);
        try {

            //Serveur config
            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host = $config['phpmailer']['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $config['phpmailer']['username'];
            $mail->Password = $config['phpmailer']['password'];
            $mail->SMTPSecure = $config['phpmailer']['secure'];
            $mail->Port = $config['phpmailer']['port'];

            //Recipient
            $from = $from == null ? $config['phpmailer']['username'] : $from;
            $to = $to == null ? $config['phpmailer']['username'] : $to;
            $mail->setFrom($from, $name);
            $mail->addAddress($to);

            //contenu de e-mail
            $mail->isHTML(true);
            $mail->Subject = $title;
            $mail->Body = $message;
            $mail->AltBody = $message;

            $mail->send();
            return true;
        } catch (Exception $e) {
            // echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
            return false;
        }
    }

}
