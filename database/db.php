<?php

	$servername = "localhost";
	$username = "root";
	$password = "";

	$conn = mysqli_connect($servername, $username, $password);

	if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
	}
 
  $createDatabaseQuery= "CREATE DATABASE IF NOT EXISTS mydb" ;
  if(mysqli_query( $conn , $createDatabaseQuery )){
    echo "Database created successfully <br>" ;
  }
  else{
    echo "Error creating database :" . mysqli_error($conn) ;
  }

  mysqli_select_db($conn,"mydb") ;

  $createUsersTableQuery= "
    CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    phone_number VARCHAR(255),
    clinic_name VARCHAR(255),
    user_name VARCHAR(255),
    password VARCHAR(255),
    full_address VARCHAR(255),
    gender VARCHAR(255)
  ); " ;

  if(mysqli_query( $conn , $createUsersTableQuery )){
    echo "Users table created successfully <br>" ;
  }
  else{
    echo "Error creating users table :" . mysqli_error($conn) ;
  }

    $createLabUsersTableQuery= "
    CREATE TABLE IF NOT EXISTS lab_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    phone_number VARCHAR(255),
    lab_name VARCHAR(255),
    user_name VARCHAR(255),
    password VARCHAR(255),
    full_address VARCHAR(255),
    lab_type VARCHAR(255),
    gender VARCHAR(255)
  ); " ;

  if(mysqli_query( $conn , $createLabUsersTableQuery )){
    echo "lab_Users table created successfully" ;
  }
  else{
    echo "Error creating users table :" . mysqli_error($conn) ;
  }

  mysqli_close($conn) ;
?>