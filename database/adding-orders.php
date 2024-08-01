<?php
  session_start() ;
  $con = mysqli_connect("localhost","root","") ;

  if (!$con){
    die ("connection error : ". mysqli_connect_error()) ;
  }

  mysqli_select_db($con,"mydb") ;

  $counts = $_POST['count'] ;
  $items = $_POST['item'] ;
  $prices = $_POST['price'] ;
  $patient_name = $_POST['patient-name'] ;
  $patient_age = $_POST['patient-age'] ;
  $patient_work = $_POST['patient-work'] ;
  $item_color = $_POST['item-color'] ;
  $receive_date = $_POST['receive-date'] ;
  $notice = $_POST['notice'] ;
  $total_price = $_POST['total-price'] ;
  
  //getting the time now 
  $current_date = date("Y-m-d");
  
  // creating array to make it JSON object
  $data = array(
    'patient_name' => $patient_name,
    'patient_age' => $patient_age,
    'patient_work' => $patient_work,
    'current_date' => $current_date,
    'receive_date' => $receive_date,
    'item_color' => $item_color,
    'notice' => $notice,
    'counts' => $counts,
    'items' => $items,
    'prices' => $prices
  );

  // creating JSON object to insert it into order details table 
  $jsonData = json_encode($data);

  // inserting into order details 
  $query = "INSERT INTO order_details values (null,?)" ;
  $stmt = mysqli_prepare($con , $query) ;
  mysqli_stmt_bind_param($stmt, "s", $jsonData) ;
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  // fetching latest inserted orders id , to insert it into orders table later
  $query = "SELECT id FROM order_details ORDER BY id DESC LIMIT 1";
  $stmt = mysqli_prepare($con , $query) ;
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $order_details_id);
  mysqli_stmt_fetch($stmt);
  mysqli_stmt_close($stmt);

  $query = "SELECT id, clinic_name, first_name, last_name FROM users where user_name= ?" ;
  $stmt = mysqli_prepare($con , $query) ;
  // we used the doctor user name which we stored it in session variable 
  mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']) ;
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $doc_id, $clinic_name, $first_name, $last_name);
  mysqli_stmt_fetch($stmt);
  mysqli_stmt_close($stmt) ;
  $doc_name = $first_name." ".$last_name ;

  // now we will get info for the lab
  // get the lab user name from the hidden input 
  $lab_username = $_POST['lab-username'] ;
  $query = "SELECT id, lab_name, first_name, last_name, lab_type FROM lab_users where user_name= ?" ;
  $stmt = mysqli_prepare($con , $query) ;
  mysqli_stmt_bind_param($stmt, "s", $lab_username) ;
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $lab_id, $lab_name, $first_name, $last_name, $lab_type);
  mysqli_stmt_fetch($stmt);
  mysqli_stmt_close($stmt) ;
  $prosthodontist_name = $first_name." ".$last_name ;
  
  // inserting in orders table !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

  // initial status 
  $status = "بانتظار الموافقة" ;

  // inserting into orders
  $query = "INSERT INTO orders values (null,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)" ;
  $stmt = mysqli_prepare($con , $query) ;
  mysqli_stmt_bind_param($stmt, "sssssssssssssss", 
    $doc_id, $lab_id, $lab_username, $_SESSION['username'], $clinic_name, $lab_name, $doc_name, $prosthodontist_name, 
    $lab_type, $current_date, $receive_date, $patient_name, $total_price, $status, $order_details_id ) ;
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  header("Location: ../orders/orders.php");
  exit() ;
?>