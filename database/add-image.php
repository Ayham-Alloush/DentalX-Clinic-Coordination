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
  // number of images sent by user
  $totalImages = count($_FILES['img']['name']);
  for ($i = 0; $i < $totalImages; $i++) {
    // for each image we will get (name and data)
    $imgName = $_FILES['img']['name'][$i] ;
    $imgData = file_get_contents($_FILES['img']['tmp_name'][$i]);

    $query = "INSERT INTO images (lab_id, user_name, filename, filedata)  VALUES (?,?,?,?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "isss", $_SESSION['id'], $_SESSION['username'], $imgName, $imgData);
    if(mysqli_stmt_execute($stmt)){
      continue ;
    }
  }
  header("Location: ../lab_profile/lab-profile.php") ;
  mysqli_stmt_close($stmt) ;
?>