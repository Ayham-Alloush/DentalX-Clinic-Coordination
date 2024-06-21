<?php
  session_start() ;
  $con = mysqli_connect("localhost","root","") ;
  if (!$con){
    die ("connection error : ". mysqli_connect_error()) ;
  }

  mysqli_select_db($con,"mydb") ;
  
  $phone_number = $_POST['phone'] ;
  $lab_name = $_POST['lab'] ;
  $newPassword = $_POST['pass'] ;
  $full_address = $_POST['address'] ;
  $lab_type = $_POST['type'] ;

  $query = "SELECT password FROM lab_users where user_name = ?" ;
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

  $query = "UPDATE lab_users SET phone_number = ?, lab_name = ?, full_address = ?, lab_type = ?, password = ? where user_name = ?" ;
  $stmt = mysqli_prepare($con, $query) ;
  mysqli_stmt_bind_param($stmt, "ssssss", $phone_number, $lab_name, $full_address, $lab_type, $hashedPassword, $_SESSION['username']) ;
  mysqli_stmt_execute($stmt) ;
  mysqli_stmt_close($stmt) ;
  header("Location: ../lab_profile/lab-profile.php");
  exit(); // Make sure to exit after redirecting

?>