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
            // maybe i have to send him to same page but with parameters in url , and then hadle the parameters using js
            // so i can send alert to the user .
            echo "Invalid password.";
        }
    } 
    else {
        // No matching username found
        // need to use url parameters like the previous one , but different alert .
        echo "Invalid username";
    }
  }
  else{
    // here i have to add query to a new table named lab_users .
  }
?>