<?php
#database connection pdo oop
class DbCreate
{
  private $db_host = "localhost";
  private $db_user = "root";
  private $db_pass = "";
  private $db_name = "anti_brute";
  public function connect()
  {
    try {
      $db_connect =
        "mysql:host=" . $this->db_host . ";dbname=" . $this->db_name;
      $pdo = new PDO($db_connect, $this->db_user, $this->db_pass);
      $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      return $pdo;
    } catch (PDOException $e) {
      echo "Database connection failed: " . $e->getMessage();
      echo "Error Code: " . $e->getCode();
      echo "Error Info: " . print_r($e->errorInfo(), true);
      return null;
    }
  }
}
?>
