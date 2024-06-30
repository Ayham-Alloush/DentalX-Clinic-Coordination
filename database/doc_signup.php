<?php
  $con = mysqli_connect("localhost","root","") ;
  if (!$con){
    die ("connection error : ". mysqli_connect_error()) ;
  }

  mysqli_select_db($con,"mydb") ;

  $firstName = $_POST['first'];
  $lastName = $_POST['last'];
  $phoneNumber = $_POST['phone'];
  $clinicName = $_POST['clinic'];
  $userName = $_POST['user'];
  $password = $_POST['pass'];
  $fullAddress = $_POST['address'];
  $gender = $_POST['gender'];

  // Hash the password
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  // Create the SQL query with placeholders
  $query = "INSERT INTO users (first_name, last_name, phone_number, clinic_name, user_name, password, full_address, gender) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

  // Prepare the query
  $stmt = mysqli_prepare($con, $query);

  // Bind parameters to the prepared statement
  mysqli_stmt_bind_param($stmt, "ssssssss", $firstName, $lastName, $phoneNumber, $clinicName,$userName , $hashedPassword, $fullAddress, $gender);

  // Execute the prepared statement
  if (mysqli_stmt_execute($stmt)) {
      // sending user to sign in page 
      header("Location: ../index.html");
  } else {
      echo "Error: " . mysqli_stmt_error($stmt);
  }

  // Close the statement and connection
  mysqli_stmt_close($stmt);
  mysqli_close($con);

?>