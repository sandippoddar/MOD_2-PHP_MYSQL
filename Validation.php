<?php

require 'vendor/autoload.php';
use GuzzleHttp\Client;

/**
 * This class represents to validate every input field.
 */
class Validation {

  /**
   * Function to validate Email either it exist or not.
   * 
   * @param string $email
   *  Stores Email Id of user.
   * 
   * @return bool|string
   */
  public function isValidMail($email) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $apiKey = '875d5b6fb9964d04a81c137423d92329';
      $client = new Client();
      $response = $client->request('GET', "https://emailvalidation.abstractapi.com/v1?api_key=$apiKey&email=$email");
      $data = json_decode($response->getBody(), TRUE);
      if ($data['deliverability'] === "DELIVERABLE" && !$data["is_disposable_email"]["value"]) {
        return TRUE;
      }
      return 'Email Does Not Exist!!';
    }
    else {
      return 'Please Check!! Incorrect Email Format.';
    }
  }

  /**
   * Function to set the password has maximum length 20 and minimum length has 
   * 5 characters.
   * 
   * @param string $pass
   *  Stores Password of User.
   * 
   * @return bool|string
   */
  public function isPassword($pass) {
    $passLength = strlen($pass);
    if ($passLength < 5) {
      return 'Password must contain at least 5 character';
    }
    elseif ($passLength > 20) {
      return 'Password can be maximum of 20 character';
    }
    return TRUE;
  }

  /**
   * Function to check if the Token is expired or not.
   * 
   * @param string $tokenExpire
   *  Stores Expiry time of Token.
   * 
   * @return bool|string
   */
  public function isTokenExpire($tokenExpire) {
    if (strtotime($tokenExpire) < time()) {
      return 'Token Has Expired!!!';
    }
    return TRUE;
  }
}
