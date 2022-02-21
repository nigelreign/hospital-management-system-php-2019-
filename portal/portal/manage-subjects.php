<?

require_once '../page_includes/connections.php';
$query = DB::query("SELECT * FROM admin_security where id=1");
foreach ($query as $JHJvdW5kcz01M)

    if ($_SESSION['token'] != $JHJvdW5kcz01M['token']) {
        header("Location: ../../signout?message=unauthorized_access");
    }
require_once '../inc/head.php';


    if ($_GET['edit']) {
        $query = DB::query("SELECT * FROM subject_details where id=%i", $_GET['id']);
        if (!$query) {
            header('location: manage-subjects');
        }
    }

if (isset($_POST['update'])) {
    $subject_name = $_POST['subject_name'];
    $update_id = $_POST['update_id'];
    DB::$error_handler = false; // since we're catching errors, don't need error handler DB::$throw_exception_on_error = true;
    DB::$throw_exception_on_error = true;
    // insert data
    try {

        $query = DB::update('subject_details', array(
            'subject_name' => $subject_name,
        ), 'id=%i', $update_id);

        if ($query) {
            header("Location: manage-subjects?id=$update_id&status=edit&message=success");
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
    $query = DB::delete('subject_details', "id=%i", $del);

    if ($query) {
        header('location: manage-subjects?message=deleted');
    }
}

if (isset($_POST['save'])) {

    $subject_name = $_POST['subject_name'];

    DB::$error_handler = false; // since we're catching errors, don't need error handler DB::$throw_exception_on_error = true;
    DB::$throw_exception_on_error = true;
    // insert data
    try {
        $query = DB::insert('subject_details', array(
            'subject_name' => $subject_name,
        ));

        if ($query) {
            header("Location: manage-subjects?message=added");
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
                                                Edit Subject
                                            </h2>
                                        <? } else { ?>
                                            <h3 class="card-title">
                                                Add Subject
                                            </h3>
                                        <? } ?>
                                    </div>
                                    <? if ($_GET['status'] == "edit") {
                                        $query = DB::query("SELECT * FROM subject_details where id=%i", $_GET['id']);
                                        foreach ($query as $subject_) {
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
                                                    Subject</a>
                                            </center>
                                        <? } ?>

                                        <div class="card-body">
                                            <div class="form-group">
                                                <center>
                                                    <label>Subject Name</label>
                                                    <input required type="text"
                                                           value="<? echo $subject_["subject_name"] ?>" name="subject_name"
                                                           class="form-control"
                                                           placeholder="Subject Name"/>
                                                </center>
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
                                            <h3 class="card-label">View Subjects
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table class="datatable datatable-bordered datatable-head-custom"
                                               id="kt_datatable">
                                            <thead>
                                            <tr>
                                                <th title="Field #2">Subject Name</th>
                                                <th title="Field #8">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?
                                            $query = DB::query("SELECT * FROM subject_details order by subject_name");
                                            foreach ($query
                                                     as $row):
                                                ?>
                                                <tr>
                                                    <td><? echo $row["subject_name"] ?></td>
                                                    <td>
                                                        <a href="manage-subjects?id=<?php echo $row['id'] ?>&status=edit"
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
                                                                <form action="manage-subjects" method="POST">
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
