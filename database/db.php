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
  // creating table for doctors
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

  // creating table for prosthodontists
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

  
  $createOrderDetailsTableQuery= "
  CREATE TABLE IF NOT EXISTS order_details (
  id INT PRIMARY KEY AUTO_INCREMENT,
  order_details JSON
  ); " ;

  if(mysqli_query( $conn , $createOrderDetailsTableQuery )){
    echo "order_details table created successfully <br>" ;
  }
  else{
    echo "Error creating order_details table :" . mysqli_error($conn) ;
  }

  // creating table for orders
  $createOrdersTableQuery= "
  CREATE TABLE IF NOT EXISTS orders (
  id INT PRIMARY KEY AUTO_INCREMENT,
  doc_id INT,
  lab_id INT,
  lab_username VARCHAR(255),
  doc_username VARCHAR(255),
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

  // creating table for each prosthodontists price menu .
  $createPricesTableQuery = "
    CREATE TABLE IF NOT EXISTS prices (
        id INT PRIMARY KEY AUTO_INCREMENT,
        `lab_id` INT,
        `user_name` VARCHAR(255),
        `صب الطبعة` DOUBLE DEFAULT NULL,
        `تجربة المعدن` DOUBLE DEFAULT NULL,
        `التخزيف` DOUBLE DEFAULT NULL,
        `تلبيسة` DOUBLE DEFAULT NULL,
        `تلبيسة معدن` DOUBLE DEFAULT NULL,
        `تلبيسة خزف` DOUBLE DEFAULT NULL,
        `حشوة خارجية مصبوبة` DOUBLE DEFAULT NULL,
        `حشوة داخلية مصبوبة` DOUBLE DEFAULT NULL,
        `صب وتد` DOUBLE DEFAULT NULL,
        `قلب و وتد` DOUBLE DEFAULT NULL,
        `فينير-خزف` DOUBLE DEFAULT NULL,
        `فينير-زيركون` DOUBLE DEFAULT NULL,
        `جهاز تقويمي ثابت` DOUBLE DEFAULT NULL,
        `حافظة مسافة ثابتة` DOUBLE DEFAULT NULL,
        `طابع افرادي` DOUBLE DEFAULT NULL,
        `طابع افرادي علوي` DOUBLE DEFAULT NULL,
        `طابع افرادي سفلي` DOUBLE DEFAULT NULL,
        `صفيحة قاعدية` DOUBLE DEFAULT NULL,
        `صفيحة قاعدية علوية` DOUBLE DEFAULT NULL,
        `صفيحة قاعدية سفلية` DOUBLE DEFAULT NULL,
        `تنضيد الاسنان` DOUBLE DEFAULT NULL,
        `تنضيد الاسنان العلوية` DOUBLE DEFAULT NULL,
        `تنضيد الاسنان السفلية` DOUBLE DEFAULT NULL,
        `تشميع الجهاز` DOUBLE DEFAULT NULL,
        `تشميع الجهاز العلوي` DOUBLE DEFAULT NULL,
        `تشميع الجهاز السفلي` DOUBLE DEFAULT NULL,
        `طبخ الجهاز` DOUBLE DEFAULT NULL,
        `طبخ الجهاز العلوي` DOUBLE DEFAULT NULL,
        `طبخ الجهاز السفلي` DOUBLE DEFAULT NULL,
        `بدلة اكريلية كاملة` DOUBLE DEFAULT NULL,
        `بدلة اكريلية كاملة علوية` DOUBLE DEFAULT NULL,
        `بدلة اكريلية كاملة سفلية` DOUBLE DEFAULT NULL,
        `تصليب الجهاز` DOUBLE DEFAULT NULL,
        `تصليب الجهاز العلوي` DOUBLE DEFAULT NULL,
        `تصليب الجهاز السفلي` DOUBLE DEFAULT NULL,
        `بدلة معدنية كاملة` DOUBLE DEFAULT NULL,
        `بدلة معدنية كاملة علوية` DOUBLE DEFAULT NULL,
        `بدلة معدنية كاملة سفلية` DOUBLE DEFAULT NULL,
        `ضمات` DOUBLE DEFAULT NULL,
        `ضمات علوية` DOUBLE DEFAULT NULL,
        `ضمات سفلية` DOUBLE DEFAULT NULL,
        `بدلة اكريلية جزئية` DOUBLE DEFAULT NULL,
        `بدلة اكريلية جزئية علوية` DOUBLE DEFAULT NULL,
        `بدلة اكريلية جزئية سفلية` DOUBLE DEFAULT NULL,
        `بدلة معدنية جزئية` DOUBLE DEFAULT NULL,
        `بدلة معدنية جزئية علوية` DOUBLE DEFAULT NULL,
        `بدلة معدنية جزئية سفلية` DOUBLE DEFAULT NULL,
        `جهاز تقويمي متحرك` DOUBLE DEFAULT NULL,
        `حافظة مسافة متحركة` DOUBLE DEFAULT NULL,
        FOREIGN KEY (lab_id) REFERENCES lab_users(id)
    );
    ";

  if(mysqli_query( $conn , $createPricesTableQuery )){
    echo "Prices table created successfully <br>" ;
  }
  else{
    echo "Error creating Prices table :" . mysqli_error($conn) ;
  }

  // creating table for gallery
  $createImagesTableQuery= "
    CREATE TABLE IF NOT EXISTS images (
    id INT PRIMARY KEY AUTO_INCREMENT,
    lab_id INT,
    user_name VARCHAR(255),
    filename VARCHAR(255),
    filedata LONGBLOB,
    FOREIGN KEY (lab_id) REFERENCES lab_users(id)
    ); " ;

  if(mysqli_query( $conn , $createImagesTableQuery )){
    echo "images table created successfully <br>" ;
  }
  else{
    echo "Error creating images table :" . mysqli_error($conn) ;
  }


  mysqli_close($conn) ;
?>