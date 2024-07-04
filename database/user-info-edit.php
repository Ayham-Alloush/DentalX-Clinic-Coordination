<?php
  session_start() ;
  $con = mysqli_connect("localhost","root","") ;
  if (!$con){
    die ("connection error : ". mysqli_connect_error()) ;
  }

  mysqli_select_db($con,"mydb") ;
  
  $phone_number = $_POST['phone'] ;
  $clinic_name = $_POST['clinic'] ;
  $newPassword = $_POST['pass'] ;
  $full_address = $_POST['address'] ;

  $query = "SELECT password FROM users where user_name = ?" ;
  $stmt = mysqli_prepare($con, $query) ;
  mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']) ;
  mysqli_stmt_execute($stmt) ;
  mysqli_stmt_bind_result($stmt, $oldPassword) ;
  mysqli_stmt_fetch($stmt) ;
  mysqli_stmt_close($stmt) ;
  if ($newPassword !== "") {
  // Hash the new password
  $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
  } 
  else {
  // Keep the existing hashed password
  $hashedPassword = $oldPassword ;
  }

  $query = "UPDATE users SET phone_number = ?, clinic_name = ?, full_address = ?, password = ? where user_name = ?" ;
  $stmt = mysqli_prepare($con, $query) ;
  mysqli_stmt_bind_param($stmt, "sssss", $phone_number, $clinic_name, $full_address, $hashedPassword, $_SESSION['username']) ;
  mysqli_stmt_execute($stmt) ;
  mysqli_stmt_close($stmt) ;
  header("Location: ../doc_profile/doc-profile.php");
  exit(); // Make sure to exit after redirecting

?>