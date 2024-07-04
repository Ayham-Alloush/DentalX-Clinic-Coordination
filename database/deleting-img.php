<?php
  session_start();
  $servername = "localhost";
  $username = "root";
  $password = "";

  $conn = mysqli_connect($servername, $username, $password);

  if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
  }

  mysqli_select_db($conn,"mydb") ;

  $img_id = $_POST['img_id'] ;
  $query = "DELETE FROM images where id = ? " ;
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "s", $img_id) ;
  if(mysqli_stmt_execute($stmt)){
    header("Location: ../lab_profile/lab-profile.php") ;
  }
?>