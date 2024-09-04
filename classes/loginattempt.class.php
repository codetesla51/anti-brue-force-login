<?php
/**
 * Class for tracking and handling login attempts.
 */
class LoginAttempt extends DbCreate
{
  private $max_attempts;
  private $ip_address;
  private $attempts;
  private $blocked_duration;
  private $blocked_until;
  private $last_attempt;
  private $status;

  public function __construct($max_attempts = 5, $blocked_duration = 900)
  {
    $this->ip_address = $this->getUserIp();
    $this->max_attempts = $max_attempts;
    $this->blocked_duration = $blocked_duration;
    $this->getIpInfo();
  }
  private function getUserIp()
  {
    if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
      return $_SERVER["HTTP_CLIENT_IP"]; // IP address from shared internet
    } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
      return $_SERVER["HTTP_X_FORWARDED_FOR"]; // IP address passed from the proxy
    } else {
      return $_SERVER["REMOTE_ADDR"]; // Default IP address
    }
  }
  private function getIpInfo()
  {
    $sql =
      "SELECT attempts, status, last_attempt, blocked_until FROM login_attempts WHERE ip = ?";
    $stmt = $this->connect()->prepare($sql);
    if (!$stmt) {
      echo "Statement execution failed";
      exit();
    }
    $stmt->execute([$this->ip_address]);
    $result = $stmt->fetch();

    if ($result) {
      $this->status = $result["status"];
      $this->attempts = $result["attempts"];
      $this->last_attempt = $result["last_attempt"];
      $this->blocked_until = $result["blocked_until"];
      if (
        $this->status === "blocked" &&
        strtotime($this->blocked_until) < time()
      ) {
        $this->unblockIp();
      }
    } else {
      $this->resetAttempts();
      $sql = "INSERT INTO login_attempts (ip, status) VALUES (?, 'unblocked')";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$this->ip_address]);
    }
  }

  public function isBlocked()
  {
    return $this->status === "blocked";
  }

  private function unblockIp()
  {
    $this->status = "unblocked";
    $this->resetAttempts();

    $stmt = $this->connect()->prepare(
      "UPDATE login_attempts SET status = 'unblocked', attempts = 0, last_attempt = NULL, blocked_until = NULL WHERE ip = ?"
    );
    $stmt->execute([$this->ip_address]);
  }

  public function recordFailedAttempt()
  {
    $this->attempts++;
    $this->last_attempt = date("Y-m-d H:i:s");

    if ($this->attempts >= $this->max_attempts) {
      $this->status = "blocked";
      $this->blocked_until = date(
        "Y-m-d H:i:s",
        time() + $this->blocked_duration
      );
    }

    $stmt = $this->connect()->prepare(
      "UPDATE login_attempts SET attempts = ?, last_attempt = ?, status = ?, blocked_until = ? WHERE ip = ?"
    );
    $stmt->execute([
      $this->attempts,
      $this->last_attempt,
      $this->status,
      $this->blocked_until,
      $this->ip_address,
    ]);
  }

  public function successfulLogin()
  {
    $this->unblockIp();
  }

  private function resetAttempts()
  {
    $this->attempts = 0;
    $this->last_attempt = null;
    $this->blocked_until = null;
    $this->status = "unblocked";
  }
}
