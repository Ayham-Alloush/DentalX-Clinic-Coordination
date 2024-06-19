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
    echo "lab_Users table created successfully <br>" ;
  }
  else{
    echo "Error creating users table :" . mysqli_error($conn) ;
  }

  // this is table for testing , it will be deleted or altered .
  $createOrderDetailsTableQuery= "
  CREATE TABLE IF NOT EXISTS order_details (
  id INT PRIMARY KEY AUTO_INCREMENT,
  order_details VARCHAR(255)
  ); " ;

  if(mysqli_query( $conn , $createOrderDetailsTableQuery )){
    echo "order_details table created successfully <br>" ;
  }
  else{
    echo "Error creating order_details table :" . mysqli_error($conn) ;
  }

  $createOrdersTableQuery= "
  CREATE TABLE IF NOT EXISTS orders (
  id INT PRIMARY KEY AUTO_INCREMENT,
  doc_id INT,
  lab_id INT,
  clinic_name VARCHAR(255),
  lab_name VARCHAR(255),
  doc_name VARCHAR(255),
  prosthodontist_name VARCHAR(255),
  lab_type VARCHAR(255),
  order_date DATE,
  receive_date DATE,
  patient_name VARCHAR(255),
  price DECIMAL(10, 2),
  status VARCHAR(255),
  order_details_id INT,
  FOREIGN KEY (doc_id) REFERENCES users(id),
  FOREIGN KEY (lab_id) REFERENCES lab_users(id),
  FOREIGN KEY (order_details_id) REFERENCES order_details(id)
); " ;

  if(mysqli_query( $conn , $createOrdersTableQuery )){
    echo "Orders table created successfully <br>" ;
  }
  else{
    echo "Error creating orders table :" . mysqli_error($conn) ;
  }

  mysqli_close($conn) ;
?>