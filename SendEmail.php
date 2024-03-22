<?php
require 'vendor/autoload.php';
require_once 'DotEnvHandler.php';
use PHPMailer\PHPMailer\PHPMailer;
$dotOb = new DotenvHandler();
$dotOb->dotEnv();

/**
 * This class Implements Sending mail while Reset Password and Sending OTP.
 */
class SendEmail {

  /**
   * @var PHPMailer $mail
   *  Stores Object of PHPMailer class.
   */
  private $mail;

  /**
   * Initialize private instance $mail with object of PHPMailer class.
   */
  public function __construct() {
    $this->mail = new PHPMailer(TRUE);
  }

  /**
   * This Function is used to configure $mail object.
   * 
   * @param string $email
   *  Stores Email id of the User.
   */
  public function configureMail($email) {
    $this->mail->isSMTP();
    $this->mail->Host = 'smtp.gmail.com';
    $this->mail->SMTPAuth = TRUE;
    $this->mail->Username = $_ENV['emailUser'];
    $this->mail->Password = $_ENV['emailPass'];
    $this->mail->SMTPSecure = 'ssl';
    $this->mail->Port = 465;
    $this->mail->setFrom('sandip.poddar@innoraft.com');
    $this->mail->addAddress($email);
    $this->mail->isHTML(TRUE);
  }
  
  /**
   * This Function is used to Send Email for Reset User Password.
   * 
   * @param string $email
   *  Stores Email Id of User.
   * @param string $token_hash
   *  Stores hash value of Token.
   * 
   * @return bool
   */
  public function resetMail ($email, $token_hash) {
    $this->configureMail($email);
    $this->mail->Subject = 'Reset Password';
    $this->mail->Body = "click here to reset password -> http://site1/MOD_2-PHP_MYSQL/ResetPassword/ResetPassword.php?token=" . "$token_hash";
    if ($this->mail->send()) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * This Function implements for send mail for OTP validation during Signup.
   * 
   * @param string $email
   *  Stores Email Id of the User.
   * @param int $otp
   *  Stores value of Random Generated OTP.
   * 
   * @return bool
   */
  public function sendOtp ($email, $otp) {
    $this->configureMail($email);
    $this->mail->Subject = 'OTP for Email Validation.';
    $this->mail->Body = "Email Validation OTP is -> " . "$otp";
    if ($this->mail->send()) {
      return TRUE;
    }
    return FALSE;
  }
}
