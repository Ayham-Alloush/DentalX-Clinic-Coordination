<?php 
  // Start the session (if not already started)
  session_start();

  // Destroy all session variables
  session_destroy();

  // Redirect to signin page
  header("Location: ../index.html");

  // Exit script execution
  exit;
?>