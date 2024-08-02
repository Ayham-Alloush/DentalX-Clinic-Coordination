<?php
  $con = mysqli_connect("localhost","root","") ;
  if (!$con){
    die ("connection error : ". mysqli_connect_error()) ;
  }

  mysqli_select_db($con,"mydb") ;

  $order_id = $_POST['order-id'] ;
  $new_status = $_POST['new-status'] ;

  $query = "UPDATE orders SET status = '$new_status' WHERE id = $order_id";
  $result = mysqli_query($con, $query);

  header("Location: ../lab_orders/lab-orders.php");
  exit() ;
?>