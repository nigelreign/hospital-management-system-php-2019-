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
        $query = DB::query("SELECT * FROM patients where patient_id=%s", $username);
        if ($query) {
            foreach ($query as $row) {
                $_SESSION['role'] = 'patient';
                header("Location: patient.php?load=$username");

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
                                <label class="font-size-h6 font-weight-bolder text-dark">Patient ID</label>
                                <input required class="form-control form-control-solid h-auto p-6 rounded-lg"
                                       type="text"
                                       name="username" placeholder="Enter your patient ID" autocomplete="off"/>
                            </div>

                            <input type="hidden" name="login" value="1">

                            <center>
                                <a href="index.php">Login</a>
                                <div class="pb-lg-0 pb-5">
                                    <button type="submit"
                                            class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">
                                        View
                                    </button>
                                </div>
                            </center>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 bgi-size-contain bgi-no-repeat bgi-position-y-center bgi-position-x-center min-h-150px mt-10 m-md-0">
                    <? if (!empty($_GET['load'])) {
                        $query = DB::query("SELECT * FROM patients where patient_id=%s", $_GET['load']);
                        foreach ($query as $patient) {
                        }

                        ?>

                        <form method="post" data-parsley-validate>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input required type="text" di
                                           <? if ($_SESSION['role'] == 'patient') { ?>disabled<? } ?>
                                           value="<? echo $patient["first_name"] ?>"
                                           name="first_name"
                                           class="form-control"
                                           placeholder="Patient first name"/>
                                </div>

                                <div class="form-group">
                                    <center>
                                        <label>Middle Name</label>
                                        <input type="text"
                                               <? if ($_SESSION['role'] == 'patient') { ?>disabled<? } ?>
                                               value="<? echo $patient["middle_name"] ?>"
                                               name="middle_name"
                                               class="form-control"
                                               placeholder="Patient middle name"/>
                                    </center>
                                </div>

                                <div class="form-group">
                                    <center>
                                        <label>Surname</label>
                                        <input required type="text"
                                               <? if ($_SESSION['role'] == 'patient') { ?>disabled<? } ?>
                                               value="<? echo $patient["surname"] ?>" name="surname"
                                               class="form-control"
                                               placeholder="Surname"/>
                                    </center>
                                </div>
                                <div class="form-group">
                                    <center>
                                        <label>Date Of Birth</label>
                                        <input required type="date"
                                               <? if ($_SESSION['role'] == 'patient') { ?>disabled<? } ?>
                                               value="<? echo $patient["dob"] ?>" name="dob"
                                               class="form-control"
                                               placeholder="Surname"/>
                                    </center>
                                </div>
                                <div class="form-group">
                                    <center>
                                        <label>Gender</label>
                                        <select
                                            <? if ($_SESSION['role'] == 'patient') { ?>disabled<? } ?>
                                            type="text" required name="gender"
                                            class="form-control">
                                            <option value="">Select Gender</option>
                                            <option
                                                <? if ($patient["gender"] == 'Male'){ ?>selected<? } ?>
                                                value="Male">Male
                                            </option>
                                            <option
                                                <? if ($patient["gender"] == 'Female'){ ?>selected<? } ?>
                                                value="Female">Female
                                            </option>
                                        </select>
                                    </center>
                                </div>
                                <div class="form-group">
                                    <center>
                                        <label>National ID</label>
                                        <input
                                            <? if ($_SESSION['role'] == 'patient') { ?>disabled<? } ?>
                                            required type="text"
                                            value="<? echo $patient["national_id"] ?>"
                                            name="national_id"
                                            class="form-control"
                                            placeholder="National ID"/>
                                    </center>
                                </div>
                                <div class="form-group">
                                    <center>
                                        <label>Physical Address</label>
                                        <input required type="text"
                                               <? if ($_SESSION['role'] == 'patient') { ?>disabled<? } ?>
                                               value="<? echo $patient["address"] ?>" name="address"
                                               class="form-control"
                                               placeholder="Physical address"/>
                                    </center>
                                </div>
                                <div class="form-group">
                                    <center>
                                        <label>Phone Number</label>
                                        <input required type="text"
                                               <? if ($_SESSION['role'] == 'patient') { ?>disabled<? } ?>
                                               value="<? echo $patient["phone_number"] ?>"
                                               name="phone_number"
                                               class="form-control"
                                               placeholder="Phone number"/>
                                    </center>
                                </div>
                                <div class="form-group">
                                    <center>
                                        <label>Next Of Kin Full Name</label>
                                        <input required type="text"
                                               <? if ($_SESSION['role'] == 'patient') { ?>disabled<? } ?>
                                               value="<? echo $patient["next_of_kin_name"] ?>"
                                               name="next_of_kin_name"
                                               class="form-control"
                                               placeholder="Next of kin full name"/>
                                    </center>
                                </div>
                                <div class="form-group">
                                    <center>
                                        <label>Next Of Kin Physical Address</label>
                                        <input required type="text"
                                               <? if ($_SESSION['role'] == 'patient') { ?>disabled<? } ?>
                                               value="<? echo $patient["next_of_kin_address"] ?>"
                                               name="next_of_kin_address"
                                               class="form-control"
                                               placeholder="Next of kin physical address"/>
                                    </center>
                                </div>
                                <div class="form-group">
                                    <center>
                                        <label>Next Of Kin Phone Number</label>
                                        <input required type="text"
                                               <? if ($_SESSION['role'] == 'patient') { ?>disabled<? } ?>
                                               value="<? echo $patient["next_of_kin_phone_number"] ?>"
                                               name="next_of_kin_phone_number"
                                               class="form-control"
                                               placeholder="Next of kin phone number"/>
                                    </center>
                                </div>
                                <div class="form-group">
                                    <center>
                                        <label>Allergies</label>
                                        <textarea name="allergies"

                                                  <? if ($_SESSION['role'] == 'patient') { ?>disabled<? } ?>
                                                  class="form-control"><? echo $patient["allergies"] ?></textarea>
                                    </center>
                                </div>
                                <div class="form-group">
                                    <center>
                                        <label>Reason For Visit</label>
                                        <textarea name="reason"
                                                  <? if ($_SESSION['role'] == 'patient') { ?>disabled<? } ?>
                                                  class="form-control"><? echo $patient["reason"] ?></textarea>
                                    </center>
                                </div>
                                <div class="form-group">
                                    <center>
                                        <label>Admitted Till Date</label>
                                        <input required type="date"
                                               <? if ($_SESSION['role'] == 'patient') { ?>disabled<? } ?>
                                               value="<? echo $patient['discharge_date'] ?>"
                                               name="discharge_date"
                                               class="form-control"/>
                                    </center>
                                </div>
                            </div>

                        </form>
                    <? } else {
                        ?>

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

                    <? } ?>

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
        $query = DB::query("SELECT * FROM patients where patient_id=%s", $username);
        if ($query) {
            foreach ($query as $row) {

            }
        } else {
            echo "<script>
               swal({
       title: 'error',
       text: 'Incorrect patient ID',
       type: 'error'
       });
               </script>";
        }
    }
}
?>