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

    $topic = $_POST['topic'];
    $subject_id = $_POST['subject_id'];
    $class_id = $_POST['class_id'];
    $term = $_POST['term'];
    $description = $_POST['description'];
    $old_video = $_POST['old_video'];
    $topic_covered = $_POST['topic_covered'];
    $academic_category = $_POST['academic_category'];

    $video = $_FILES['video']['name'];
    $size = $_FILES['video']['size'];
    $type = $_FILES['video']['type'];
    $temp = $_FILES['video']['tmp_name'];

    $home_work = $_FILES['home_work']['name'];
    $home_worksize = $_FILES['home_work']['size'];
    $home_worktype = $_FILES['home_work']['type'];
    $home_worktemp = $_FILES['home_work']['tmp_name'];

    DB::$error_handler = false; // since we're catching errors, don't need error handler DB::$throw_exception_on_error = true;
    DB::$throw_exception_on_error = true;
    // insert data
    try {
        if (!empty($video) || !empty($home_work)) {

            $query = DB::insert('lesson_details', array(
                'topic' => $topic,
                'subject_id' => $subject_id,
                'class_id' => $class_id,
                'term' => $term,
                'description' => $description,
                'video' => $video,
                'academic_category' => $academic_category,
                'home_work' => $home_work,
                'topic_covered' => $topic_covered,
            ));
            move_uploaded_file($_FILES["video"]["tmp_name"], "../uploads/videos/" . $video);
            move_uploaded_file($_FILES["home_work"]["tmp_name"], "../uploads/homework/" . $home_work);
        } else {
            $query = DB::insert('lesson_details', array(
                'topic' => $topic,
                'subject_id' => $subject_id,
                'class_id' => $class_id,
                'academic_category' => $academic_category,
                'term' => $term,
                'description' => $description,
                'topic_covered' => $topic_covered,
            ));
        }
        if ($query) {
            header("Location: manage-lessons?message=added");
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

    $topic = $_POST['topic'];
    $subject_id = $_POST['subject_id'];
    $class_id = $_POST['class_id'];
    $term = $_POST['term'];
    $description = $_POST['description'];
    $old_video = $_POST['old_video'];
    $topic_covered = $_POST['topic_covered'];
    $academic_category = $_POST['academic_category'];

    $video = $_FILES['video']['name'];
    $size = $_FILES['video']['size'];
    $type = $_FILES['video']['type'];
    $temp = $_FILES['video']['tmp_name'];

    $home_work = $_FILES['home_work']['name'];
    $home_worksize = $_FILES['home_work']['size'];
    $home_worktype = $_FILES['home_work']['type'];
    $home_worktemp = $_FILES['home_work']['tmp_name'];
    $update_id = $_POST['update_id'];

    DB::$error_handler = false; // since we're catching errors, don't need error handler DB::$throw_exception_on_error = true;
    DB::$throw_exception_on_error = true;
    // insert data
    try {

        if (!empty($video) && empty($home_work)) {
            $query = DB::update('lesson_details', array(
                'topic' => $topic,
                'subject_id' => $subject_id,
                'class_id' => $class_id,
                'term' => $term,
                'description' => $description,
                'video' => $video,
                'academic_category' => $academic_category,
                'topic_covered' => $topic_covered,
            ), 'id=%i', $update_id);

            move_uploaded_file($_FILES["syllabus"]["tmp_name"], "../uploads/videos/" . $video);
        } elseif (!empty($home_work) && empty($video)) {
            $query = DB::update('lesson_details', array(
                'topic' => $topic,
                'subject_id' => $subject_id,
                'class_id' => $class_id,
                'term' => $term,
                'description' => $description,
                'home_work' => $home_work,
                'academic_category' => $academic_category,
                'topic_covered' => $topic_covered,
            ), 'id=%i', $update_id);

            move_uploaded_file($_FILES["home_work"]["tmp_name"], "../uploads/homework/" . $home_work);
        } elseif (!empty($home_work && !empty($video))) {
            $query = DB::update('lesson_details', array(
                'topic' => $topic,
                'subject_id' => $subject_id,
                'class_id' => $class_id,
                'term' => $term,
                'description' => $description,
                'home_work' => $home_work,
                'video' => $video,
                'academic_category' => $academic_category,
                'topic_covered' => $topic_covered,
            ), 'id=%i', $update_id);

            move_uploaded_file($_FILES["home_work"]["tmp_name"], "../uploads/homework/" . $home_work);
            move_uploaded_file($_FILES["syllabus"]["tmp_name"], "../uploads/videos/" . $video);
        } else {
            $query = DB::update('lesson_details', array(
                'topic' => $topic,
                'subject_id' => $subject_id,
                'class_id' => $class_id,
                'term' => $term,
                'description' => $description,
                'academic_category' => $academic_category,
                'topic_covered' => $topic_covered,
            ), 'id=%i', $update_id);
        }
        if ($query) {
            header("Location: manage-lessons?id=$update_id&status=edit&message=success");
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
    $query = DB::delete('lesson_details', "id=%i", $del);

    if ($query) {
        header('location: manage-lessons?message=deleted');
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
                                    ?>
                                    <div class="card-header">
                                        <? if ($_GET['status'] == "edit") { ?>
                                            <h2 style="color: green" class="card-title">
                                                Edit Lessons
                                            </h2>
                                        <? } else { ?>
                                            <h3 class="card-title">
                                                Add Lessons
                                            </h3>
                                        <? } ?>
                                    </div>
                                    <? if ($_GET['status'] == "edit") {
                                        $query = DB::query("SELECT * FROM lesson_details where id=%i", $_GET['id']);
                                        foreach ($query as $lessons) {
                                        }
                                    }
                                    ?>
                                    <!--begin::Form-->
                                    <form method="post" enctype="multipart/form-data"
                                          action="<?php echo $_SERVER['PHP_SELF'] ?>">
                                        <? if ($_GET['status'] == "edit") { ?>
                                            <center>
                                                <a href="manage-lessons"
                                                   class="btn btn-light-primary px-6 font-weight-bold">Add New
                                                    Lessons</a>
                                            </center>
                                        <? } ?>

                                        <div class="form-group">
                                            <center>
                                                <label>Topic</label>
                                                <input required type="text" name="topic"
                                                       value="<? echo $lessons["topic"] ?>"
                                                       class="form-control col-md-10"
                                                       placeholder="Topic"/>
                                            </center>
                                        </div>
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
                                                                if ($lessons['subject_id'] == $row['id']){
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
                                                <label for="exampleSelect1">Class Name</label>
                                                <select required class="form-control col-md-10" name="class_id"
                                                        id="exampleSelect1">
                                                    <option value="">Select Class</option>
                                                    <? $query = DB::query("SELECT * FROM class_details order by class_name ASC");
                                                    foreach ($query as $row):
                                                        ?>
                                                        <option <?
                                                                if ($lessons['class_id'] == $row['id']){
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
                                                                if ($lessons['academic_category'] == $row['name']){
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
                                                <select required class="form-control col-md-10" name="term"
                                                        id="exampleSelect1">
                                                    <option value="">Select Term
                                                    </option>
                                                    <option <? if ($lessons['term'] == "Term 1"){ ?>selected<? } ?>
                                                            value="Term 1">Term 1
                                                    </option>
                                                    <option <? if ($lessons['term'] == "Term 2"){ ?>selected<? } ?>
                                                            value="Term 2">Term 2
                                                    </option>
                                                    <option <? if ($lessons['term'] == "Term 3  "){ ?>selected<? } ?>
                                                            value="Term 3">Term 3
                                                    </option>

                                                </select>
                                            </center>
                                        </div>

                                        <div class="form-group">
                                            <center>
                                                <label for="exampleTextarea">Brief Description</label>
                                                <textarea class="form-control col-md-10" name="description"
                                                          id="exampleTextarea"
                                                          rows="3"><? echo $lessons["description"] ?></textarea>
                                            </center>
                                        </div>

                                        <div class="form-group">
                                            <center>
                                                <label for="exampleTextarea">Topics to be covered</label>
                                                <textarea class="form-control col-md-10" name="topic_covered"
                                                          id="exampleTextarea"
                                                          rows="3"><? echo $lessons["topic_covered"] ?></textarea>
                                                <span class="form-text text-muted">Separate topics with commas</span>
                                            </center>
                                        </div>
                                        <div class="form-group">
                                            <center>
                                                <label for="exampleSelect1">Upload Video</label>
                                                <input <? if ($_GET['status'] == "edit") {
                                                }else{ ?>required<? } ?> accept="video/mp4,video/x-m4v,video/*"
                                                       type="file" id="photo"
                                                       class="form-control col-md-10"
                                                       name="video">
                                            </center>
                                        </div>
                                        <div class="form-group">
                                            <center>
                                                <label for="exampleSelect1">Upload Home Work</label>
                                                <input <? if ($_GET['status'] == "edit") {
                                                }else{ ?><? } ?> type="file" id="photo" name="foo" accept=
                                                       "application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,
                                                        text/plain, application/pdf, image/*"
                                                       class="form-control col-md-10"
                                                       name="home_work">
                                            </center>
                                        </div>

                                        <? if ($_GET['status'] == "edit") { ?>
                                            <input name="update" type="hidden" value="1"/>
                                            <input name="update_id" type="hidden" value="<? echo $_GET['id'] ?>"/>
                                            <input name="old_video" type="hidden"
                                                   value="<? echo $lessons['video'] ?>"/>
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
                                            <h3 class="card-label">View Lessons
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
                                                <th title="Field #2">Topic</th>
                                                <th title="Field #2">Subject Name</th>
                                                <th title="Field #3">Class Name</th>
                                                <th title="Field #3">File</th>
                                                <th title="Field #8">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?
                                            $query = DB::query("SELECT * FROM lesson_details");
                                            foreach ($query
                                                     as $row):
                                                $query = DB::query("SELECT * FROM subject_details where id=%i", $row['subject_id']);
                                                foreach ($query
                                                         as $subject_details):
                                                    $query = DB::query("SELECT * FROM class_details where id=%i", $row['class_id']);
                                                    foreach ($query
                                                             as $class_details):
                                                        ?>
                                                        <tr>
                                                            <td><? echo $row["topic"] ?></td>
                                                            <td><? echo $subject_details["subject_name"] ?></td>
                                                            <td><? echo $class_details["class_name"] . ' (' . $row["term"] . ')' ?></td>
                                                            <td><? echo $row["video"] ?></td>
                                                            <td>
                                                                <a href="#" data-toggle="modal"
                                                                   data-target="#exampleModalLong"
                                                                   class="btn btn-secondary btn-sm"
                                                                   style="padding:0px 0px;""><i
                                                                        class="icon-pen"></i>View Video</a>
                                                                <a href="manage-lessons?id=<?php echo $row['id'] ?>&status=edit"
                                                                   class="btn btn-primary btn-sm"
                                                                   style="padding:0px 0px;""><i
                                                                        class="icon-pen"></i>Edit</a>

                                                                <a href="#del<?php echo $row['id'] ?>"
                                                                   class="btn btn-danger btn-sm"
                                                                   style="padding:0px 0px;" data-toggle="modal"><i
                                                                            class="icon-trash"></i>Delete</a></td>
                                                        </tr>
                                                        <div class="modal fade" id="exampleModalLong"
                                                             data-backdrop="static" tabindex="-1" role="dialog"
                                                             aria-labelledby="staticBackdrop" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            Modal Title</h5>
                                                                        <button onclick="pauseVid()" type="button"
                                                                                class="close" data-dismiss="modal"
                                                                                aria-label="Close">
                                                                            <i aria-hidden="true"
                                                                               class="ki ki-close"></i>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <video id="myVideo" width="400" controls
                                                                               controlsList='nodownload'>
                                                                            <source src="../uploads/videos/<?
                                                                            echo $row['video'] ?>" type="video/ogg">
                                                                            Your browser does not support HTML video.
                                                                        </video>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button onclick="pauseVid()" type="button"
                                                                                class="btn btn-light-primary font-weight-bold"
                                                                                data-dismiss="modal">Close
                                                                        </button>
                                                                    </div>
                                                                    <script>
                                                                        var vid = document.getElementById("myVideo");

                                                                        function pauseVid() {
                                                                            vid.pause();
                                                                        }
                                                                    </script>
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
                                                                            ARE YOU
                                                                            SURE YOU
                                                                            WANT TO DELETE</h2>
                                                                        <button type="button" class="close"
                                                                                data-dismiss="modal"
                                                                                aria-hidden="true"
                                                                                aria-label="Close">&times;
                                                                        </button>

                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="manage-lessons" method="POST">
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
                                                    <?
                                                    endforeach;
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
