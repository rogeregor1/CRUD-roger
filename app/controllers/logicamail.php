<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
require '../config/setting.php';
require '../lib/db.php';

if (isset($_POST['send'])):

    if (!empty($_POST['email'])) {
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $Usuario = ConsultarUsuarioPorEmail($_POST['email']);
            if (count($Usuario) > 0) {
                //enviar el correo
                $token_ = bin2hex(random_bytes(32)); // genera 64 characters long string /^[0-9a-f]{64}$/

                if (updateUser($token_, TIEMPO_VIDA, $Usuario[0]->usuario_id)); {
                    //mandamos actualizar 
                    EnviarCorreoResetPassword($Usuario[0]->usuario_email, $Usuario[0]->usuario_usuario, $Usuario[0]->usuario_id, $token_);
                }
            } else {
                $_SESSION['response'] = "no existe el usuario";
                header("location: ../recuperarClave.php");
            }
        } else {
            $_SESSION['response'] =  "lo que escribiste no es un email valido";
            header("location: ../recuperarClave.php");
        }
    } else {
        $_SESSION['response'] =  "ingrese su correo electronico";
        header("location: ../recuperarClave.php");
    }
    
endif;



// metodo que consulta al usuario su correo
function ConsultarUsuarioPorEmail($email)
{
    $pdo = new Db;
    //consultamos

    $sql = "SELECT * FROM usuario WHERE usuario_email=:email";

    try {
        $smtp = $pdo->conexion()->prepare($sql);
        $smtp->bindParam(":email", $email);
        $smtp->execute();

        return $smtp->fetchAll(PDO::FETCH_OBJ);

    } catch (\Throwable $th) {
        echo $th->getMessage();
    } /*finally {
        $pdo->closeDataBase();
    }*/
}


//actualizar Usurio
function updateUser($token, $tiempo_vida, $User_Id)
{
    $conex = new Db;
    $Valor = "1";
    $query = "UPDATE usuario SET request_password=:request_pass, token_password=:token_pass, expired_session=:expired WHERE usuario_id= :id_usuario";
    try {
        $smtp = $conex->conexion()->prepare($query);

        $smtp->bindParam(":request_pass", $Valor);
        $smtp->bindParam(":token_pass", $token);
        $smtp->bindParam(":expired", $tiempo_vida);
        $smtp->bindParam(":id_usuario", $User_Id);
        return $smtp->execute();
    } catch (\Throwable $th) {
        echo $th->getMessage();
    } 
}


//envio de correo electronico
function EnviarCorreoResetPassword($Correo, $NombreReceptor, $userid, $token_User)
{
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = HOST;                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = USERNAME;                     //SMTP username
        $mail->Password   = PASSWORD;                               //SMTP password
        $mail->SMTPSecure = SMTP_SECURE;            //Enable implicit TLS encryption
        $mail->Port       = PORT;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('Soporte@gmail.com', 'Soporte');
        $mail->addAddress($Correo, $NombreReceptor);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Reset de password';
        $mail->Body    = 'Ud. solicito reset password <b>
        <a href="http://localhost/ANIMCOMIC/cambiar_password.php?id='.$userid.'&&token='.$token_User.'">cambiar password aqui</a></b>';
        
        $mail->send();
        echo 'Message enviado';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>