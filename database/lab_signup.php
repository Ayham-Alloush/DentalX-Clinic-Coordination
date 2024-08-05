<?php
  $con = mysqli_connect("localhost","root","") ;
  if (!$con){
    die ("connection error : ". mysqli_connect_error()) ;
  }

  mysqli_select_db($con,"mydb") ;

  $firstName = $_POST['first'];
  $lastName = $_POST['last'];
  $phoneNumber = $_POST['phone'];
  $labName = $_POST['lab'];
  $userName = $_POST['user'];
  $password = $_POST['pass'];
  $fullAddress = $_POST['address'];
  $labType = $_POST['type'] ;
  $gender = $_POST['gender'];

  // making sure that prosthodontist don't use a user name which is already in use 
  $query = "SELECT COUNT(*) FROM lab_users where user_name = ?" ;
  $stmt = mysqli_prepare($con, $query);
  mysqli_stmt_bind_param($stmt, "s", $userName);
  mysqli_stmt_execute($stmt) ;
  mysqli_stmt_bind_result($stmt,$count) ;
  mysqli_stmt_fetch($stmt);
  mysqli_stmt_close($stmt);
  if($count >= 1){
    header("Location: ../lab_signup/lab-signup.html?user=exist") ;
  }
  else{
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  
    // Create the SQL query with placeholders
    $query = "INSERT INTO lab_users (first_name, last_name, phone_number, lab_name, user_name, password, full_address, lab_type, gender) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
  
    // Prepare the query
    $stmt = mysqli_prepare($con, $query);
  
    // Bind parameters to the prepared statement
    mysqli_stmt_bind_param($stmt, "sssssssss", $firstName, $lastName, $phoneNumber, $labName,$userName , $hashedPassword, $fullAddress, $labType, $gender);
  
    // Execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        // sending user to sign in page 
        header("Location: ../index.html");
    } else {
        echo "Error: " . mysqli_stmt_error($stmt);
    }
  
    // Close the statement and connection
    mysqli_stmt_close($stmt);
  }
  
  mysqli_close($con);

?>