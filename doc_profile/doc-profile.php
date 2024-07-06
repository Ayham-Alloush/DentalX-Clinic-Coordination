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

  $query = "SELECT user_name, clinic_name, first_name, last_name, password, full_address, phone_number FROM users where user_name = ?" ;
  $stmt = mysqli_prepare($con, $query) ;
  mysqli_stmt_bind_param($stmt, "s", $_SESSION['username'] ) ;
  mysqli_stmt_execute($stmt) ;
  mysqli_stmt_store_result($stmt);
  mysqli_stmt_bind_result($stmt, $user_name, $clinic_name, $first_name, $last_name, $password, $full_address, $phone_number) ;
  mysqli_stmt_fetch($stmt) ;
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
  rel="stylesheet">
  <link rel="stylesheet" href="CSS/all.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" href="css/main.css">
  <title>الحساب الشخصي</title>
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
              <a class="nav-link" href="../doc_home/doc-home.php">
                <i class="fa-solid fa-house"></i>
                الرئيسية
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="#">
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
              <a class="nav-link" href="../about/about.php">
                <i class="fa-solid fa-circle-question"></i>
                حول
              </a>
            </li>
            <li class="nav-item">
              <form action="../database/logout.php" method="post" class="nav-link">
                <button type="submit" class="btn nav-link p-0">
                  <i class="fa-solid fa-right-from-bracket"></i>  
                  تسجيل الخروج
                </button>
              </form>
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
                <a class="nav-link" href="../doc_home/doc-home.php">
                  <i class="fa-solid fa-house"></i>
                  الرئيسية
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="#">
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
                <a class="nav-link" href="../about/about.php">
                  <i class="fa-solid fa-circle-question"></i>
                  حول
                </a>
              <li class="nav-item">
                <form action="../database/logout.php" method="post" class="nav-link">
                  <button type="submit" class="btn nav-link p-0">
                    <i class="fa-solid fa-right-from-bracket"></i>  
                    تسجيل الخروج
                  </button>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
    <div class="container-fluid pt-4">
      <div class="row justify-content-center pt-lg-4">
        <div class="col-sm-12 col-md-10 ">
          <form action="../database/user-info-edit.php" method="post" class="mt-lg-4" >
            <div class="row">
              <div class="col-sm-12 col-lg-6">
                <div class="form-floating mb-3">
                  <input type="text" class="form-control pe-4" id="first" placeholder="name"
                    pattern="^[A-Za-z\u0600-\u06FF]+$" name="first" required disabled
                    value="<?php echo $first_name; ?>">
                  <label for="first">الاسم :</label>
                </div>
              </div>
              <div class="col-sm-12 col-lg-6">
                <div class="form-floating mb-3">
                  <input type="text" class="form-control pe-4" id="last" placeholder="name"
                    pattern="^[A-Za-z\u0600-\u06FF]+$" name="last" required disabled
                    value="<?php echo $last_name; ?>">
                  <label for="last"> الكنية :</label>
                </div>
              </div>
              <div class="col-sm-12 col-lg-6">
                <div class="form-floating mb-3">
                  <input type="text" class="form-control pe-4" id="phone" pattern="09\d{8}" placeholder="phone"
                   name="phone" required value="<?php echo $phone_number; ?>">
                  <label for="phone">رقم الهاتف :</label>
                </div>
              </div>
              <div class="col-sm-12 col-lg-6">
                <div class="form-floating mb-3">
                  <input type="text" class="form-control pe-4" id="clinic" placeholder="Clinic Name"
                    pattern="^[A-Za-z\u0600-\u06FF\s]+$" name="clinic" required
                    value="<?php echo $clinic_name; ?>">
                  <label for="clinic">اسم العيادة :</label>
                </div>
              </div>
              <div class="col-sm-12 col-lg-6">
                <div class="form-floating mb-3">
                  <input type="text" class="form-control pe-4" id="user" placeholder="User Name" name="user" required disabled
                  value="<?php echo ' '.$user_name; ?>">
                  <label for="user">اسم المستخدم :</label>
                </div>
              </div>
              <div class="col-sm-12 col-lg-6">
                <div class="form-floating mb-3">
                  <input type="password" class="form-control pe-4" id="passwordInput" placeholder="password" pattern=".{8,}"
                    name="pass" value="">
                  <label for="password">كلمة السر :</label>
                </div>
              </div>
              <div class="col-12">
                <div class="mb-3">
                  <select class="form-select" id="add" name="address" required>
                    <option selected hidden value="<?php echo $full_address; ?>"><?php echo $full_address; ?></option>
                    <option value="اللاذقية">اللاذقية</option>
                    <option value="حلب">حلب</option>
                    <option value="درعا">درعا</option>
                    <option value="دير الزور">دير الزور</option>
                    <option value="حماة">حماة</option>
                    <option value="الحسكة">الحسكة</option>
                    <option value="حمص">حمص</option>
                    <option value="ادلب">ادلب</option>
                    <option value="الرقة">الرقة</option>
                    <option value="السويداء">السويداء</option>
                    <option value="طرطوس">طرطوس</option>
                    <option value="دمشق">دمشق</option>
                  </select>
                </div>
              </div>
              <div class="text-center">
                <button type="submit" class="btn custom w-50 btn-primary text-white border-0">حفظ</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
  <script src="js/main.js"></script>
</body>

</html>