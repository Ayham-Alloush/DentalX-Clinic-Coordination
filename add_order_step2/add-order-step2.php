<?php
  session_start() ; 
  
  // A user is considered logged in if the $_SESSION['username'] variable is set.
  if (!isset($_SESSION['username']) || $_SESSION['userType'] != "doctor"){
    // User is not logged in or not a doctor, redirect to login
    header("Location: ../index.html") ;
  }

  $con = mysqli_connect("localhost","root","") ;
  if (!$con){
    die ("connection error : ". mysqli_connect_error()) ;
  }

  mysqli_select_db($con,"mydb") ;

  $count = [];
  for ($i = 1; $i <= 49; $i++) {
    $count[$i] = $_POST['count'.$i] ?? 0;
  }

  $item = [];
  for ($i = 1; $i <= 49; $i++) {
    $item[$i] = $_POST['item'.$i] ?? "nothing";
  }  

  $lab_user_name = $_POST['lab_user_name'] ;

  $query = "SELECT * FROM prices where user_name = ?" ;
  $stmt = mysqli_prepare($con, $query) ;
  mysqli_stmt_bind_param($stmt, "s", $lab_user_name) ;
  mysqli_stmt_execute($stmt) ;
  mysqli_stmt_bind_result($stmt, $price_row_id, $lab_id, $user_name, $price1, $price2, $price3, $price4, $price5, $price6,
  $price7, $price8, $price9, $price10, $price11, $price12, $price13, $price14, $price15, $price16, $price17, $price18, 
  $price19, $price20, $price21, $price22, $price23, $price24, $price25, $price26, $price27, $price28, 
  $price29, $price30, $price31, $price32, $price33, $price34, $price35, $price36, $price37, $price38, $price39, 
  $price40, $price41, $price42, $price43, $price44, $price45, $price46, $price47, $price48, $price49) ;
  mysqli_stmt_fetch($stmt) ;
  mysqli_stmt_close($stmt) ;
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="CSS/all.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" href="css/main.css">
  <title>تقديم طلب</title>
</head>

<body>
  <main>
    <div class="container pt-3">
      <div id="carousel" class="carousel slide" data-bs-touch="false">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="d-flex justify-content-center mt-3">
              <div class="alert alert-success">الرجاء التأكد من المواد المطلوبة</div>
            </div>
            <div class="table-responsive">
              <table class="table table-light mt-3 table-bordered align-middle">
                <thead>
                  <tr>
                    <th scope="col" class="fw-semibold">اسم المادة</th>
                    <th scope="col" class="fw-semibold">السعر</th>
                    <th scope="col" class="fw-semibold">العدد</th>
                    <th scope="col" class="fw-semibold">السعر الإجمالي</th>
                  </tr>
                </thead>
                <tbody> 
                  <?php
                    $i = 1 ;
                    $totalPrice = 0 ;
                    while($i<50){
                      if($count[$i]>0){
                        $itemPrice = 'price'.$i ;
                        $Price = $$itemPrice * $count[$i] ;
                        // we will use this later 
                        $totalPrice += $Price ;
                        echo '
                          <tr>
                          <td>'.$item[$i].'</td>
                          <td>'.$$itemPrice.'</td>
                          <td>'.$count[$i].'</td>
                          <td>'.$Price.'</td>
                          </tr>
                        ' ;
                      }
                      $i++ ;
                    }
                  ?>
                  <tr>
                    <th scope="row"  class="fw-bold">السعر النهائي</th>
                    <td colspan=3 class="fw-bold fs-5 text-danger"><?php echo $totalPrice ?> ل.س</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- end of table responsive div -->
            <div class="d-flex justify-content-center gap-3 my-3">
              <button class="btn btn-primary" type="button" data-bs-target="#carousel" data-bs-slide="next">التالي</button>
              <a href="../lab_details/lab-details.php?lab_user_name=<?php echo $lab_user_name ?>" class="btn btn-secondary">
                الغاء الطلب
              </a>
            </div>
          </div>
          <!-- end of first carousel item -->
          <div class="carousel-item" >
            <form action="../database/adding-orders.php" method="post" class="mt-2">
              <div class="row row-cols-1 row-cols-md-2">
                <input type="number" name="total-price" value="<?php echo $totalPrice ?>" hidden>
                <input type="text" name="lab-username" value="<?php echo $lab_user_name?>" hidden >
                <?php
                  $i = 1 ;
                  while($i < 50){
                    if($count[$i]>0){
                      $itemPrice = 'price'.$i ;
                      echo '
                        <input type="text" name="count[]" value="'.$count[$i].'" hidden>
                        <input type="text" name="item[]" value="'.$item[$i].'" hidden>
                        <input type="text" name="price[]" value="'.$$itemPrice.'" hidden>
                      ' ;
                    }
                    $i++ ;
                  }
                ?>
                <div class="col p-4">
                  <input type="text" name="patient-name" class="form-control form-control-lg" pattern="^[A-Za-z\u0600-\u06FF\s]+$" placeholder="اسم المريض" required>
                </div>
                <div class="col p-4">
                  <input type="number" name="patient-age" min="1" max="120" lang="en" class="form-control form-control-lg" placeholder="عمر المريض" required>
                </div>
                <div class="col p-4">
                  <input type="text" name="patient-work" class="form-control form-control-lg" pattern="^[A-Za-z\u0600-\u06FF\s]+$" placeholder="مهنة المريض" required>
                </div>
                <div class="col p-4">
                  <select name="item-color" id="item-color" class="form-select form-select-lg text-secondary">
                    <option value="لا يوجد" hidden selected>درجة اللون</option>
                    <option value="A1">A1</option>
                    <option value="A2">A2</option>
                    <option value="A3">A3</option>
                    <option value="B1">B1</option>
                    <option value="B2">B2</option>
                    <option value="B3">B3</option>
                    <option value="C1">C1</option>
                    <option value="C2">C2</option>
                    <option value="C3">C3</option>
                    <option value="D1">D1</option>
                    <option value="D2">D2</option>
                    <option value="D3">D3</option>
                  </select>
                </div>
                <div class="p-4 w-100 input-group">
                  <span class="input-group-text rounded-end rounded-start-0">تاريخ الاستلام</span>
                  <input type="date" id="dateInput" name="receive-date"  min="<?php echo date('Y-m-d'); ?>" class="form-control form-control-lg rounded-start rounded-end-0" required>
                </div>
                <div class="p-4 w-100">
                  <textarea class="form-control form-control-lg" id="notice" name="notice" placeholder="ملاحظات :" rows="3"></textarea>
                </div>
              </div>
              <!-- end of row -->
              <div class="d-flex justify-content-between px-4 gap-5 my-3">
                <button type="submit" class="btn btn-warning">تقديم الطلب</button>
                <button class="btn btn-secondary" type="button" data-bs-target="#carousel" data-bs-slide="prev">رجوع</button>
              </div>
            </form>
          </div>
        </div>
        <!-- end of inner  -->
      </div>
      <!-- end of carousel -->
    </div>
    <!-- end of container -->
  </main>
  <!-- end of the main container -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
  <script src="js/main.js"></script>
</body>

</html>