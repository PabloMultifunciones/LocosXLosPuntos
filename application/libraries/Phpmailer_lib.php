<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter PHPMailer Class
 *
 * This class enables SMTP email with PHPMailer
 *
 * @category    Libraries
 * @author      CodexWorld
 * @link        https://www.codexworld.com
 */


class PHPMailer_Lib
{
    public function __construct(){
        log_message('Debug', 'PHPMailer class is loaded.');
    }

    private function generateProvisionalPassword(){
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($permitted_chars), 0, 6);
    }

    public function load($email){
        // Include PHPMailer library files
        require_once APPPATH.'third_party/PHPMailer/Exception.php';
        require_once APPPATH.'third_party/PHPMailer/PHPMailer.php';
        require_once APPPATH.'third_party/PHPMailer/SMTP.php';

        $provisionalPassword = $this->generateProvisionalPassword();
        
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        
        //Config mail
        $mail->IsSMTP(); 
        $mail->SMTPDebug = 0; 
        $mail->SMTPAuth = true; 
        $mail->SMTPSecure = 'ssl'; 
        $mail->Host = "locosxlospuntos.com.ar";
        $mail->AddAddress($email);
        $mail->CharSet = 'UTF-8';
        $mail->Port = 465;
        $mail->IsHTML(true);
        
        
        $mail->From = "info@locosxlospuntos.com.ar";
        $mail->Username = "info@locosxlospuntos.com.ar";
        $mail->Password = "Lb98bWenrRn7T7a";
        $mail->Subject = "LocosXLosPuntos - Codigo De Recuperacion";
        $mail->Body = ("
            <p>Hemos recibido tu solicitud de contraseña nueva.</p> 
            <p>Tu codigo de recuperacion es: <strong>".$provisionalPassword."</strong></p>
        ");
        
        $mail->Send();
        return $provisionalPassword;
    }
}

