<?php
  $con = mysqli_connect("localhost","root","") ;
  if (!$con){
    die ("connection error : ". mysqli_connect_error()) ;
  }

  mysqli_select_db($con,"mydb") ;

  $firstName = $_GET['first'];
  $lastName = $_GET['last'];
  $phoneNumber = $_GET['phone'];
  $clinicName = $_GET['clinic'];
  $userName = $_GET['user'];
  $password = $_GET['pass'];
  $fullAddress = $_GET['address'];
  $gender = $_GET['gender'];

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
      echo "Your account is added.";
      // need to add the home page for doctor here in the future 
      // header("Location: index.html");
  } else {
      echo "Error: " . mysqli_stmt_error($stmt);
  }

  // Close the statement and connection
  mysqli_stmt_close($stmt);
  mysqli_close($con);

?>