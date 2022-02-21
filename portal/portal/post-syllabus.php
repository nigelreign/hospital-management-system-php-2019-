<?

require_once '../page_includes/connections.php';
$query = DB::query("SELECT * FROM admin_security where id=1");
foreach ($query as $JHJvdW5kcz01M)

    if ($_SESSION['token'] != $JHJvdW5kcz01M['token']) {
        header("Location: ../../signout?message=unauthorized_access");
    }
require_once '../inc/head.php';

    if ($_GET['edit']) {
        $query = DB::query("SELECT * FROM syllabus_details where id=%i", $_GET['id']);
        if (!$query) {
            header('location: post-syllabus');
        }
    }

if (isset($_POST['save'])) {

    $subject_id = $_POST['subject_id'];
    $class_level = $_POST['class_level'];
    $academic_category = $_POST['academic_category'];
    $old_syllabus = $_POST['old_syllabus'];

    $syllabus=$_FILES['syllabus']['name'];
    $size=$_FILES['syllabus']['size'];
    $type=$_FILES['syllabus']['type'];
    $temp=$_FILES['syllabus']['tmp_name'];

    DB::$error_handler = false; // since we're catching errors, don't need error handler DB::$throw_exception_on_error = true;
    DB::$throw_exception_on_error = true;
    // insert data
    try {
        $query = DB::query("SELECT * FROM syllabus_details where subject_id=%i and class_level=%i and academic_category=%i", $subject_id, $class_level, $academic_category );
        if ($query) {
            header("Location: post-syllabus?message=duplicate");
            }else{
            if (!empty($syllabus)) {

                $query = DB::insert('syllabus_details', array(
                    'subject_id' => $subject_id,
                    'class_level' => $class_level,
                    'academic_category' => $academic_category,
                    'syllabus' => $syllabus,
                ));
                move_uploaded_file($_FILES["syllabus"]["tmp_name"], "../uploads/syllabus/" . $syllabus);
            } else {
                $query = DB::insert('syllabus_details', array(
                    'subject_id' => $subject_id,
                    'class_level' => $class_level,
                    'academic_category' => $academic_category,
                ));
            }
            if ($query) {
                header("Location: post-syllabus?message=added");
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

if (isset($_POST['update'])) {

    $subject_id = $_POST['subject_id'];
    $class_level = $_POST['class_level'];
    $academic_category = $_POST['academic_category'];

    $syllabus=$_FILES['syllabus']['name'];
    $size=$_FILES['syllabus']['size'];
    $type=$_FILES['syllabus']['type'];
    $temp=$_FILES['syllabus']['tmp_name'];
    $update_id = $_POST['update_id'];

    DB::$error_handler = false; // since we're catching errors, don't need error handler DB::$throw_exception_on_error = true;
    DB::$throw_exception_on_error = true;
    // insert data
    try {

        if(!empty($syllabus)) {
            $query = DB::update('syllabus_details', array(
                'subject_id' => $subject_id,
                'class_level' => $class_level,
                'academic_category' => $academic_category,
                'syllabus' => $syllabus,
            ), 'id=%i', $update_id);
        }else{
            $query = DB::update('syllabus_details', array(
                'subject_id' => $subject_id,
                'class_level' => $class_level,
                'academic_category' => $academic_category,
            ), 'id=%i', $update_id);
        }

        move_uploaded_file($_FILES["syllabus"]["tmp_name"], "../uploads/syllabus/" . $syllabus);
        if ($query) {
            header("Location: post-syllabus?id=$update_id&status=edit&message=success");
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
    $query = DB::delete('syllabus_details', "id=%i", $del);

    if ($query) {
        header('location: post-syllabus?message=deleted');
    }
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
                                    if ($_GET["message"] == "duplicate") {
                                        ?>
                                        <div class="alert alert-danger" role="alert">Syllabus already exists</div>
                                        <?
                                    }
                                    ?>
                                    <div class="card-header">
                                        <? if ($_GET['status'] == "edit") { ?>
                                            <h2 style="color: green" class="card-title">
                                                Edit Syllabus
                                            </h2>
                                        <? } else { ?>
                                            <h3 class="card-title">
                                                Add Syllabus
                                            </h3>
                                        <? } ?>
                                    </div>
                                    <? if ($_GET['status'] == "edit") {
                                        $query = DB::query("SELECT * FROM syllabus_details where id=%i", $_GET['id']);
                                        foreach ($query as $syllabus_) {
                                        }
                                    }
                                    ?>
                                    <!--begin::Form-->
                                    <form method="post" enctype="multipart/form-data"
                                          action="<?php echo $_SERVER['PHP_SELF'] ?>">
                                        <? if ($_GET['status'] == "edit") { ?>
                                            <center>
                                                <a href="post-syllabus"
                                                   class="btn btn-light-primary px-6 font-weight-bold">Add New
                                                    Syllabus</a>
                                            </center>
                                        <? } ?>

                                        <div class="form-group">
                                            <center>
                                                <label for="exampleSelect1">Subject Name</label>
                                                <select required class="form-control col-md-10" name="subject_id"
                                                        id="exampleSelect1">
                                                    <option value="">Select Subject</option>
                                                    <? $query = DB::query("SELECT * FROM subject_details order by subject_name ASC");
                                                    foreach ($query as $row):
                                                        ?>
                                                        <option <?
                                                                if ($syllabus_['subject_id'] == $row['id']){
                                                                ?>selected<?
                                                        } ?>
                                                                value="<?php echo $row['id'] ?>"> <? echo $row['subject_name'] ?></option>
                                                    <?
                                                    endforeach; ?>
                                                </select>
                                            </center>
                                        </div>

                                        <div class="form-group">
                                            <center>
                                                <label for="exampleSelect1">Class Level</label>
                                                <select required class="form-control col-md-10" name="class_level"
                                                        id="exampleSelect1">
                                                    <option value="">Select Class Level</option>
                                                    <? $query = DB::query("SELECT * FROM class_level");
                                                    foreach ($query as $row):
                                                        ?>
                                                        <option <?
                                                                if ($syllabus_['class_level'] == $row['level']){
                                                                ?>selected<?
                                                        } ?>
                                                                value="<?php echo $row['level'] ?>"> <? echo $row['level'] ?></option>
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
                                                                if ($syllabus_['academic_category'] == $row['name']){
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
                                                <label for="exampleSelect1">Upload Syllabus</label>
                                                <input type="file" id="photo"
                                                       class="form-control col-md-10"
                                                       name="syllabus">
                                            </center>
                                        </div>

                                        <? if ($_GET['status'] == "edit") { ?>
                                            <input name="update" type="hidden" value="1"/>
                                            <input name="update_id" type="hidden" value="<? echo $_GET['id'] ?>"/>
                                            <input name="old_syllabus" type="hidden" value="<? echo $syllabus_['syllabus'] ?>"/>
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
                                            <h3 class="card-label">View Syllabus
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table class="datatable datatable-bordered datatable-head-custom"
                                               id="kt_datatable">
                                            <thead>
                                            <tr>
                                                <th title="Field #2">Subject Name</th>
                                                <th title="Field #3">Class Name</th>
                                                <th title="Field #3">Academic</th>
                                                <th title="Field #3">File</th>
                                                <th title="Field #8">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?
                                            $query = DB::query("SELECT * FROM syllabus_details");
                                            foreach ($query
                                                     as $row):
                                            $query = DB::query("SELECT * FROM subject_details where id=%i",$row['subject_id']);
                                            foreach ($query
                                                     as $subject_details):
                                                ?>
                                                <tr>
                                                    <td><? echo $subject_details["subject_name"] ?></td>
                                                    <td><? echo $row["class_level"] ?></td>
                                                    <td><? echo $row["academic_category"] ?></td>
                                                    <td><? echo $row["syllabus"] ?></td>
                                                    <td>
                                                        <a href="post-syllabus?id=<?php echo $row['id'] ?>&status=edit"
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
                                                                <form action="post-syllabus" method="POST">
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
