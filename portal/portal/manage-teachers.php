<?

require_once '../page_includes/connections.php';
$query = DB::query("SELECT * FROM admin_security where id=1");
foreach ($query as $JHJvdW5kcz01M)

    if ($_SESSION['token'] != $JHJvdW5kcz01M['token']) {
        header("Location: ../../signout?message=unauthorized_access");
    }
require_once '../inc/head.php';

    if($_GET['edit']) {
        $query = DB::query("SELECT * FROM staff_members where id=%i", $_GET['id']);
        if (!$query) {
            header('location: manage-teachers');
        }
    }

    if (isset($_POST['update'])) {
        $firstName = $_POST['firstName'];
        $middleName = $_POST['middleName'];
        $lastName = $_POST['lastName'];
        $mobile = $_POST['mobile'];
        $email_address = $_POST['email_address'];
        $password = $_POST['password'];
        $class_id = $_POST['class_id'];
        $subject_id = $_POST['subject_id'];
        $description = $_POST['description'];
        $update_id = $_POST['update_id'];
        DB::$error_handler = false; // since we're catching errors, don't need error handler DB::$throw_exception_on_error = true;
        DB::$throw_exception_on_error = true;
        // insert data
        try {
            $query = DB::delete('class_assign_teacher', "teacher_id=%i", $update_id);
            $query = DB::delete('subject_assign_teacher', "teacher_id=%i", $update_id);

            $hashed = password_hash($password, PASSWORD_DEFAULT);
            if (!empty($password)) {
                $query = DB::update('staff_members', array(
                    'firstName' => $firstName,
                    'middleName' => $middleName,
                    'lastName' => $lastName,
                    'mobile' => $mobile,
                    'email_address' => $email_address,
                    'password' => $hashed,
                    'description' => $description,
                ), 'id=%i', $update_id);
            } else {
                $query = DB::update('staff_members', array(
                    'firstName' => $firstName,
                    'middleName' => $middleName,
                    'lastName' => $lastName,
                    'mobile' => $mobile,
                    'email_address' => $email_address,
                    'description' => $description,
                ), 'id=%i', $update_id);
            }

            foreach ($class_id as $chk1) {
                $query2 = DB::insert('class_assign_teacher', array(
                    'teacher_id' => $update_id,
                    'class_id' => $chk1
                ));
            }
            foreach ($subject_id as $chk2) {
                $query2 = DB::insert('subject_assign_teacher', array(
                    'teacher_id' => $update_id,
                    'subject_id' => $chk2
                ));
            }

            if ($query) {
                header("Location: manage-teachers?id=$update_id&status=edit&message=success");
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
        $query = DB::delete('staff_members', "id=%i", $del);

        $query = DB::delete('class_assign_teacher', "teacher_id=%i", $update_id);
        $query = DB::delete('subject_assign_teacher', "teacher_id=%i", $update_id);
        if ($query) {
            header('location: manage-teachers?message=deleted');
        }
    }

    if (isset($_POST['save'])) {

    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $mobile = $_POST['mobile'];
    $email_address = $_POST['email_address'];
    $password = $_POST['password'];
    $class_id = $_POST['class_id'];
    $subject_id = $_POST['subject_id'];
    $description = $_POST['description'];

    DB::$error_handler = false; // since we're catching errors, don't need error handler DB::$throw_exception_on_error = true;
    DB::$throw_exception_on_error = true;
    // insert data
    try {

        $randomLetter = 'ABCDEFGHIJKLMNPQRSTUVWXYZABCDEFGHIJKLMNPQRSTUVWXYZABCDEFGHIJKLMNPQRSTUVWXYZ';
        $random = '';
        for ($i = 0; $i < 1; $i++) {
            $random .= $randomLetter[rand(0, 26)];
        }
        $randomName = '';
        $text = strtoupper('1234567890123456789');
        $nameDisplay = strlen('1234567890123456789');
        for ($i = 0; $i < 1; $i++) {
            $randomName .= $text[rand(0, $nameDisplay)];
        }
        $get_year = date('Y');
        $gen_id = $get_year . $randomName . $random;


        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $query = DB::insert('staff_members', array(
            'firstName' => $firstName,
            'middleName' => $middleName,
            'lastName' => $lastName,
            'mobile' => $mobile,
            'email_address' => $email_address,
            'password' => $hashed,
            'description' => $description,
            'role_id' => 1,
            'gen_id' => $gen_id
        ));

        $query = DB::query("SELECT * FROM staff_members where gen_id=%s", $gen_id);
        foreach ($query
                 as $staff)

            foreach ($class_id as $chk1) {
                $query2 = DB::insert('class_assign_teacher', array(
                    'teacher_id' => $staff['id'],
                    'class_id' => $chk1
                ));
            }
        foreach ($subject_id as $chk2) {
            $query2 = DB::insert('subject_assign_teacher', array(
                'teacher_id' => $staff['id'],
                'subject_id' => $chk2
            ));
        }

        if ($query) {
            header("Location: manage-teachers?message=added");
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

<? require_once '../page_includes/aside.php'?>

<div class="d-flex flex-column flex-root">
    <div class="d-flex flex-row flex-column-fluid page">
        <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
            <? require_once '../page_includes/top_bar.php' ?>
            <? require_once '../page_includes/breadcrumb.php' ?>
            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                <div class="d-flex flex-column-fluid">
                    <div class="container">
                        <div class="row">
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
                                    ?>
                                    <div class="card-header">
                                        <? if ($_GET['status'] == "edit") { ?>
                                            <h2 style="color: green" class="card-title">
                                                Edit Teacher
                                            </h2>
                                        <? } else { ?>
                                            <h3 class="card-title">
                                                Add Teacher
                                            </h3>
                                        <? } ?>
                                    </div>
                                    <? if ($_GET['status'] == "edit") {
                                        $query = DB::query("SELECT * FROM staff_members where id=%i", $_GET['id']);
                                        foreach ($query as $staff_details) {
                                        }
                                    }
                                    ?>
                                    <!--begin::Form-->
                                    <form method="post" data-parsley-validate
                                          action="<?php echo $_SERVER['PHP_SELF'] ?>">
                                        <? if ($_GET['status'] == "edit") { ?>
                                            <center>
                                                <a href="manage-teachers"
                                                   class="btn btn-light-primary px-6 font-weight-bold">Add New
                                                    Teacher</a>
                                            </center>
                                        <? } ?>

                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <input required type="text"
                                                       value="<? echo $staff_details["firstName"] ?>" name="firstName"
                                                       class="form-control"
                                                       placeholder="First Name"/>
                                            </div>
                                            <div class="form-group">
                                                <label>Middle Name</label>
                                                <input type="text" name="middleName"
                                                       value="<? echo $staff_details["middleName"] ?>"
                                                       class="form-control"
                                                       placeholder="Middle Name"/>
                                            </div>
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <input required type="text" name="lastName"
                                                       value="<? echo $staff_details["lastName"] ?>"
                                                       class="form-control"
                                                       placeholder="Last Name"/>
                                            </div>
                                            <div class="form-group">
                                                <label>Phone Number</label>
                                                <input required type="text" name="mobile"
                                                       value="<? echo $staff_details["mobile"] ?>" class="form-control"
                                                       placeholder="Phone Number"/>
                                            </div>
                                            <div class="form-group">
                                                <label>Email address</label>
                                                <input required type="email" name="email_address"
                                                       value="<? echo $staff_details["email_address"] ?>"
                                                       class="form-control"
                                                       placeholder="Enter email"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Password</label>
                                                <input type="password" name="password" class="form-control"
                                                       id="exampleInputPassword1" placeholder="Password"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleSelect1"><b>Assign Teacher To Class</b></label>
                                                <div class="checkbox-list">
                                                    <?php
                                                    $query = DB::query("SELECT * FROM class_details  order by class_name ASC");
                                                    if ($query) {
                                                        foreach ($query as $class_details):
                                                            ?>
                                                            <label class="checkbox">
                                                                <input type="checkbox"
                                                                       value="<? echo $class_details["id"] ?>"
                                                                       name="class_id[]"
                                                                    <?
                                                                    $query = DB::query("SELECT * FROM class_assign_teacher where teacher_id=%i", $_GET['id']);
                                                                    foreach ($query as $class_teacher):
                                                                        if ($class_teacher['class_id'] == $class_details['id']) {
                                                                            ?>
                                                                            checked
                                                                            <?
                                                                        }
                                                                    endforeach;
                                                                    ?>/>
                                                                <span></span> <? echo $class_details['class_name'] ?>
                                                            </label>
                                                        <?php endforeach;
                                                    } ?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleSelect1"><b>Assign Teacher To Subject</b></label>
                                                <div class="checkbox-list">
                                                    <?php
                                                    $query = DB::query("SELECT * FROM subject_details  order by subject_name ASC");
                                                    if ($query) {
                                                        foreach ($query as $subject_details):
                                                            ?>
                                                            <label class="checkbox">
                                                                <input type="checkbox"
                                                                       value="<? echo $subject_details["id"] ?>"
                                                                       name="subject_id[]"
                                                                    <?
                                                                    $query = DB::query("SELECT * FROM subject_assign_teacher where teacher_id=%i", $_GET['id']);
                                                                    foreach ($query as $class_teacher):
                                                                        if ($class_teacher['subject_id'] == $subject_details['id']) {
                                                                            ?>
                                                                            checked
                                                                            <?
                                                                        }
                                                                    endforeach;
                                                                    ?>/>
                                                                <span></span> <? echo $subject_details['subject_name'] ?>
                                                            </label>
                                                        <?php endforeach;
                                                    } ?>
                                                </div>
                                            </div>
                                            <div class="form-group mb-1">
                                                <label for="exampleTextarea">Brief Description</label>
                                                <textarea class="form-control" name="description" id="exampleTextarea"
                                                          rows="3"><? echo $staff_details["description"] ?></textarea>
                                            </div>
                                        </div>
                                        <? if ($_GET['status'] == "edit") { ?>
                                            <input name="update" type="hidden" value="1"/>
                                            <input name="update_id" type="hidden" value="<? echo $_GET['id'] ?>"/>
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
                            <div class="col-md-8">

                                <div class="card card-custom">
                                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                                        <div class="card-title">
                                            <h3 class="card-label">View Teacher
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table class="datatable datatable-bordered datatable-head-custom"
                                               id="kt_datatable">
                                            <thead>
                                            <tr>
                                                <th title="Field #2">Teacher Names</th>
                                                <th title="Field #3">Phone Number</th>
                                                <th title="Field #4">Email Address</th>
                                                <th title="Field #8">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?
                                            $query = DB::query("SELECT * FROM staff_members order by firstName ");
                                            foreach ($query
                                                     as $row):
                                                ?>
                                                <tr>
                                                    <td><? echo $row["firstName"] . ' ' . $row["middleName"] . ' ' . $row['lastName'] ?></td>
                                                    <td><? echo $row['mobile'] ?></td>
                                                    <td><? echo $row['email_address'] ?></td>
                                                    <td>
                                                        <a href="manage-teachers?id=<?php echo $row['id'] ?>&status=edit"
                                                           class="btn btn-primary btn-sm"
                                                           style="padding:0px 0px;""><i
                                                                class="icon-pen"></i>Edit</a>

                                                        <a href="#del<?php echo $row['id'] ?>"
                                                           class="btn btn-danger btn-sm"
                                                           style="padding:0px 0px;" data-toggle="modal"><i
                                                                    class="icon-trash"></i>Delete</a></td>
                                                </tr>

                                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog"
                                                     tabindex="-1"
                                                     id="del<?php echo $row['id'] ?>" class="modal fade">
                                                    <div class="modal-dialog " role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h2 id="exampleModalLabel" class="modal-title">ARE YOU
                                                                    SURE YOU
                                                                    WANT TO DELETE</h2>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-hidden="true"
                                                                        aria-label="Close">&times;
                                                                </button>

                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="manage-teachers" method="POST">
                                                                    <input type="hidden"
                                                                           value="<?php echo $row['id'] ?>"
                                                                           name="id">
                                                                    <div class="form-row">
                                                                        <input type="submit" class="btn btn-danger"
                                                                               value="YES"
                                                                               name="del"><br>
                                                                        <button type="button" class="btn btn-secondary"
                                                                                data-dismiss="modal">NO
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
