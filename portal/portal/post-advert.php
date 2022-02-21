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

if (isset($_POST['update'])) {

    $video = $_FILES['video']['name'];
    $size = $_FILES['video']['size'];
    $type = $_FILES['video']['type'];
    $temp = $_FILES['video']['tmp_name'];
    $loop_ = $_POST['loop_'];
    $autoplay = $_POST['autoplay'];

    $update_id = 1;

    DB::$error_handler = false; // since we're catching errors, don't need error handler DB::$throw_exception_on_error = true;
    DB::$throw_exception_on_error = true;
    // insert data
    try {
        if (!empty($video)) {

            $query = DB::update('advert', array(
                'video' => $video,
                'loop_' => $loop_,
                'autoplay' => $autoplay,
            ), 'id=%i', $update_id);
            move_uploaded_file($_FILES["video"]["tmp_name"], "../uploads/advert/" . $video);
        } else {
            $query = DB::update('advert', array(
                'loop_' => $loop_,
                'autoplay' => $autoplay,
            ), 'id=%i', $update_id);
        }
        if ($query) {
            header("Location: post-advert?message=added");
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
                                                Edit Advert
                                            </h2>
                                        <? } else { ?>
                                            <h3 class="card-title">
                                                Add Advert
                                            </h3>
                                        <? } ?>
                                    </div>
                                    <!--begin::Form-->
                                    <form method="post" enctype="multipart/form-data"
                                          action="<?php echo $_SERVER['PHP_SELF'] ?>">
                                        <? if ($_GET['status'] == "edit") { ?>
                                            <center>
                                                <a href="manage-lessons"
                                                   class="btn btn-light-primary px-6 font-weight-bold">Add New
                                                    Advert</a>
                                            </center>
                                        <? } ?>

                                        <?
                                        $query = DB::query("SELECT * FROM advert where id=1");
                                        foreach ($query as $adv) {
                                        }
                                        ?>

                                        <div class="form-group">
                                            <center>
                                                <label for="exampleSelect1">Upload Advert</label>
                                                <input <? if ($_GET['status'] == "edit") {
                                                } else { ?><? } ?> accept="video/mp4,video/x-m4v,video/*"
                                                                   type="file" id="photo"
                                                                   class="form-control col-md-10"
                                                                   name="video">
                                            </center>
                                        </div>

                                        <? if ($_GET['status'] == "edit") { ?>
                                            <input name="update" type="hidden" value="1"/>
                                        <? } else { ?>
                                            <input name="update" type="hidden" value="1"/>
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
                                            <h3 class="card-label">View Adverts
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="card-body">

                                        <div class="card card-custom gutter-b">
                                            <center>
                                                <div class="card-body d-flex py-10">

                                                    <div class="text-dark-50 font-weight-bold font-size-lg">

                                                        <video id="myVideo" width="600"
                                                               controls
                                                               muted>
                                                            <source src="../uploads/advert/<? echo $adv['video'] ?>"
                                                                    type="video/ogg">
                                                            Your browser does not support HTML video.
                                                        </video>

                                                    </div>

                                                    <!--end::Description-->
                                                </div>
                                            </center>
                                        </div>
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
