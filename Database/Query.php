<?php

require_once 'ConnectDb.php';

/**
 * This Implements for all the queries needed form Database.
 */
class Query {

  /**
   * @var PDO $conn
   *  Stores Object of PDO class.
   */
  private $conn;

  /**
   * This Constructor use here to initialize instance member $conn. 
   */
  public function __construct() {
    $db = new ConnectDb();
    $this->conn = $db->getConnection();
  }

  /**
   * Function to insert records when new User registered.
   * 
   * @param string $userName
   *  Stores Username of new User.
   * @param string $email
   *  Stores Email Id of new User.
   * @param string $password
   *  Stores Password in hash format.
   * 
   * @return void
   */
  public function Insert(string $userName, string $email, string $password) {
    $sql = $this->conn->prepare("INSERT INTO User (UserName, Email, Password) VALUES(:userName, :email, :password)");
    $sql->execute(array(':userName' => $userName, ':email' => $email, ':password' => $password));
    $result = $sql->fetch(PDO::FETCH_ASSOC);
  }
  
  /**
   * Function to check if Username or Email is already in the Database or not.
   * 
   * @param string $userName
   *  Store Username of the User.
   * @param string $email
   *  Store Email Id of User.
   * 
   * @return string|bool
   */
  public function Duplicate (string $userName, string $email) {
    $sql = $this->conn->prepare("SELECT * FROM User WHERE Email = :email OR UserName = :userName");
    $sql->execute(array(':email' => $email, 'userName'=> $userName));
    $result = $sql->fetch(PDO::FETCH_ASSOC);
    if ($result != []) {
      return 'Username or Email has already Taken!!';
    }
    return False;
  }

  /**
   * Function to Login user by checking the Email ID or Username is Already
   * stored in the Database or not.
   * 
   * @param string $userEmail
   *  Stores the Data as per the User enter Username or Email.
   * 
   * @return int|bool
   */
  public function LoginSelect (string $userEmail) {
    $sql = $this->conn->prepare("SELECT * FROM User WHERE Email = :Email OR UserName = :username");
    $sql->execute(array(':Email' => $userEmail, 'username'=> $userEmail));
    $result = $sql->fetch(PDO::FETCH_ASSOC);
    if ($result != []) {
      return $result['Password'];
    }
    return FALSE;
  }

  /**
   * Function to Check if the Email ID is already in the Database or not.It is 
   * using in Reset Password feature to send Reset Password Link.
   * 
   * @param string $userEmail
   *  Stores Email ID of the User.
   * 
   * @return bool
   */
  public function isEmailInDb (string $userEmail) {
    $sql = $this->conn->prepare("SELECT * FROM User WHERE Email = :userEmail");
    $sql->execute([':userEmail' => $userEmail]);
    $result = $sql->fetch(PDO::FETCH_ASSOC);
    if ($result != []) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Function to Update Token_hash, Token Expiry time in the Database whenever 
   * User send a Reset Password link to the Email ID.
   * 
   * @param string $email
   *  Stores Email ID of User.
   * @param string $token_hash
   *  Stores new Generated Token hash.
   * @param string $expiry
   *  Stores Expiry time of the Generated token.
   * 
   * @return bool
   */
  public function updateToken (string $email, string $token_hash, string $expiry) {
    $sql = $this->conn->prepare("UPDATE User SET Reset_Token = :tokenHash, Token_Expire = :expiry WHERE Email = :email");
    $exec = $sql->execute(array(':tokenHash' => $token_hash, ':expiry' => $expiry, ':email' => $email));
    $result = $sql->fetch(PDO::FETCH_ASSOC);
    if ($exec) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Function to get User ID and Expiry Time of Token Using the TokenHash.
   * 
   * @param string $tokenHash
   *  Stores Token hash value.
   * 
   * @return array|bool 
   */
  public function checkToken ($tokenHash) {
    $sql = $this->conn->prepare("SELECT * FROM User WHERE Reset_Token = :tokenHash");
    $sql->execute(array(':tokenHash' => $tokenHash));
    $result = $sql->fetch(PDO::FETCH_ASSOC);
    $tokenArray = array();
    if ($result != []) {
      $tokenArray["UserId"] = $result["ID"];
      $tokenArray["tokenExpire"] = $result["Token_Expire"];
      return $tokenArray;
    }
    return FALSE;
  }
  /**
   * Function to Update User Password and Set Token value and Expire Time as
   * Null.
   * 
   * @param string $userId
   *  Stores Id of User.
   * @param string $password
   *  Stores Hash value of Password.
   * 
   * @return bool
   */
  public function updateUser ($userId, $password) {
    $sql = $this->conn->prepare("UPDATE User SET Reset_Token = NULL, Token_Expire = NULL, Password = :password WHERE ID = :userId");
    $exec = $sql->execute([':password' => $password, ':userId' => $userId]);
    echo $exec;
    if ($sql->rowCount() > 0) {
      return TRUE;
    }
    return FALSE;
  }
}
