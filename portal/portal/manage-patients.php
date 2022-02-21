<?

require_once '../page_includes/connections.php';

require_once '../inc/head.php';


if (isset($_POST['update'])) {
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $surname = $_POST['surname'];
    $dob = $_POST['dob'];
    $national_id = $_POST['national_id'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $phone_number = $_POST['phone_number'];
    $next_of_kin_name = $_POST['next_of_kin_name'];
    $next_of_kin_address = $_POST['next_of_kin_address'];
    $next_of_kin_phone_number = $_POST['next_of_kin_phone_number'];
    $allergies = $_POST['allergies'];
    $reason = $_POST['reason'];
    $rdischarge_date = $_POST['discharge_date'];
    $update_id = $_POST['update_id'];
    DB::$error_handler = false; // since we're catching errors, don't need error handler DB::$throw_exception_on_error = true;
    DB::$throw_exception_on_error = true;
    // insert data
    try {

        $query = DB::update('patients', array(
            'first_name' => $first_name,
            'middle_name' => $middle_name,
            'surname' => $surname,
            'dob' => $dob,
            'gender' => $gender,
            'address' => $address,
            'national_id' => $national_id,
            'phone_number' => $phone_number,
            'next_of_kin_name' => $next_of_kin_name,
            'next_of_kin_address' => $next_of_kin_address,
            'next_of_kin_phone_number' => $next_of_kin_phone_number,
            'allergies' => $allergies,
            'reason' => $reason,
            'discharge_date' => $rdischarge_date,
        ), 'id=%i', $update_id);

        if ($query) {
            header("Location: manage-patients?id=$update_id&status=edit&message=success");
        }
    } catch (MeekroDBException $e) {
        $error = $e->getMessage();
        echo "    <script>  
    swal({
       title: \" $error\",
       text: \"error in saving data\",
       type: \"error\"
       });
        </script> ";
    }

    DB::$error_handler = 'meekrodb_error_handler';
    DB::$throw_exception_on_error = false;
}

if (isset($_POST['del'])) {
    $del = $_POST["id"];
    $query = DB::delete('patients', "id=%i", $del);

    if ($query) {
        header('location: manage-patients?message=deleted');
    }
}
if (isset($_POST['payment'])) {
    $patient_id = $_POST["patient_id"];
    $phone_number = $_POST["phone_number"];
    $amount = $_POST["amount"];
    $payment_method = $_POST["payment_method"];

    $query = DB::insert('patient_payments', array(
        'patient_id' => $patient_id,
        'phone_number' => $phone_number,
        'amount' => $amount,
    ));


    if ($query) {
        if ($payment_method == 'cash') {
            header('location: manage-patients?message=paid');
        } else {
            header("location: manage-patients?message=paidApi&api=$payment_method");
        }
    }
}

if (isset($_POST['ward'])) {
    $patient_id = $_POST["patient_id"];
    $ward_id = $_POST["ward_id"];

    $query = DB::insert('patient_ward', array(
        'patient_id' => $patient_id,
        'ward_id' => $ward_id,
    ));
    if (empty($ward_id)) {
        $query = DB::update('patients', array(
            'status' => 0,
        ), 'patient_id=%s', $patient_id);

        $query = DB::update('wards', array(
            'status' => 0,
        ), 'id=%s', $ward_id);
    } else {
        $query = DB::update('patients', array(
            'status' => 1,
        ), 'patient_id=%s', $patient_id);

        $query = DB::update('wards', array(
            'status' => 1,
        ), 'id=%s', $ward_id);

    }

    if ($query) {
        header("location: manage-patients?message=ward");

    }
}

if (isset($_POST['save'])) {

    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $surname = $_POST['surname'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $national_id = $_POST['national_id'];
    $phone_number = $_POST['phone_number'];
    $next_of_kin_name = $_POST['next_of_kin_name'];
    $next_of_kin_address = $_POST['next_of_kin_address'];
    $next_of_kin_phone_number = $_POST['next_of_kin_phone_number'];
    $allergies = $_POST['allergies'];
    $reason = $_POST['reason'];
    $rdischarge_date = $_POST['discharge_date'];

    DB::$error_handler = false; // since we're catching errors, don't need error handler DB::$throw_exception_on_error = true;
    DB::$throw_exception_on_error = true;
    // insert data
    try {

        $query = DB::query("SELECT count(id) FROM patients");
        foreach ($query as $row) {

            $hospitalAbr = 'UBH';
            $get_year = date('y');
            $patient_count = $row['count(id)'];

            $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charSurname = strlen($letters);
            $randomSurname = '';
            for ($i = 0; $i < 1; $i++) {
                $randomSurname .= $letters[rand(0, $charSurname)];
            }

            $patient_id = $hospitalAbr . strtoupper($randomSurname) . $get_year . $patient_count;
        }

        $query = DB::query("SELECT * FROM patients where national_id=%s", $national_id);
        if ($query) {
            header("Location: manage-patients?message=duplicate");
        } else {
            $query = DB::insert('patients', array(
                'patient_id' => $patient_id,
                'first_name' => $first_name,
                'middle_name' => $middle_name,
                'surname' => $surname,
                'dob' => $dob,
                'gender' => $gender,
                'national_id' => $national_id,
                'address' => $address,
                'phone_number' => $phone_number,
                'next_of_kin_name' => $next_of_kin_name,
                'next_of_kin_address' => $next_of_kin_address,
                'next_of_kin_phone_number' => $next_of_kin_phone_number,
                'allergies' => $allergies,
                'reason' => $reason,
                'discharge_date' => $rdischarge_date,
            ));

            if ($query) {
                header("Location: manage-patients?message=added");
            }
        }
    } catch (MeekroDBException $e) {
        $error = $e->getMessage();
        echo "    <script>  
    swal({
       title: \" $error\",
       text: \"error in saving data\",
       type: \"error\"
       });
        </script> ";
    }

    DB::$error_handler = 'meekrodb_error_handler';
    DB::$throw_exception_on_error = false;
}

?>
    <body id="kt_body"
          class="header-fixed header-mobile-fixed subheader-enabled aside-enabled aside-static page-loading">
<? require_once '../page_includes/aside.php' ?>
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-row flex-column-fluid page">
            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                <? require_once '../page_includes/top_bar.php' ?>
                <? require_once '../page_includes/breadcrumb.php' ?>
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="d-flex flex-column-fluid">
                        <div class="container">
                            <div class="row">
                                <? if ($_SESSION['role'] == 'doctor') {
                                } else {
                                    ?>

                                    <div class="col-md-4">
                                        <div class="card card-custom gutter-b example example-compact">
                                            <?
                                            if ($_GET["message"] == "success") {
                                                ?>
                                                <div class="alert alert-success" role="alert">Updated successfully</div>
                                                <?
                                            }
                                            if ($_GET["message"] == "added") {
                                                ?>
                                                <div class="alert alert-success" role="alert">Added successfully</div>
                                                <?
                                            }
                                            if ($_GET["message"] == "deleted") {
                                                ?>
                                                <div class="alert alert-success" role="alert">Deleted successfully</div>
                                                <?
                                            }
                                            if ($_GET["message"] == "duplicate") {
                                                ?>
                                                <div class="alert alert-danger" role="alert">Patient not added.
                                                    Duplicate ID
                                                    Number
                                                </div>
                                                <?
                                            }
                                            if ($_GET["message"] == "paidApi") {
                                                ?>
                                                <div class="alert alert-warning" role="alert">Payment Initiated but <?
                                                    echo $_GET['api'] ?> api not found
                                                </div>
                                                <?
                                            }
                                            if ($_GET["message"] == "paid") {
                                                ?>
                                                <div class="alert alert-success" role="alert">Payment Initiated
                                                    successfully
                                                </div>
                                                <?
                                            }
                                            if ($_GET["message"] == "ward") {
                                                ?>
                                                <div class="alert alert-success" role="alert">Ward details changed
                                                    successfully
                                                </div>
                                                <?
                                            }
                                            ?>
                                            <div class="card-header">
                                                <? if ($_GET['status'] == "edit") { ?>
                                                    <h2 style="color: green" class="card-title">
                                                        Edit Patient
                                                    </h2>
                                                <? } else { ?>
                                                    <h3 class="card-title">
                                                        Add Patient
                                                    </h3>
                                                <? } ?>
                                            </div>
                                            <? if ($_GET['status'] == "edit") {
                                                $query = DB::query("SELECT * FROM patients where id=%i", $_GET['id']);
                                                foreach ($query as $patient) {
                                                }
                                            }
                                            ?>
                                            <!--begin::Form-->
                                            <form method="post" data-parsley-validate
                                                  action="<?php echo $_SERVER['PHP_SELF'] ?>">
                                                <? if ($_GET['status'] == "edit") { ?>
                                                    <center>
                                                        <a href="manage-patients.php"
                                                           class="btn btn-light-primary px-6 font-weight-bold">Add New
                                                            Patient</a>
                                                    </center>
                                                <? } ?>

                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label>First Name</label>
                                                        <input required type="text"
                                                               value="<? echo $patient["first_name"] ?>"
                                                               name="first_name"
                                                               class="form-control"
                                                               placeholder="Patient first name"/>
                                                    </div>

                                                    <div class="form-group">
                                                        <center>
                                                            <label>Middle Name</label>
                                                            <input type="text"
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
                                                                   value="<? echo $patient["surname"] ?>" name="surname"
                                                                   class="form-control"
                                                                   placeholder="Surname"/>
                                                        </center>
                                                    </div>
                                                    <div class="form-group">
                                                        <center>
                                                            <label>Date Of Birth</label>
                                                            <input required type="date"
                                                                   value="<? echo $patient["dob"] ?>" name="dob"
                                                                   class="form-control"
                                                                   placeholder="Surname"/>
                                                        </center>
                                                    </div>
                                                    <div class="form-group">
                                                        <center>
                                                            <label>Gender</label>
                                                            <select type="text" required name="gender"
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
                                                            <input required type="text"
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
                                                                   value="<? echo $patient["address"] ?>" name="address"
                                                                   class="form-control"
                                                                   placeholder="Physical address"/>
                                                        </center>
                                                    </div>
                                                    <div class="form-group">
                                                        <center>
                                                            <label>Phone Number</label>
                                                            <input required type="text"
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
                                                                      class="form-control"><? echo $patient["allergies"] ?></textarea>
                                                        </center>
                                                    </div>
                                                    <div class="form-group">
                                                        <center>
                                                            <label>Reason For Visit</label>
                                                            <textarea name="reason"
                                                                      class="form-control"><? echo $patient["reason"] ?></textarea>
                                                        </center>
                                                    </div>
                                                    <div class="form-group">
                                                        <center>
                                                            <label>Admitted Till Date</label>
                                                            <input required type="date"
                                                                   value="<? echo $patient['discharge_date'] ?>"
                                                                   name="discharge_date"
                                                                   class="form-control"/>
                                                        </center>
                                                    </div>
                                                </div>

                                                <? if ($_GET['status'] == "edit") { ?>
                                                    <input name="update" type="hidden" value="1"/>
                                                    <input name="update_id" type="hidden"
                                                           value="<? echo $_GET['id'] ?>"/>
                                                <? } else { ?>
                                                    <input name="save" type="hidden" value="1"/>
                                                <? } ?>
                                                <div class="card-footer">
                                                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                                    <button type="reset" class="btn btn-secondary">Cancel</button>
                                                </div>
                                            </form>
                                            <!--end::Form-->
                                        </div>
                                    </div>
                                    <?
                                }
                                if ($_GET['status'] == 'edit' && $_SESSION['role'] == 'doctor') { ?>
                                    <div class="col-md-4">
                                        <div class="card card-custom gutter-b example example-compact">
                                            <?
                                            if ($_GET["message"] == "success") {
                                                ?>
                                                <div class="alert alert-success" role="alert">Updated successfully</div>
                                                <?
                                            }
                                            if ($_GET["message"] == "added") {
                                                ?>
                                                <div class="alert alert-success" role="alert">Added successfully</div>
                                                <?
                                            }
                                            if ($_GET["message"] == "deleted") {
                                                ?>
                                                <div class="alert alert-success" role="alert">Deleted successfully</div>
                                                <?
                                            }
                                            if ($_GET["message"] == "duplicate") {
                                                ?>
                                                <div class="alert alert-danger" role="alert">Patient not added.
                                                    Duplicate ID
                                                    Number
                                                </div>
                                                <?
                                            }
                                            if ($_GET["message"] == "paidApi") {
                                                ?>
                                                <div class="alert alert-warning" role="alert">Payment Initiated but <?
                                                    echo $_GET['api'] ?> api not found
                                                </div>
                                                <?
                                            }
                                            if ($_GET["message"] == "paid") {
                                                ?>
                                                <div class="alert alert-success" role="alert">Payment Initiated
                                                    successfully
                                                </div>
                                                <?
                                            }
                                            if ($_GET["message"] == "ward") {
                                                ?>
                                                <div class="alert alert-success" role="alert">Ward details changed
                                                    successfully
                                                </div>
                                                <?
                                            }
                                            ?>
                                            <div class="card-header">
                                                <? if ($_GET['status'] == "edit") { ?>
                                                    <h2 style="color: green" class="card-title">
                                                        Edit Patient
                                                    </h2>
                                                <? } else { ?>
                                                    <? if ($_SESSION['role'] == 'doctor') {
                                                    } else { ?>
                                                        <h3 class="card-title">
                                                            Add Patient
                                                        </h3>
                                                    <? } ?>
                                                <? } ?>
                                            </div>
                                            <? if ($_GET['status'] == "edit") {
                                                $query = DB::query("SELECT * FROM patients where id=%i", $_GET['id']);
                                                foreach ($query as $patient) {
                                                }
                                            }
                                            ?>
                                            <!--begin::Form-->
                                            <form method="post" data-parsley-validate
                                                  action="<?php echo $_SERVER['PHP_SELF'] ?>">
                                                <? if ($_GET['status'] == "edit") { ?>
                                                    <center>
                                                        <? if ($_SESSION['role'] == 'doctor') {
                                                        } else { ?>
                                                            <a href="manage-patients.php"
                                                               class="btn btn-light-primary px-6 font-weight-bold">Add
                                                                New
                                                                Patient</a>
                                                        <? } ?>

                                                    </center>
                                                <? } ?>

                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label>First Name</label>
                                                        <input required type="text"
                                                               <? if ($_SESSION['role'] == 'doctor') { ?>disabled<? } ?>
                                                               value="<? echo $patient["first_name"] ?>"
                                                               name="first_name"
                                                               class="form-control"
                                                               placeholder="Patient first name"/>
                                                    </div>

                                                    <div class="form-group">
                                                        <center>
                                                            <label>Middle Name</label>
                                                            <input type="text"
                                                                   <? if ($_SESSION['role'] == 'doctor') { ?>disabled<? } ?>
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
                                                                   <? if ($_SESSION['role'] == 'doctor') { ?>disabled<? } ?>
                                                                   value="<? echo $patient["surname"] ?>" name="surname"
                                                                   class="form-control"
                                                                   placeholder="Surname"/>
                                                        </center>
                                                    </div>
                                                    <div class="form-group">
                                                        <center>
                                                            <label>Date Of Birth</label>
                                                            <input required type="date"
                                                                   <? if ($_SESSION['role'] == 'doctor') { ?>disabled<? } ?>
                                                                   value="<? echo $patient["dob"] ?>" name="dob"
                                                                   class="form-control"
                                                                   placeholder="Surname"/>
                                                        </center>
                                                    </div>
                                                    <div class="form-group">
                                                        <center>
                                                            <label>Gender</label>
                                                            <select
                                                                <? if ($_SESSION['role'] == 'doctor') { ?>disabled<? } ?>
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
                                                                <? if ($_SESSION['role'] == 'doctor') { ?>disabled<? } ?>
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
                                                                   <? if ($_SESSION['role'] == 'doctor') { ?>disabled<? } ?>
                                                                   value="<? echo $patient["address"] ?>" name="address"
                                                                   class="form-control"
                                                                   placeholder="Physical address"/>
                                                        </center>
                                                    </div>
                                                    <div class="form-group">
                                                        <center>
                                                            <label>Phone Number</label>
                                                            <input required type="text"
                                                                   <? if ($_SESSION['role'] == 'doctor') { ?>disabled<? } ?>
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
                                                                   <? if ($_SESSION['role'] == 'doctor') { ?>disabled<? } ?>
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
                                                                   <? if ($_SESSION['role'] == 'doctor') { ?>disabled<? } ?>
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
                                                                   <? if ($_SESSION['role'] == 'doctor') { ?>disabled<? } ?>
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
                                                                      class="form-control"><? echo $patient["allergies"] ?></textarea>
                                                        </center>
                                                    </div>
                                                    <div class="form-group">
                                                        <center>
                                                            <label>Reason For Visit</label>
                                                            <textarea name="reason"
                                                                      <? if ($_SESSION['role'] == 'doctor') { ?>disabled<? } ?>
                                                                      class="form-control"><? echo $patient["reason"] ?></textarea>
                                                        </center>
                                                    </div>
                                                    <div class="form-group">
                                                        <center>
                                                            <label>Admitted Till Date</label>
                                                            <input required type="date"
                                                                   value="<? echo $patient['discharge_date'] ?>"
                                                                   name="discharge_date"
                                                                   class="form-control"/>
                                                        </center>
                                                    </div>
                                                </div>

                                                <? if ($_GET['status'] == "edit") { ?>
                                                    <input name="update" type="hidden" value="1"/>
                                                    <input name="update_id" type="hidden"
                                                           value="<? echo $_GET['id'] ?>"/>
                                                <? } else { ?>
                                                    <input name="save" type="hidden" value="1"/>
                                                <? } ?>
                                                <div class="card-footer">
                                                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                                    <button type="reset" class="btn btn-secondary">Cancel</button>
                                                </div>
                                            </form>
                                            <!--end::Form-->
                                        </div>
                                    </div>
                                <? } ?>
                                <div <? if ($_SESSION['role'] == 'doctor' && empty($_GET['status'])) { ?> class="col-md-12" <? } else { ?>class="col-md-8"<? } ?>>

                                    <div class="card card-custom">
                                        <div class="card-header flex-wrap border-0 pt-6 pb-0">
                                            <div class="card-title">
                                                <h3 class="card-label">View Patients
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-7">
                                                <div class="row align-items-center">
                                                    <div class="col-lg-9 col-xl-8">
                                                        <div class="row align-items-center">
                                                            <div class="col-md-4 my-2 my-md-0">
                                                                <div class="input-icon">
                                                                    <input type="text" class="form-control"
                                                                           placeholder="Search..."
                                                                           id="kt_datatable_search_query"/>
                                                                    <span>
																	<i class="fa fa-search text-muted"></i>
																</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-xl-4 mt-5 mt-lg-0">
                                                        <a href="#" class="btn btn-light-primary px-6 font-weight-bold">Search</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <table class="datatable datatable-bordered datatable-head-custom"
                                                   id="kt_datatable">
                                                <thead>
                                                <tr>
                                                    <th title="Field #2">Patient Number</th>
                                                    <th title="Field #2">Patient Name</th>
                                                    <th title="Field #2">National ID</th>
                                                    <th title="Field #2">Ward Admitted</th>
                                                    <th title="Field #2">Reason</th>
                                                    <th title="Field #2">Allergies</th>
                                                    <th title="Field #2">Total Amount Paid</th>
                                                    <th title="Field #2">Duration Of Visit</th>
                                                    <th title="Field #8">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?
                                                $query = DB::query("SELECT * FROM patients order by first_name ASC");
                                                foreach ($query
                                                         as $row):
                                                    $query = DB::query("SELECT SUM(amount) FROM patient_payments where patient_id=%s", $row['patient_id']);
                                                    foreach ($query
                                                             as $payment):
                                                        $query = DB::query("SELECT * FROM patient_ward where patient_id=%s", $row['patient_id']);
                                                        foreach ($query
                                                                 as $patient_ward) {
                                                        }
                                                        $query = DB::query("SELECT * FROM wards where id=%s", $patient_ward["ward_id"]);
                                                        foreach ($query
                                                                 as $ward) {
                                                        }

                                                        if (!empty($payment["SUM(amount)"])) {
                                                            $paid = $payment['SUM(amount)'];
                                                        } else {
                                                            $paid = 0;
                                                        }

                                                        if ($row["status"] == 1) {
                                                            $ward_ = $ward['ward_name'];
                                                        } else {
                                                            $ward_ = "Not admitted";
                                                        }

                                                        $current_date = date("Y-m-d");
                                                        $date1 = strtotime($row['discharge_date']);
                                                        $date2 = strtotime($current_date);

                                                        $diff = abs($date2 - $date1);
                                                        $years = floor($diff / (365 * 60 * 60 * 24));
                                                        $months = floor(($diff - $years * 365 * 60 * 60 * 24)
                                                            / (30 * 60 * 60 * 24));
                                                        $days = floor(($diff - $years * 365 * 60 * 60 * 24 -
                                                                $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                                                        ?>
                                                        <tr>
                                                            <td><p <? if ($paid == 0){
                                                                   ?>style="color: red"<? } ?>><? echo $row["patient_id"] ?></p>
                                                            </td>
                                                            <td><p <? if ($paid == 0){
                                                                   ?>style="color: red"<? } ?>><? echo $row["first_name"] . ' ' . $row['middle_name'] . ' ' . $row['surname'] ?></p>
                                                            </td>
                                                            <td><p <? if ($paid == 0){
                                                                   ?>style="color: red"<? } ?>><? echo $row["national_id"] ?></p>
                                                            </td>
                                                            <td><p <? if ($paid == 0){
                                                                   ?>style="color: red"<? } ?>><? echo $ward_ ?></p>
                                                            </td>
                                                            <td><p <? if ($paid == 0){
                                                                   ?>style="color: red"<? } ?>><? echo $row["reason"] ?></p>
                                                            </td>

                                                            <td><p <? if ($paid == 0){
                                                                   ?>style="color: red"<? } ?>><? echo $row["allergies"] ?></p>
                                                            </td>
                                                            <td><p <? if ($paid == 0){
                                                                   ?>style="color: red"<? } ?>>$<? echo $paid ?></p>
                                                            </td>
                                                            <td><p <? if ($paid == 0){
                                                                   ?>style="color: red"<? } ?>><? echo $days ?> Days</p>
                                                            </td>
                                                            <td>
                                                                <? if ($_SESSION['role'] == 'doctor') { ?>
                                                                <? } else { ?>
                                                                    <a href="#payment<?php echo $row['id'] ?>"
                                                                       class="btn btn-secondary btn-sm"
                                                                       style="padding:0px 0px;" data-toggle="modal"><i
                                                                                class="icon-trash"></i>Make payment</a>
                                                                    <a href="#del<?php echo $row['id'] ?>"
                                                                       class="btn btn-danger btn-sm"
                                                                       style="padding:0px 0px;" data-toggle="modal"><i
                                                                                class="icon-trash"></i>Delete</a>
                                                                <? } ?>
                                                                <a href="#ward<?php echo $row['id'] ?>"
                                                                   class="btn btn-success btn-sm"
                                                                   style="padding:0px 0px;" data-toggle="modal"><i
                                                                            class="icon-trash"></i>Add To Ward</a>
                                                                <a href="manage-patients?id=<?php echo $row['id'] ?>&status=edit"
                                                                   class="btn btn-primary btn-sm"
                                                                   style="padding:0px 0px;""><i
                                                                        class="icon-pen"></i>Edit</a>
                                                            </td>


                                                        </tr>

                                                        <div aria-hidden="true" aria-labelledby="myModalLabel"
                                                             role="dialog"
                                                             tabindex="-1"
                                                             id="ward<?php echo $row['id'] ?>" class="modal fade">
                                                            <div class="modal-dialog " role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h2 id="exampleModalLabel" class="modal-title">
                                                                            Make Payment</h2>
                                                                        <button type="button" class="close"
                                                                                data-dismiss="modal"
                                                                                aria-hidden="true"
                                                                                aria-label="Close">&times;
                                                                        </button>

                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="manage-patients" method="POST">
                                                                            <input type="hidden"
                                                                                   value="<?php echo $row['patient_id'] ?>"
                                                                                   name="patient_id">

                                                                            <div class="form-group">
                                                                                <center>
                                                                                    <label>Ward</label>
                                                                                    <select type="text" required
                                                                                            name="ward_id"
                                                                                            class="form-control">
                                                                                        <option value="">Select Ward
                                                                                        </option>
                                                                                        <option
                                                                                                value="">Not
                                                                                            admitted
                                                                                        </option>
                                                                                        <? $query = DB::query("SELECT * FROM wards Order by ward_name ASC");
                                                                                        foreach ($query as $row):
                                                                                            ?>
                                                                                            <option value="<?php echo $row['id'] ?>"> <? echo $row['ward_name'] ?></option>
                                                                                        <?
                                                                                        endforeach; ?>

                                                                                    </select>
                                                                                </center>
                                                                            </div>
                                                                            <div class="form-row">
                                                                                <input type="submit"
                                                                                       class="btn btn-success"
                                                                                       value="Proceed"
                                                                                       name="ward"><br>
                                                                                <button type="button"
                                                                                        class="btn btn-secondary"
                                                                                        data-dismiss="modal">NO
                                                                                </button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div aria-hidden="true" aria-labelledby="myModalLabel"
                                                             role="dialog"
                                                             tabindex="-1"
                                                             id="payment<?php echo $row['id'] ?>" class="modal fade">
                                                            <div class="modal-dialog " role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h2 id="exampleModalLabel" class="modal-title">
                                                                            Make Payment</h2>
                                                                        <button type="button" class="close"
                                                                                data-dismiss="modal"
                                                                                aria-hidden="true"
                                                                                aria-label="Close">&times;
                                                                        </button>

                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="manage-patients" method="POST">
                                                                            <input type="hidden"
                                                                                   value="<?php echo $row['patient_id'] ?>"
                                                                                   name="patient_id">
                                                                            <div class="form-group">
                                                                                <center>
                                                                                    <label>Phone Number To Bill</label>
                                                                                    <input required type="text"
                                                                                           value="<? echo $patient["phone_number"] ?>"
                                                                                           name="phone_number"
                                                                                           class="form-control"
                                                                                           placeholder="Enter mobile number to bill"/>
                                                                                </center>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <center>
                                                                                    <label>Amount</label>
                                                                                    <input required type="number"
                                                                                           value="<? echo $patient["amount"] ?>"
                                                                                           name="amount"
                                                                                           class="form-control"
                                                                                           placeholder="Enter amount"/>
                                                                                </center>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <center>
                                                                                    <label>Payment Method</label>
                                                                                    <select type="text" required
                                                                                            name="payment_method"
                                                                                            class="form-control">
                                                                                        <option value="">Select Payment
                                                                                            Method
                                                                                        </option>
                                                                                        <option
                                                                                                value="cash">Cash
                                                                                        </option>
                                                                                        <option
                                                                                                value="ecocash">Ecocash
                                                                                        </option>
                                                                                        <option
                                                                                                value="onemoney">
                                                                                            Onemoney
                                                                                        </option>
                                                                                    </select>
                                                                                </center>
                                                                            </div>
                                                                            <center>
                                                                                <img src="../../assets/images/ecocash.png"
                                                                                     width="140">
                                                                                <img src="../../assets/images/onemoney.png"
                                                                                     width="80">
                                                                            </center>
                                                                            <div class="form-row">
                                                                                <input type="submit"
                                                                                       class="btn btn-success"
                                                                                       value="Proceed"
                                                                                       name="payment"><br>
                                                                                <button type="button"
                                                                                        class="btn btn-secondary"
                                                                                        data-dismiss="modal">NO
                                                                                </button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div aria-hidden="true" aria-labelledby="myModalLabel"
                                                             role="dialog"
                                                             tabindex="-1"
                                                             id="del<?php echo $row['id'] ?>" class="modal fade">
                                                            <div class="modal-dialog " role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h2 id="exampleModalLabel" class="modal-title">
                                                                            ARE
                                                                            YOU
                                                                            SURE YOU
                                                                            WANT TO DELETE</h2>
                                                                        <button type="button" class="close"
                                                                                data-dismiss="modal"
                                                                                aria-hidden="true"
                                                                                aria-label="Close">&times;
                                                                        </button>

                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="manage-patients" method="POST">
                                                                            <input type="hidden"
                                                                                   value="<?php echo $row['id'] ?>"
                                                                                   name="id">
                                                                            <div class="form-row">
                                                                                <input type="submit"
                                                                                       class="btn btn-danger"
                                                                                       value="YES"
                                                                                       name="del"><br>
                                                                                <button type="button"
                                                                                        class="btn btn-secondary"
                                                                                        data-dismiss="modal">NO
                                                                                </button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <? endforeach; ?>
                                                <? endforeach; ?>
                                                </tbody>
                                            </table>
                                            <!--end: Datatable-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <? require_once '../page_includes/page_footer.php' ?>
            </div>
        </div>
    </div>
<? require_once '../inc/footer.php' ?>
    <script src="../../assets/js/pages/features/ktdatatable/base/html-tableb68f.js?v=2.0.7"></script>
    <script src="../../assets/js/pages/widgetsb68f.js?v=2.0.7"></script>

<?


?>