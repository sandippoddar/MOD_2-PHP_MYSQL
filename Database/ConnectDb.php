<?php

  /**
   * This class represents to Connect with the Database.
   */

  class ConnectDB {

    /**
     * @var string.
     *  Use here to store Server name.
     */
    private $servername = 'localhost';

    /**
     * @var string.
     *  Store Username to connect with database.
     */
    private $username = 'sandip';

    /**
     * @var string.
     *  Store Password of User.
     */
    private $password = 'sandip1234@';

    /**
     * @var string.
     *  Store Database name.
     */
    private $dbname = 'UserLogin';

    /**
     * @var \PDO $conn
     *  Conn variable use here to know if the database is Connected or not and 
     *  it return true or false.
     */
    private $conn;

    /**
     * This constructor is use here to initialize Instance member $conn with 
     * Object of PDO class.
     */
    public function __construct() {
      try {
          $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
          $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } 
      catch(PDOException $e) {
          echo "Connection failed: " . $e->getMessage();
      }
    }

    /**
     * Here getConnection() function is use to return the conn variable whenever
     * object of the class is created and will call the function.
     * 
     * @return \PDO
     */

    public function getConnection() {
      return $this->conn;
    }

    /**
     * This function use here to close Connection with Database.
     * 
     * @return NULL
     */
    public function closeConnection() {
      return $this->conn = NULL;
    }
  }  

?>
