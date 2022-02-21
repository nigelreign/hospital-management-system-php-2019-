<!DOCTYPE html>
<?
session_start();
require_once "../functions/database_connection/connect.php";
require_once '../functions/variables.php';


if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $pass = $_POST['password'];
    if (empty($username) && empty($pass)) {
    } else {
        $query = DB::query("SELECT * FROM users where email_address=%s", $username);
        if ($query) {
            foreach ($query as $row) {

                $hashed_password = $row['password'];
                $_SESSION['id'] = $row['id'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['username'] = $row['first_name'].' '.$row['last_name'];
                if (password_verify($pass, $hashed_password)) {

                    header("Location: ../portal/portal/");
                } else {
                }
            }
        }
    }
}
?>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
<head>
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({'gtm.start': new Date().getTime(), event: 'gtm.js'});
            var f = d.getElementsByTagName(s)[0], j = d.createElement(s), dl = l != 'dataLayer' ? '&amp;l=' + l : '';
            j.async = true;
            j.src = '../../../../../../www.googletagmanager.com/gtm5445.html?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-5FS8GGP');</script>
    <!-- End Google Tag Manager -->
    <meta charset="utf-8"/>
    <title>Hospital Management System</title>
    <meta name="description" content="Login page example"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>
    <!--end::Fonts-->
    <!--begin::Page Custom Styles(used by this page)-->
    <link href="../assets/css/pages/login/login-2b68f.css?v=2.0.7" rel="stylesheet" type="text/css"/>
    <!--end::Page Custom Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="../assets/plugins/global/plugins.bundleb68f.css?v=2.0.7" rel="stylesheet" type="text/css"/>
    <link href="../assets/plugins/custom/prismjs/prismjs.bundleb68f.css?v=2.0.7" rel="stylesheet" type="text/css"/>
    <link href="../assets/css/style.bundleb68f.css?v=2.0.7" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" href="../assets/sweetalert/sweetalert.css">
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <!--end::Layout Themes-->
    <link rel="shortcut icon"
          href="../assets/images/logo.png"/>

</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled aside-enabled aside-static page-loading">

<div class="d-flex flex-column flex-root">
    <div class="login login-2 login-signin-on d-flex flex-column flex-column-fluid bg-white position-relative overflow-hidden"
         id="kt_login">
        <div class="login-body d-flex flex-column-fluid align-items-stretch justify-content-center">
            <div class="container row">
                <div class="col-lg-6 d-flex align-items-center">
                    <!--begin::Signin-->
                    <div class="login-form login-signin">
                        <!--begin::Form-->

                        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>"
                              class="form w-xxl-550px rounded-lg p-20">

                            <div class="pb-13 pt-lg-0 pt-5">
                                <center>
                                    <img src="../assets/images/patient.png"
                                         alt="logo" class="h-200px"/>
                                </center>
                            </div>

                            <div class="form-group">
                                <label class="font-size-h6 font-weight-bolder text-dark">Email Address</label>
                                <input class="form-control form-control-solid h-auto p-6 rounded-lg" type="email"
                                       name="username" placeholder="Enter your email address" autocomplete="off"/>
                            </div>

                            <div class="form-group">
                                <div class="d-flex justify-content-between mt-n5">
                                    <label class="font-size-h6 font-weight-bolder text-dark pt-5">PASSWORD</label>
                                </div>
                                <input class="form-control form-control-solid h-auto p-6 rounded-lg" type="password"
                                       name="password" placeholder="Enter password" autocomplete="off"/>
                            </div>

                            <input type="hidden" name="login" value="1">

                            <center>
                                <a href="patient">View Patient Information</a>
                                <div class="pb-lg-0 pb-5">
                                    <button type="submit"
                                            class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">
                                        Sign
                                        In
                                    </button>
                                </div>
                            </center>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 bgi-size-contain bgi-no-repeat bgi-position-y-center bgi-position-x-center min-h-150px mt-10 m-md-0">
                    <center>

                        <div style="margin-top: 170px; margin-left: 140px">

                            <h1>HOSPITAL MANAGEMENT SYSTEM</h1>
                            <br>
                            <br>
                            <img style="height: 150px" src="../assets/images/hospital.png">
                            <br>
                            <br>

                        </div>
                    </center>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('contextmenu', event => event.preventDefault());
</script>

<script src="../assets/plugins/global/plugins.bundleb68f.js?v=2.0.7"></script>
<script src="../assets/plugins/custom/prismjs/prismjs.bundleb68f.js?v=2.0.7"></script>
<script src="../assets/js/scripts.bundleb68f.js?v=2.0.7"></script>
<script src="../assets/js/pages/custom/login/loginb68f.js?v=2.0.7"></script>
<script src="../assets/sweetalert/sweetalert.min.js"></script>
<script src="../assets/sweetalert/sweetalert-dev.js"></script>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
</body>
</html>
<?php
if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $pass = $_POST['password'];

    if (empty($username) && empty($pass)) {
        echo "<script>
               swal({
       title: 'error',
       text: 'Please enter your email address and password',
       type: 'error'
       });
               </script>";
    } else {
        $query = DB::query("SELECT * FROM users where email_address=%s", $username);
        if ($query) {
            foreach ($query as $row) {
                $hashed_password = $row['password'];
                $id = $row['id'];
                if (password_verify($pass, $hashed_password)) {
                } else {
                    echo "<script>
               swal({
       title: 'error',
       text: 'Incorrect password please try again',
       type: 'error'
       });
               </script>";
                }
            }
        } else {
            echo "<script>
               swal({
       title: 'error',
       text: 'Incorrect email address',
       type: 'error'
       });
               </script>";
        }
    }
}
?>