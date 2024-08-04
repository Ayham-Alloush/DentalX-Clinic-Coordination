<?php
  $con = mysqli_connect("localhost","root","") ;

  if (!$con){
    die ("connection error : ". mysqli_connect_error()) ;
  }

  mysqli_select_db($con,"mydb") ;

  $order_id = intval($_POST['order-id']) ;

  $query = "SELECT order_details_id FROM orders where id = ?";
  $stmt = mysqli_prepare($con, $query);
  mysqli_stmt_bind_param($stmt, "i", $order_id);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $order_details_id);
  mysqli_stmt_fetch($stmt);
  mysqli_stmt_close($stmt);


  $query = "DELETE FROM reasons WHERE order_id = ?";
  $stmt = mysqli_prepare($con, $query);
  mysqli_stmt_bind_param($stmt, "i", $order_id);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  $query = "DELETE FROM orders WHERE id = ?";
  $stmt = mysqli_prepare($con, $query);
  mysqli_stmt_bind_param($stmt, "i", $order_id);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  
  $query = "DELETE FROM order_details WHERE id = ?";
  $stmt = mysqli_prepare($con, $query);
  mysqli_stmt_bind_param($stmt, "i", $order_details_id);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  header("Location: ../orders/orders.php");
  exit() ;
?>