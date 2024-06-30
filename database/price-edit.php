<?php
  session_start() ; 
  $con = mysqli_connect("localhost","root","") ;
  if (!$con){
    die ("connection error : ". mysqli_connect_error()) ;
  }

  mysqli_select_db($con,"mydb") ;

  $input1 = $_POST['input1'] ?? 0;
  $input2 = $_POST['input2'] ?? 0;
  $input3 = $_POST['input3'] ?? 0;
  $input4 = $_POST['input4'] ?? 0;
  $input5 = $_POST['input5'] ?? 0;
  $input6 = $_POST['input6'] ?? 0;
  $input7 = $_POST['input7'] ?? 0;
  $input8 = $_POST['input8'] ?? 0;
  $input9 = $_POST['input9'] ?? 0;
  $input10 = $_POST['input10'] ?? 0;
  $input11 = $_POST['input11'] ?? 0;
  $input12 = $_POST['input12'] ?? 0;
  $input13 = $_POST['input13'] ?? 0;
  $input14 = $_POST['input14'] ?? 0;
  $input15 = $_POST['input15'] ?? 0;
  $input16 = $_POST['input16'] ?? 0;
  $input17 = $_POST['input17'] ?? 0;
  $input18 = $_POST['input18'] ?? 0;
  $input19 = $_POST['input19'] ?? 0;
  $input20 = $_POST['input20'] ?? 0;
  $input21 = $_POST['input21'] ?? 0;
  $input22 = $_POST['input22'] ?? 0;
  $input23 = $_POST['input23'] ?? 0;
  $input24 = $_POST['input24'] ?? 0;
  $input25 = $_POST['input25'] ?? 0;
  $input26 = $_POST['input26'] ?? 0;
  $input27 = $_POST['input27'] ?? 0;
  $input28 = $_POST['input28'] ?? 0;
  $input29 = $_POST['input29'] ?? 0;
  $input30 = $_POST['input30'] ?? 0;
  $input31 = $_POST['input31'] ?? 0;
  $input32 = $_POST['input32'] ?? 0;
  $input33 = $_POST['input33'] ?? 0;
  $input34 = $_POST['input34'] ?? 0;
  $input35 = $_POST['input35'] ?? 0;
  $input36 = $_POST['input36'] ?? 0;
  $input37 = $_POST['input37'] ?? 0;
  $input38 = $_POST['input38'] ?? 0;
  $input39 = $_POST['input39'] ?? 0;
  $input40 = $_POST['input40'] ?? 0;
  $input41 = $_POST['input41'] ?? 0;
  $input42 = $_POST['input42'] ?? 0;
  $input43 = $_POST['input43'] ?? 0;
  $input44 = $_POST['input44'] ?? 0;
  $input45 = $_POST['input45'] ?? 0;
  $input46 = $_POST['input46'] ?? 0;
  $input47 = $_POST['input47'] ?? 0;
  $input48 = $_POST['input48'] ?? 0;
  $input49 = $_POST['input49'] ?? 0;

  $query = "SELECT * FROM prices WHERE user_name = ?";
  $stmt = mysqli_prepare($con, $query);
  mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_store_result($stmt);

  if (mysqli_stmt_num_rows($stmt) == 0) {
    // Row doesn't exist, insert a new row
    $insertQuery = "INSERT INTO prices  VALUES  (
    null, {$_SESSION['id']}, '{$_SESSION['username']}', $input1, $input2 , $input3, 
     $input4, $input5, $input6, $input7, $input8, $input9, $input10, 
     $input11, $input12, $input13, $input14, $input15, $input16, 
     $input17, $input18, $input19, $input20, $input21,$input22, 
     $input23, $input24, $input25, $input26, $input27, $input28, 
     $input29, $input30, $input31, $input32, $input33, $input34, 
     $input35, $input36, $input37, $input38, $input39, $input40, 
     $input41, $input42, $input43, $input44, $input45, $input46, 
     $input47, $input48, $input49)";
    $result = mysqli_query($con, $insertQuery) ;
    if($result){
      header("Location: ../lab_profile/lab-profile.php") ;
    }
    else{
      echo "didn't work" ;
    } 
} 

else {
 // Row  exists, update prices
    $tableName = "prices";
    $query  = "SELECT column_name FROM information_schema.columns WHERE table_name = ? ";
    $stmt2 = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt2, "s", $tableName) ;
    mysqli_stmt_execute($stmt2);
    mysqli_stmt_store_result($stmt2);
    mysqli_stmt_bind_result($stmt2, $columnName);

    $i = 1 ;
    $j = -2 ;
    while (mysqli_stmt_fetch($stmt2)){
        // we want to skip first three column because they are id , lab_id, user_name
        if($j>=1){
            $value = "input".$i ;
            $query = "UPDATE prices SET `$columnName` = {$$value} WHERE user_name = '{$_SESSION['username']}'" ;
            $result = mysqli_query($con, $query) ;
            $i++ ;
        }
        $j++ ; 
    }
    header("Location: ../lab_profile/lab-profile.php") ;
    mysqli_stmt_close($stmt2);
}

mysqli_stmt_close($stmt);
  
?>