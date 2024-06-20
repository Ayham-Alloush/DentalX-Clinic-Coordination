<?php 
  session_start() ; 
  $con = mysqli_connect("localhost","root","") ;
  if (!$con){
    die ("connection error : ". mysqli_connect_error()) ;
  }

  mysqli_select_db($con,"mydb") ;
  $query = "SELECT user_name, lab_name, first_name, last_name, lab_type, full_address FROM lab_users" ;
  $stmt = mysqli_prepare($con, $query) ;
  mysqli_stmt_execute($stmt) ;
  mysqli_stmt_store_result($stmt);
  mysqli_stmt_bind_result($stmt, $user_name, $lab_name, $first_name, $last_name, $lab_type, $full_address) ;
  // we will fetch ($stmt) inside html section .
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="CSS/all.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" href="css/home.css">
  <title>الرئيسية</title>
</head>

<body>
  <main>
    <!-- first navbar will be visible on all screens except small screen -->
    <nav class="navbar d-none d-sm-flex navbar-expand navbar-fixed-right align-items-start">
      <div class="container-fluid  p-0 flex-column align-items-start">
        <a class="navbar-brand" href="#">DentalX</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02"
          aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
          <ul class="navbar-nav flex-column gap-1 p-0 me-3 mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" href="#">
                <i class="fa-solid fa-house"></i>
                الرئيسية
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../doc_profile/doc-profile.php">
                <i class="fa-solid fa-user"></i>
                الحساب الشخصي
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../orders/orders.php">
                <i class="fa-solid fa-bag-shopping"></i>
                قائمة الطلبات
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../about/about.html">
                <i class="fa-solid fa-circle-question"></i>
                حول
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../index.html">
                <i class="fa-solid fa-right-from-bracket"></i>
                تسجيل الخروج
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- second navbar will be visible on small screen only -->
    <nav class="navbar d-sm-none  bg-body-tertiary fixed-top">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">DentalX</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
          aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
          <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">DentalX</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body">
            <ul class="navbar-nav justify-content-end flex-grow-1 gap-1 pe-3">
              <li class="nav-item">
                <a class="nav-link active" href="#">
                  <i class="fa-solid fa-house"></i>
                  الرئيسية
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../doc_profile/doc-profile.php">
                  <i class="fa-solid fa-user"></i>
                  الحساب الشخصي
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../orders/orders.php">
                  <i class="fa-solid fa-bag-shopping"></i>
                  قائمة الطلبات
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../about/about.html">
                  <i class="fa-solid fa-circle-question"></i>
                  حول
                </a>
              <li class="nav-item">
                <a class="nav-link" href="../index.html">
                  <i class="fa-solid fa-right-from-bracket"></i>
                  تسجيل الخروج
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>

    <div class="container-fluid pt-3 pe-5 ps-5 ">
      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
        <!-- card component -->
        <!-- php code , for each row in lab_users table .. we will add a card to home screen -->
        <?php 
          while (mysqli_stmt_fetch($stmt)) {
            echo '
              <div class="col">
                <div class="card mb-3">
                  <div class="card-body">
                    <p class="card-text fs-5">اسم المخبر :
                      <span id="lab-name" class="text-secondary">'.$lab_name.'</span>
                    </p>
                    <p class="card-text fs-5">اسم المخبري :
                      <span id="doc-name" class="text-secondary">'.$first_name.$last_name.' </span>
                    </p>
                    <p class="card-text fs-5">نوع المخبر :
                      <span id="lab-type" class="text-secondary">'.$lab_type.'</span>
                    </p>
                    <p class="card-text fs-5">الموقع :
                      <span id="location" class="text-secondary">'.$full_address.'</span>
                    </p>
                    <a href="../lab_details/lab-details.php?user_name='.$user_name.'" class="btn btn-primary mb-1 w-100">عرض التفاصيل</a>
                  </div>
                </div>
              </div>
            ' ;
          }
        ?>
        <!--card component -->
      </div>
    </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
</body>

</html>