<?php
/**
 * Class for handling user login.
 */
class Login
{

  private $loginAttempt;

  public function __construct()
  {
  

    $this->loginAttempt = new LoginAttempt();
  }

  public function authenticate($username, $password)
  {
    if ($this->loginAttempt->isBlocked()) {
      echo "Your account is temporarily blocked due to too many failed login attempts. Please try again later.";
      return;
    }

    if ($this->verifyCredentials($username, $password)) {
      $this->loginAttempt->successfulLogin();
      echo "Login successful!";
    } else {
      $this->loginAttempt->recordFailedAttempt();
      echo "Invalid credentials. Please try again.";
    }
  }

  private function verifyCredentials($username, $password)
  {
    return $username === "admin" && $password === "password";
  }
}
