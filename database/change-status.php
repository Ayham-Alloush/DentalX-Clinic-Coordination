<?php
  $con = mysqli_connect("localhost","root","") ;
  if (!$con){
    die ("connection error : ". mysqli_connect_error()) ;
  }

  mysqli_select_db($con,"mydb") ;

  $order_id = $_POST['order-id'] ;
  $new_status = $_POST['new-status'] ;
  $reject_reason = $_POST['reason'] ?? null ;

  $query = "UPDATE orders SET status = '$new_status' WHERE id = $order_id";
  $result = mysqli_query($con, $query);

  // if the lab user reject an order , he will have to write a reason for rejection , so this variable will be set .
  if(isset($_POST['reason'])){
    $query = "INSERT INTO reasons VALUES (null , ?, ?)";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "is", $order_id, $reject_reason);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
  }

  header("Location: ../lab_orders/lab-orders.php");
  exit() ;
?>