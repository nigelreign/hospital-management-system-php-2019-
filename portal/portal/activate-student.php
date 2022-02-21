<?

require_once '../page_includes/connections.php';
$query = DB::query("SELECT * FROM admin_security where id=1");
foreach ($query as $JHJvdW5kcz01M)

    if ($_SESSION['token'] != $JHJvdW5kcz01M['token']) {
        header("Location: ../../signout?message=unauthorized_access");
    }
require_once '../inc/head.php';


if ($_GET['edit']) {
    $query = DB::query("SELECT * FROM students where id=%i", $_GET['id']);
    if (!$query) {
        header('location: activate-student');
    }
}

if (isset($_POST['update'])) {
    $student_id = $_POST['student_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $password = $_POST['password'];
    $class_id = $_POST['class_id'];
    $update_id = $_POST['update_id'];
    $term = $_POST['term'];
    $end_date = $_POST['end_date'];
    $academic_category = $_POST['academic_category'];
    $set_term = 1;
    DB::$error_handler = false; // since we're catching errors, don't need error handler DB::$throw_exception_on_error = true;
    DB::$throw_exception_on_error = true;
    // insert data
    try {
        $query = DB::update('set_term', array(
            'term' => $term,
            'end_date' => $end_date,
        ), 'id=%i', $set_term);

        if (!empty($password)) {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $query = DB::update('students', array(
                'student_id' => $student_id,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'password' => $hashed,
                'class_id' => $class_id,
                'academic_category' => $academic_category,
            ), 'id=%i', $update_id);
        } else {
            $query = DB::update('students', array(
                'student_id' => $student_id,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'class_id' => $class_id,
                'academic_category' => $academic_category,
            ), 'id=%i', $update_id);

        }

        $current_date = date("Y-m-d");
        if ($end_date > $current_date) {
            $query = DB::update('students', array(
                'status' => 0,
            ), 'id=%i', $update_id);
            header("Location: activate-student?id=$update_id&status=edit&message=success");
        }else{
            header("Location: activate-student?id=$update_id&status=edit&message=not_activated");
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
    $query = DB::delete('students', "id=%i", $del);

    if ($query) {
        header('location: activate-student?message=deleted');
    }
}

if (isset($_POST['save'])) {

    $student_id = $_POST['student_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $password = $_POST['password'];
    $class_id = $_POST['class_id'];
    $term = $_POST['term'];
    $end_date = $_POST['end_date'];
    $academic_category = $_POST['academic_category'];
    $update_id = 1;

    $hashed = password_hash($password, PASSWORD_DEFAULT);
    DB::$error_handler = false; // since we're catching errors, don't need error handler DB::$throw_exception_on_error = true;
    DB::$throw_exception_on_error = true;
    // insert data
    try {
        $query = DB::update('set_term', array(
            'term' => $term,
            'end_date' => $end_date,
        ), 'id=%i', $update_id);

        $query = DB::insert('students', array(
            'student_id' => $student_id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'password' => $hashed,
            'user_role' => 2,
            'class_id' => $class_id,
            'academic_category' => $academic_category,
        ));

        if ($query) {
            header("Location: activate-student?message=added");
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
                                        <div class="alert alert-success" role="alert">Updated successfully and student activated</div>
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
                                    if ($_GET["message"] == "not_activated") {
                                        ?>
                                        <div class="alert alert-warning" role="alert">Updated successfully but student not activated</div>
                                        <?
                                    }
                                    ?>
                                    <div class="card-header">
                                        <? if ($_GET['status'] == "edit") { ?>
                                            <h2 style="color: green" class="card-title">
                                                Edit Student
                                            </h2>
                                        <? } else { ?>
                                            <h3 class="card-title">
                                                Add Student
                                            </h3>
                                        <? } ?>
                                    </div>
                                    <? if ($_GET['status'] == "edit") {
                                        $query = DB::query("SELECT * FROM students where id=%i", $_GET['id']);
                                        foreach ($query as $student_) {
                                        }
                                        $query = DB::query("SELECT * FROM set_term where id= 1");
                                        foreach ($query as $term) {
                                        }
                                    }
                                    ?>
                                    <!--begin::Form-->
                                    <form method="post" data-parsley-validate
                                          action="<?php echo $_SERVER['PHP_SELF'] ?>">
                                        <? if ($_GET['status'] == "edit") { ?>
                                            <center>
                                                <a href="manage-subjects"
                                                   class="btn btn-light-primary px-6 font-weight-bold">Add New
                                                    Student</a>
                                            </center>
                                        <? } ?>

                                        <div class="form-group">
                                            <center>
                                                <label>Student ID</label>
                                                <input required type="text"
                                                       value="<? echo $student_["student_id"] ?>" name="student_id"
                                                       class="form-control col-md-10"
                                                       placeholder="Student ID"/>
                                            </center>
                                        </div>

                                        <div class="form-group">
                                            <center>
                                                <label>First Name</label>
                                                <input required type="text"
                                                       value="<? echo $student_["first_name"] ?>" name="first_name"
                                                       class="form-control col-md-10"
                                                       placeholder="First Name"/>
                                            </center>
                                        </div>
                                        <div class="form-group">
                                            <center>
                                                <label>Last Name</label>
                                                <input required type="text"
                                                       value="<? echo $student_["last_name"] ?>" name="last_name"
                                                       class="form-control col-md-10"
                                                       placeholder="Last Name"/>
                                            </center>
                                        </div>
                                        <div class="form-group">
                                            <center>
                                                <label>Password</label>
                                                <input type="password" name="password"
                                                       class="form-control col-md-10"
                                                       placeholder="Password"/>
                                            </center>
                                        </div>

                                        <div class="form-group">
                                            <center>
                                                <label for="exampleSelect1">Class Name</label>
                                                <select class="form-control col-md-10" name="class_id"
                                                        id="exampleSelect1">
                                                    <option value="">Select Class</option>
                                                    <? $query = DB::query("SELECT * FROM class_details order by class_name ASC");
                                                    foreach ($query as $row):
                                                        ?>
                                                        <option <?
                                                                if ($student_['class_id'] == $row['id']){
                                                                ?>selected<?
                                                        } ?>
                                                                value="<?php echo $row['id'] ?>"> <? echo $row['class_name'] ?></option>
                                                    <?
                                                    endforeach; ?>
                                                </select>
                                            </center>
                                        </div>

                                        <div class="form-group">
                                            <center>
                                                <label for="exampleSelect1">Academic Classification</label>
                                                <select class="form-control col-md-10" name="academic_category"
                                                        id="exampleSelect1">
                                                    <option value="None">Select Classification</option>
                                                    <? $query = DB::query("SELECT * FROM academic_category");
                                                    foreach ($query as $row):
                                                        ?>
                                                        <option <?
                                                                if ($student_['academic_category'] == $row['name']){
                                                                ?>selected<?
                                                        } ?>
                                                                value="<?php echo $row['name'] ?>"> <? echo $row['name'] ?></option>
                                                    <?
                                                    endforeach; ?>
                                                </select>
                                            </center>
                                        </div>

                                        <div class="form-group">
                                            <center>
                                                <label for="exampleSelect1">Term</label>
                                                <select class="form-control col-md-10" name="term"
                                                        id="exampleSelect1">
                                                    <option value="">Select Term
                                                    </option>
                                                    <option <? if ($term['term'] == "Term 1"){ ?>selected<? } ?>
                                                            value="Term 1">Term 1
                                                    </option>
                                                    <option <? if ($term['term'] == "Term 2"){ ?>selected<? } ?>
                                                            value="Term 2">Term 2
                                                    </option>
                                                    <option <? if ($term['term'] == "Term 3"){ ?>selected<? } ?>
                                                            value="Term 3">Term 3
                                                    </option>

                                                </select>
                                            </center>
                                        </div>

                                        <div class="form-group">
                                            <center>
                                                <label>Expiring Date</label>
                                                <input type="date" name="end_date"
                                                       class="form-control col-md-10" value="<? echo $term['end_date'] ?>"
                                                       placeholder="Expiring Date"/>
                                            </center>
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
                                            <h3 class="card-label">View Students
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
																	<i class="flaticon2-search-1 text-muted"></i>
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
                                                <th title="Field #2">Student ID</th>
                                                <th title="Field #2">First Name</th>
                                                <th title="Field #2">Last Name</th>
                                                <th title="Field #2">Class Name</th>
                                                <th title="Field #8">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?
                                            $query = DB::query("SELECT * FROM students where user_role !=1 order by first_name");
                                            foreach ($query
                                                     as $row):
                                                $query = DB::query("SELECT * FROM class_details where id=%i", $row['class_id']);
                                                foreach ($query
                                                         as $class):
                                                    ?>
                                                    <tr>
                                                        <td><? echo $row["student_id"] ?></td>
                                                        <td><? echo $row["first_name"] ?></td>
                                                        <td><? echo $row["last_name"] ?></td>
                                                        <td><? echo $class["class_name"] ?>
                                                            <?
                                                            if ($row['status'] == 0) {
                                                                ?>
                                                                <a class="btn btn-primary btn-sm"
                                                                   style="padding:0px 0px;""><i
                                                                        class="icon-pen"></i>Active</a>
                                                                <?
                                                            } else {
                                                                ?>
                                                                <a class="btn btn-primary btn-sm"
                                                                   style="padding:0px 0px;""><i
                                                                        class="icon-pen"></i>Inactive</a>
                                                                <?
                                                            } ?>
                                                        </td>
                                                        <td>


                                                            <a href="activate-student?id=<?php echo $row['id'] ?>&status=edit"
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
                                                                    <h2 id="exampleModalLabel" class="modal-title">ARE
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
                                                                    <form action="activate-student" method="POST">
                                                                        <input type="hidden"
                                                                               value="<?php echo $row['id'] ?>"
                                                                               name="id">
                                                                        <div class="form-row">
                                                                            <input type="submit" class="btn btn-danger"
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
                                                <?
                                                endforeach;
                                            endforeach;
                                            ?>
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
