<?php 
  session_start() ; 
  
  // A user is considered logged in if the $_SESSION['username'] variable is set.
  if (!isset($_SESSION['username']) || $_SESSION['userType'] != "lab"){
    // User is not logged in or not a lab user, redirect to login
    header("Location: ../index.html") ;
  }

  $con = mysqli_connect("localhost","root","") ;
  if (!$con){
    die ("connection error : ". mysqli_connect_error()) ;
  }

  mysqli_select_db($con,"mydb") ;

  $query = "SELECT id FROM lab_users where user_name = ?" ;
  $stmt = mysqli_prepare($con, $query);
  mysqli_stmt_bind_param($stmt,"s",$_SESSION['username']) ;
  mysqli_stmt_execute($stmt) ;
  mysqli_stmt_bind_result($stmt, $id) ;
  mysqli_stmt_fetch($stmt) ;
  mysqli_stmt_close($stmt) ;
  // we will use this later
  $_SESSION['id'] = $id ;

  $query = "SELECT lab_name, first_name, last_name, lab_type, full_address, phone_number FROM lab_users where user_name = ?" ;
  $stmt = mysqli_prepare($con, $query) ;
  mysqli_stmt_bind_param($stmt, "s", $_SESSION['username'] ) ;
  mysqli_stmt_execute($stmt) ;
  mysqli_stmt_bind_result($stmt, $lab_name, $first_name, $last_name, $lab_type, $full_address, $phone_number) ;
  mysqli_stmt_fetch($stmt) ;
  mysqli_stmt_close($stmt) ;
  // we will use this later
  $_SESSION['lab_type'] = $lab_type ;

  // selecting columns names to generate inputs depending on the columns names .
  $tableName = "prices";
  $query = "SELECT column_name FROM information_schema.columns WHERE table_name = ? ";
  $stmt = mysqli_prepare($con, $query);
  mysqli_stmt_bind_param($stmt, "s", $tableName) ;
  mysqli_stmt_execute($stmt);
  mysqli_stmt_store_result($stmt);
  mysqli_stmt_bind_result($stmt, $columnName);
  // we will fetch ($stmt) inside html section .

  $query = "SELECT * FROM prices where user_name = ?" ;
  $stmt_2 = mysqli_prepare($con, $query) ;
  mysqli_stmt_bind_param($stmt_2, "s", $_SESSION['username']) ;
  mysqli_stmt_execute($stmt_2) ;
  mysqli_stmt_bind_result($stmt_2, $price_row_id, $lab_id, $user_name, $price1, $price2, $price3, $price4, $price5, $price6,
  $price7, $price8, $price9, $price10, $price11, $price12, $price13, $price14, $price15, $price16, $price17, $price18, 
  $price19, $price20, $price21, $price22, $price23, $price24, $price25, $price26, $price27, $price28, 
  $price29, $price30, $price31, $price32, $price33, $price34, $price35, $price36, $price37, $price38, $price39, 
  $price40, $price41, $price42, $price43, $price44, $price45, $price46, $price47, $price48, $price49) ;
  mysqli_stmt_fetch($stmt_2) ;
  mysqli_stmt_close($stmt_2) ;

  $query = "SELECT id, filename, filedata FROM images WHERE lab_id = ?" ;
  $stmt_2 = mysqli_prepare($con, $query) ;
  mysqli_stmt_bind_param($stmt_2, "i", $_SESSION['id']) ;
  mysqli_stmt_execute($stmt_2) ;
  mysqli_stmt_store_result($stmt_2) ;
  mysqli_stmt_bind_result($stmt_2, $image_id, $fileName, $fileData) ;
  
  // we have two arrays , they will contain [img_name, img_data] , so it's array of arrays , 
  // first array will have the images which should be in the first column , and second array will 
  // have images which will be in second col , we will add to those arrays images , 
  // trying to keep the two columns in same height , and not too much different between their heights .
  $firstColumn = [] ;
  $secondColumn = [] ;

  // $colHeight array is for columns height , when we add image to a column we will increase its height
  // in the array , so colHeight[0] represent the height for first column , and colHeight[1] for second column ,
  $colHeight = array(0,0) ;
  
  while (mysqli_stmt_fetch($stmt_2)){
    // getting WxH for the image 
    $imgSize = getimagesizefromstring($fileData) ;
    $imgWidth = $imgSize[0] ;
    $imgHeight = $imgSize[1] ;
    // calculating aspect ratio for image
    $aspectR = $imgWidth / $imgHeight ;
    // the height stored in images table is the orginal height , so when we select the image and
    // try to echo it inside col , it will have img-fluid .. so the width will be set to 100% ..
    // so the height will change from original to keep the aspect ratio , maybe it will be less or more than original ..
    // so we will assume that the new widht is 200px for all images , and we can get the new 
    // height for all images if the width is 200px =>>> ( new-width/new-height = aspect-ratio = old-width/old-height ) 
    // new width is 200 so (200/new-h = aspect-ratio) => (new-h = 200/aspect-ratio) .. 
    // the idea of puting width 200 is to set same width on all images , we don't care about the width here 
    // because eventually we are sending the orginal WxH to html , but we did put width 200px here to see 
    // the real difference after changing aspect ratio to a new one (where width is same in all images) , cause in html we are changing 
    // aspect ratio cause we put images in col , and this will change the original width and height ,
    // example : let's assume that we didn't do this , stored WxH for img1 is 10x30 , img2 is 20x40 , 
    // if we do colHeihgt[0] = 30 (img1->height) , and colHeight[1] = 40 (img2->height) , the algorithm will add into col[0] cause it has less height
    // but if the col in html has width = 25 , so height for img1 will change to 75 insted of 30 , and im2 will change to 50 insted of 40 ,
    // we will add to column[0] (30) and not [1] (40) .. while we should add to column[1] cause in real
    // it has less height (50<75) , but we are adding to column[0] cause we have in colHeight
    // the original heights which we will be comparing , this is wrong , so we need to see if we use same width
    // on img1 and img2 , what is the new height , and now we can compare and add in the column with less height .
    $newHeight = 200/$aspectR ;
    // when selecting img from table , we have to encode it 
    $imageData = base64_encode($fileData);
    // this is the src for img 
    $imageSrc = 'data:image/jpeg;base64,' . $imageData;
    // getting the index of column with less height , 0 is for first col , 1 for second col .
    $min = getMin($colHeight) ;
    if($min==0){
      // because getMin function returned 0 .. it means that the first column has less height ,
      // so we will add the image to the first col , 
      // so we have to increas its height in $colHeight[0] , and we have to add
      // the image info to $firstColumn so we can output them later in html section .
      $colHeight[0] += $newHeight ;
      // $colHeight[0] += $imgHeight ;
      $firstColumn[] = [$fileName, $imageSrc, $image_id] ;
    }
    elseif($min==1){
      $colHeight[1] += $newHeight ;
      // $colHeight[1] += $imgHeight ;
      $secondColumn[] = [$fileName, $imageSrc, $image_id] ;
    }
  }

  function getMin($colHeight){
    $min_value = min($colHeight);
    $min_index = array_search($min_value, $colHeight);
    if($min_index==0){
      return 0 ;
    }
    else{
      return 1 ;
    }
  }
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="CSS/all.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" href="css/lab-profile.css">
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
              <a class="nav-link active" href="#">
                <i class="fa-solid fa-user"></i>
                الحساب الشخصي
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../lab_orders/lab-orders.php">
                <i class="fa-solid fa-bag-shopping"></i>
                قائمة الطلبات
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../lab_about/lab-about.php">
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
                <a class="nav-link active" href="#">
                  <i class="fa-solid fa-user"></i>
                  الحساب الشخصي
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../lab_orders/lab-orders.php">
                  <i class="fa-solid fa-bag-shopping"></i>
                  قائمة الطلبات
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../lab_about/lab-about.php">
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

    <div class="container-fluid pt-3 pe-5 ps-5 ">
      <!-- info section -->
      <div class="card fs-5">
        <div class="card-body">
          <p class="card-text">الاسم :
            <span class="text-secondary">
              <?php echo $first_name.' '.$last_name ; ?>
            </span>
          </p>
          <p class="card-text">اسم المخبر :
            <span class="text-secondary">
              <?php echo $lab_name ; ?>
            </span>
          </p>
          <p class="card-text">نوع المخبر :
            <span class="text-secondary">
              <?php echo $lab_type ; ?>
            </span>
          </p>
          <p class="card-text">المدينة :
            <span class="text-secondary">
              <?php echo $full_address ; ?>
            </span>
          </p>
          <p class="card-text">رقم الهاتف :
            <span class="text-secondary">
              <?php echo $phone_number ; ?>
            </span>
          </p>
        </div>
        <div class="card-footer text-center">
          <a href="../lab_profile_edit/lab-profile-edit.php">
            <button class="btn btn-secondary edit w-50 border-0">تعديل المعلومات</button>
          </a>
        </div>
      </div>
      <!-- info section -->
      <hr>
      <!-- prices section -->
      <div class="accordion" id="accordionExample">
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
              قائمة المواد
            </button>
          </h2>
          <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
              <div class="container-fluid">
                <form action="../database/price-edit.php" method="post">
                  <div class="row row-cols-1 row-cols-xl-2">
                    <?php
                      $i = -2 ;
                      if($lab_type=="تعويضات ثابتة"){   
                        while (mysqli_stmt_fetch($stmt)) {
                          // we use $i so we ignore the first three columns in the table (id,lab_id,user_name)
                          // first 14 columns are for fixed prosthodontists (ignoring id,lab_id,user_name)
                          if($i >= 1 && $i <= 14){
                            // previously we used stmt_bind_result with price1,price2,price3 .. etc 
                            // now for each input we will generate its value depending on $i .
                            $value = "price".$i;
                            echo '
                            <div class="col">
                              <label for="input'.$i.'" class="mb-1 text-secondary d-md-none">'.$columnName.'</label>
                              <div class="input-group mb-3" dir="ltr">
                                <span class="input-group-text">ل.س</span>
                                <input type="number" class="form-control" dir="rtl" lang="en" min="0" id="input'.$i.'" name="input'.$i.'" value="'.$$value.'" required>
                                <span class="input-group-text d-none d-md-inline-block">'.$columnName.'</span>
                              </div> 
                            </div>' ;
                          }

                          $i++ ;
                          if($i==16){
                            break ;
                          }

                        }
                      }

                      elseif($lab_type=="تعويضات متحركة"){   
                        while (mysqli_stmt_fetch($stmt)) {
                          // we use $i so we ignore the first three columns in the table (id,lab_id,user_name)
                          // columns from 15 to 49 are for removable prosthodontists (ignoring id,lab_id,user_name)
                          if($i >= 15 && $i <= 49){
                            // previously we used stmt_bind_result with price1,price2,price3 .. etc 
                            // now for each input we will generate its value depending on $i .
                            $value = "price".$i ;
                            echo '
                            <div class="col">
                              <label for="input'.$i.'" class="mb-1 text-secondary d-md-none">'.$columnName.'</label>
                              <div class="input-group mb-3" dir="ltr">
                                <span class="input-group-text">ل.س</span>
                                <input type="number" class="form-control" dir="rtl" lang="en" min="0" id="input'.$i.'" name="input'.$i.'" value="'.$$value.'" required>
                                <span class="input-group-text d-none d-md-inline-block">'.$columnName.'</span>
                              </div>
                            </div>' ;
                          }

                          $i++ ;
                          if($i==50){
                            break ;
                          }

                        }
                      }

                      else{   
                        while (mysqli_stmt_fetch($stmt)) {
                          // we use $i so we ignore the first three columns in the table (id,lab_id,user_name)
                          // columns from 1 to 49 are for fixed/removable prosthodontists (ignoring id,lab_id,user_name)
                          if($i >= 1 && $i <= 49){
                            // previously we used stmt_bind_result with price1,price2,price3 .. etc 
                            // now for each input we will generate its value depending on $i .
                            $value = "price".$i ;
                            echo '
                            <div class="col">
                              <label for="input'.$i.'" class="mb-1 text-secondary d-md-none">'.$columnName.'</label>
                              <div class="input-group mb-3" dir="ltr">
                                <span class="input-group-text">ل.س</span>
                                <input type="number" class="form-control" dir="rtl" lang="en" min="0" id="input'.$i.'" name="input'.$i.'" value="'.$$value.'" required>
                                <span class="input-group-text d-none d-md-inline-block">'.$columnName.'</span>
                              </div>
                            </div>' ;
                          }

                          $i++ ;
                          if($i==50){
                            break ;
                          }

                        }
                      }
                    ?>
                  </div>
                  <div class="w-100 text-center">
                    <button class="btn w-50 border-0 save text-light">حفظ</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div> 
      </div>
      <!-- prices section -->

      <!-- gallery section -->
      <div class="accordion mt-3" id="accordionTwo">
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
              معرض الأعمال
            </button>
          </h2>
          <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionTwo">
            <div class="accordion-body">
              <div class="container-fluid overflow-hidden">   
                <!-- this div for adding -->
                <div class="add-btn rounded border border-3 border-secondary my-2">
                  <i class="fa-regular fa-square-plus"></i>
                  <form action="../database/add-image.php" method="post" id="myForm" enctype="multipart/form-data">
                    <!-- because it's multiple we used [] in name -->
                    <input type="file" name="img[]" id="fileInput" multiple required>
                    <!-- we are submiting on change .. using js -->
                  </form>
                </div>
                <div class="row row-cols-1 row-cols-lg-2 gx-3"> 
                  <!-- first column -->
                  <div class="col">
                    <?php 
                      for($i=0 ; $i < count($firstColumn) ; $i++){
                        $imgInfo = $firstColumn[$i] ;
                        echo '
                          <form action="../database/deleting-img.php" method="post" class="position-relative mb-3" >
                            <img src="'.$imgInfo[1].'" class="w-100 rounded border border-3 border-secondary" alt="'.$imgInfo[0].'" style="height: auto;" >
                            <input type="text" name="img_id" value="'.$imgInfo[2].'" style="display: none ;" >
                            <button type="submit" class="delete-btn fs-3 text-white"> <i class="fa-solid fa-trash-can"></i> </button>
                          </form>
                        ' ;
                      } 
                    ?>
                  </div>
                  <!-- second column -->
                  <div class="col">
                    <?php 
                      for($i=0 ; $i < count($secondColumn) ; $i++){
                        $imgInfo = $secondColumn[$i] ;
                        echo '
                          <form action="../database/deleting-img.php" method="post" class="position-relative mb-3" >
                            <img src="'.$imgInfo[1].'" class="w-100 rounded border border-3 border-secondary" alt="'.$imgInfo[0].'" style="height: auto;" >
                            <input type="text" name="img_id" value="'.$imgInfo[2].'" style="display: none ;" >
                            <button type="submit" class="delete-btn fs-3 text-white"> <i class="fa-solid fa-trash-can"></i> </button>
                          </form>
                        ' ;
                      }
                    ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div> 
      </div>
      <!-- gallery section -->
    </div>
    <!--end of container  -->
  </main>
  <!-- end of the main container -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
  <script src="js/main.js"></script>
</body>

</html>