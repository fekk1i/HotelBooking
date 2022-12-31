// Edited By Ali El Fekki
<?php
// Initialize the session
session_start();

  // Unset all of the session variables
  $_SESSION = array();

  // Destroy the session.
  session_destroy();

  // Unset the cookie for the session
  if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(session_name(), '', time() - 42000,
          $params["path"], $params["domain"],
          true, // Secure flag
          true // httponly flag
      );
  }

  // Redirect to login page
  header("location: login.php");
  exit;
?>
