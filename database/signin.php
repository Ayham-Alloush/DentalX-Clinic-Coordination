<?php
  $con = mysqli_connect("localhost","root","") ;

  if (!$con){
    die ("connection error : ". mysqli_connect_error()) ;
  }

  mysqli_select_db($con,"mydb") ;

  $userName = $_POST['user_name'];
  $password = $_POST['pass'];
  $title = $_POST['title'] ;

  if ($title=='doctor'){
    $query = "SELECT password FROM users WHERE user_name = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "s", $userName);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    if (mysqli_stmt_num_rows($stmt) == 1) {
        mysqli_stmt_bind_result($stmt, $hashedPassword);
        mysqli_stmt_fetch($stmt);

        if (password_verify($password, $hashedPassword)) {
            // Passwords match, authentication successful
            header('Location: ../doc_home/index.php');
            mysqli_stmt_close($stmt);
            exit();
        } else {
            // Passwords don't match, authentication failed
            // send the user to signin page again but with x=1
            // then we use js to handle this .
            header('location: ../login_signup/index.html?x=1') ;
        }
    } 
    else {
        // No matching username found
        // send the user to signin page again but with x=1
        // then we use js to handle this .
        header('location: ../login_signup/index.html?x=2') ;
    }
  }
  else{
    // here i have to add query to a new table named lab_users .
  }
?>