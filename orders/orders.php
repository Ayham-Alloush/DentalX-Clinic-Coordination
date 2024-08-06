<?php
    session_start() ; 
      
    // A user is considered logged in if the $_SESSION['username'] variable is set.
    if (!isset($_SESSION['username']) || $_SESSION['userType'] != "doctor"){
        // User is not logged in or not a doctor, redirect to login
        header("Location: ../index.html") ;
    }

    $con = mysqli_connect("localhost","root",) ;
    if (!$con){
        die ("connection error : ". mysqli_connect_error()) ;
    }

    mysqli_select_db($con,"mydb") ;

    $query = "SELECT id FROM users where user_name = ?" ;
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt,"s",$_SESSION['username']) ;
    mysqli_stmt_execute($stmt) ;
    mysqli_stmt_bind_result($stmt, $id) ;
    mysqli_stmt_fetch($stmt) ;
    mysqli_stmt_close($stmt) ;

    // getting info for each order from orders table
    $query = "SELECT id, lab_username, lab_name, lab_type, order_date, receive_date, patient_name, price, status, order_details_id FROM orders where doc_id = ?" ;
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "s", $id ) ;
    mysqli_stmt_execute($stmt) ;
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $order_id, $lab_user_name, $lab_name, $lab_type, $order_date, $receive_date, $patient_name, $price, $status, $order_details_id) ;
    // we will fetch ($stmt) inside html section . 

?>
<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/all.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/main.css">
    <title>قائمة الطلبات</title>
</head>

<body>
    <main>
        <!-- first navbar will be visible on all screens except small screen -->
        <nav class="navbar d-none d-sm-flex navbar-expand navbar-fixed-right align-items-start">
            <div class="container-fluid  p-0 flex-column align-items-start">
                <a class="navbar-brand" href="../doc_home/doc-home.php">DentalX</a>
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
                            <a class="nav-link" href="../doc_profile/doc-profile.php">
                                <i class="fa-solid fa-user"></i>
                                الحساب الشخصي
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
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
                <a class="navbar-brand" href="../doc_home/doc-home.php">DentalX</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                    aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                    aria-labelledby="offcanvasNavbarLabel">
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
                                <a class="nav-link" href="../doc_profile/doc-profile.php">
                                    <i class="fa-solid fa-user"></i>
                                    الحساب الشخصي
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="#">
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
        <div class="container-fluid pt-3 pe-5 ps-5 ">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
                <!-- card component -->
                <?php
                    while(mysqli_stmt_fetch($stmt)) {
                        $query = "SELECT order_details FROM order_details WHERE id=?" ;
                        $stmt2 = mysqli_prepare($con , $query) ;
                        mysqli_stmt_bind_param($stmt2, "i",$order_details_id);
                        mysqli_stmt_execute($stmt2);
                        mysqli_stmt_bind_result($stmt2, $order_details);
                        mysqli_stmt_fetch($stmt2);
                        mysqli_stmt_close($stmt2) ;
                        $details = json_decode($order_details, true);
                        if($status=="تم الرفض"){
                            $query = "SELECT reason FROM reasons WHERE order_id = ?" ;
                            $stmt2 = mysqli_prepare($con , $query) ;
                            mysqli_stmt_bind_param($stmt2, "i",$order_id);
                            mysqli_stmt_execute($stmt2);
                            mysqli_stmt_bind_result($stmt2, $reason);
                            mysqli_stmt_fetch($stmt2);
                            mysqli_stmt_close($stmt2) ;
                        }
                        else{
                            // cause if we didn't initialize this variable we will have error because we are using it in the tooltip
                            // even if status isn't rejected , but we d-none the tooltip and the info icon .
                            $reason = "nothing" ;
                        }

                        echo '
                            <div class="col">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <p class="card-text ">اسم المخبر :
                                            <span class="text-secondary">
                                                <a href="../lab_details/lab-details.php?lab_user_name='.$lab_user_name.'" class="text-decoration-none">
                                                    '.$lab_name.'
                                                </a>
                                            </span>
                                        </p>
                                        <p class="card-text ">نوع المخبر :
                                            <span class="text-secondary">'. $lab_type.'</span>
                                        </p>
                                        <p class="card-text ">تاريخ الطلب :
                                            <span class="text-secondary">'. $order_date.'</span>
                                        </p>
                                        <p class="card-text ">تاريخ الاستلام :
                                            <span class="text-secondary">'. $receive_date.'</span>
                                        </p>
                                        <p class="card-text ">اسم المريض :
                                            <span class="text-secondary">'. $patient_name.'</span>
                                        </p>
                                        <p class="card-text ">السعر :
                                            <span class="text-secondary">'. intval($price).'</span>
                                            <span class="text-secondary">ل.س</span>
                                        </p>
                                        <p class="card-text ">حالة الطلب :
                                            <span class="status badge p-2 fw-semibold">'. $status.'</span>
                                            <i class="fa-solid fa-circle-info text-danger reject-reason d-none" data-bs-custom-class="custom-tooltip"
                                                data-status="'.$status.'" data-bs-toggle="tooltip" data-bs-placement="top" 
                                                data-bs-title="'.$reason.'">
                                            </i>
                                        </p>
                                        <button type="button" class="btn btn-sm custom border-0 text-light w-100 fw-bold"
                                            data-bs-toggle="modal" data-bs-target="#detailsModalFor'.$order_id.'" >عرض التفاصيل</button>
                                    </div>
                                    <div class="card-footer text-center mt-0 order-footer" data-status="'.$status.'">
                                        <form method="post" action="../database/delete-order.php" id="cancelForm" class="d-none">
                                            <input type="text" value='.$order_id.' name="order-id" hidden>
                                            <button type="button" onclick="checkStatus(\''.$status.'\',\'cancelModal'.$order_id.'\')"  class="btn btn-sm btn-danger w-100 fw-bold">الغاء الطلب</button>
                                            <div class="modal" id="cancelModal'.$order_id.'" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">                                                
                                                    <div class="modal-body text-end pb-0">
                                                        <p>هل متأكد من إلغاء الطلب ؟</p>
                                                    </div>
                                                    <div class="modal-footer justify-content-center gap-3 p-1">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">الغاء</button>
                                                        <button type="submit" class="btn btn-danger">نعم</button>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        </form>

                                        <form method="post" action="../database/delete-order.php" id="removeForm" class="d-none">
                                            <input type="text" value='.$order_id.' name="order-id" hidden>
                                            <button type="button" onclick="checkStatus(\''.$status.'\',\'removeModal'.$order_id.'\')"  class="btn btn-sm btn-secondary w-100 fw-bold">حذف الطلب</button>
                                            <div class="modal" id="removeModal'.$order_id.'" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">                                                
                                                    <div class="modal-body text-end pb-0">
                                                        <p>هل متأكد من حذف الطلب من قائمة الطلبات ؟</p>
                                                    </div>
                                                    <div class="modal-footer justify-content-center gap-3 p-1">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">الغاء</button>
                                                        <button type="submit" class="btn btn-danger">نعم</button>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="modal fade" id="detailsModalFor'.$order_id.'" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">       
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
                                                    <tbody> ' ;
                                                        $i = 0 ;
                                                        $totalPrice = 0 ;
                                                        // $details was JSON object and we deocoded it , now it has 
                                                        // key : value , and we have inside it key=counts , value= array of counts
                                                        // and it has key=prices , value = array of prices  
                                                        // and key=items , value = array of items names .
                                                        while($i < count($details['counts']) ){
                                                            $countsArray = $details['counts'];
                                                            $itemsArray = $details['items'];
                                                            $pricesArray = $details['prices'];
                                                            $itemCount = $countsArray[$i] ;
                                                            $itemPrice = $pricesArray[$i] ;
                                                            $itemName = $itemsArray[$i] ;
                                                            $Price = $itemPrice * $itemCount ;
                                                            $totalPrice += $Price ; 
                                                            echo '
                                                            <tr>
                                                                <td>'.$itemName.'</td>
                                                                <td>'.$itemPrice.'</td>
                                                                <td>'.$itemCount.'</td>
                                                                <td>'.$Price.'</td>
                                                            </tr>
                                                            ' ;
                                                            $i++ ;
                                                        } 
                                                        echo '
                                                            <tr>
                                                                <th scope="row"  class="fw-bold">السعر النهائي</th>
                                                                <td colspan=3 class="fw-bold fs-5 text-danger">  '.$totalPrice.'  ل.س</td>
                                                            </tr>

                                                            <tr>
                                                             <td colspan=4 class="pt-3 border-0 opacity-0"></td>
                                                            <tr>
                                                            
                                                            <tr>
                                                                <th>درجة اللون</th>
                                                                <td colspan=3 >'.$details['item_color'].'</td>
                                                            </tr>

                                                            <tr>
                                                             <td colspan=4 class="pt-3 border-0 opacity-0"></td>
                                                            <tr>
                                                            
                                                            <tr>
                                                                <th>عمر المريض</th>
                                                                <td colspan=3 >'.$details['patient_age'].'</td>
                                                            </tr>
                                                            
                                                            <tr>
                                                                <th>مهنة المريض</th>
                                                                <td colspan=3 >'.$details['patient_work'].'</td>
                                                            </tr>

                                                            <tr>
                                                             <td colspan=4 class="pt-3 border-0 opacity-0"></td>
                                                            <tr>

                                                            <tr> 
                                                                <th colspan=4 class="text-center fw-bold" >ملاحظات</th>
                                                            </tr>

                                                            <tr>
                                                                <td colspan=4 class="">'.$details['notice'].'</td>
                                                            </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق</button>
                                        </div>
                                    </div>
                                </div>
                            </div> ' ;
                    } ;                                 
                ?>          
            </div>
            <!-- end of the row which has while loop , generating div.col and details modal for each order  -->
            
            <!-- this will be visible when doctor try to cancel order has already been accepted -->
            <div class="alert alert-danger position-fixed  bottom-0 start-50 translate-middle-x d-none" id="alert">
                لا يمكن الغاء الطلب في حال تم الموافقة عليه !
            </div>
        </div>
        <!-- end of container -->
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="js/main.js"></script>
</body>

</html>