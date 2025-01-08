<!DOCTYPE html>
<html>
<?php
include("head.php");
include_once("auth.php");
$r = $_SESSION['SESS_LAST_NAME'];
$_SESSION['SESS_FORM'] = 'company';
$user_level = $_SESSION['USER_LEWAL'];

?>

<body class="hold-transition skin-blue skin-orange sidebar-mini">
    <?php include_once("start_body.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                COMPANY
                <small>Preview</small>
                <span onclick="click_open(1)" class="btn btn-primary btn-bg mx-2">Add COMPANY</span>
                <div class="pull-right">
        <div class="row">
        <small>
                <form method="get">
                    <div class="col-md-7">
                    <select name="type" id="" class="form-control select2">
            <option value="all">All</option>
            <option value="corporate">Corporate</option>
            <option value="retail">Retail</option>
           </select>
                    </div>
                    <div class="col-md-2">
                        <input type="submit" value="Search" class="btn btn-primary">
                    </div>

                </form></small>
            </div></div>
            </h1>
        </section>

        <!-- Main Content Section -->
        <section class="content">
            <div class="row">
                <?php 
            if ($user_level != 5) {
                // For non-level 5 users, show all jobs or filter by customer type
                if (!isset($_GET['type']) || $_GET['type'] == 'all') {
                    $result = select('gen_company', '*');
                } else {
                    $result = select('gen_company', '*', "type='" . $_GET['type'] . "'");
                }
            } else if ($user_level == 5) {
                // For level 5 users, default to showing retail jobs
                if (!isset($_GET['type']) || $_GET['type'] == 'retail') {
                    // If no type is set or type is 'retail', show retail jobs
                    $result = select('gen_company', '*', "type='retail'");
                } else {
                    // In case someone manually tries to set another type, force retail jobs
                    $result = select('gen_company', '*', "type='retail'");
                }
            }




                for ($i = 0; $row = $result->fetch(); $i++) {
                    $id = $row['id'];
                ?>
                <div class="col-sm-6 col-md-4 col-xs-12">
                    <a href="company_view.php?id=<?php echo $row['id']; ?>">
                        <div class="info-box">
                            <?php if ($row['type'] == 'corporate') { ?>
                                <span class="info-box-icon"><i class="fas fa-building"></i></span>
                            <?php } else { ?>
                                <span class="info-box-icon"><i class="fas fa-shopping-cart"></i></span>
                            <?php } ?>
                            <div class="info-box-content">
                                <span class="info-box-number"><?php echo $row['name']; ?></span>
                                <span class="info-box-text"><?php echo $row['address']; ?></span>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 0%"></div>
                                </div>
                                <span class="progress-description">
                                    <span class="badge">Running: <?php echo select_item('job', 'count(id)', 'company_id=' . $id); ?></span>
                                    <span class="badge">Location: <?php echo select_item('location', 'count(id)', 'company_id=' . $id); ?></span>
                                    <span class="badge">Contact: <?php echo select_item('contact', 'count(id)', 'company_id=' . $id); ?></span>
                                </span>


                            </div> 
                        </div>
                    </a>

                    <!-- Edit Popup -->
                    <div class="container-up d-none" id="edit_popup_<?php echo $row['id']; ?>">
                        <div class="row w-70">
                            <div class="box box-success popup" style="width: 150%;">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Edit details</h3>
                                    <small onclick="edit_close(<?php echo $row['id']; ?>)" class="btn btn-sm btn-success pull-right"><i class="fa fa-times"></i></small>
                                </div>
                                <div class="box-body d-block">
                                    <form method="POST" action="edit_company.php">
                                        <div class="form-group">
                                            <label>Company Name</label>
                                            <input type="text" name="name" class="form-control" value="<?php echo $row['name']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" name="address" class="form-control" value="<?php echo $row['address']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" name="email" class="form-control" value="<?php echo $row['email']; ?>" required>
                                        </div>

                                        
                            <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="hidden" name="unit" value="1">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                                        <input type="submit" style="margin-top: 23px; width: 100%;" value="Save"
                                            class="btn btn-info btn-sm">
                                    </div>
                                </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>

            <!-- Company Save Popup -->
            <div class="container-up d-none" id="container_up">
                <div class="row w-70">
                    <div class="box box-success popup" id="popup_1" style="width: 250%;">
                        <div class="box-header with-border">
                            <h3 class="box-title">COMPANY SAVE</h3>
                            <small onclick="click_close(1)" class="btn btn-sm btn-success pull-right" id="u6"><i class="fa fa-times"></i></small>
                        </div>
                        <div class="box-body d-block">
                            <form method="POST" action="save/company_save.php">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" name="address" class="form-control" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>company Reg No.</label>
                                    <input type="text" name="reg_no" class="form-control" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Type</label>
                                    <select class="form-control select2 hidden-search" name="type" style="width: 100%;">
                                        <option value="retail">Retail</option>
                                        <option value="corporate">Corporate</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>E-mail</label>
                                    <input type="text" name="email" class="form-control" autocomplete="off">
                                </div>
                                <input type="hidden" name="unit" value="1">
                                <input type="submit" class="btn btn-info btn-sm pull-right" style="margin-top: 23px; width: 100%;" value="Save">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

        <!-- /.content -->

    <!-- /.content-wrapper -->
    <?php
    include("dounbr.php");
    ?>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
    </div>
    <!-- ./wrapper -->

    <?php include_once("script.php"); ?>

    <!-- DataTables -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../../plugins/fastclick/fastclick.js"></script>


    <script>
        function click_open(i) {
            $(".popup").addClass("d-none");
            $("#popup_" + i).removeClass("d-none");
            $("#container_up").removeClass("d-none");
        }

     function click_close(i) {
            if (i) {
                $(".popup").addClass("d-none");
                $("#container_up").addClass("d-none");
            } else {
                $(".popup").addClass("d-none");
                $("#popup_1").removeClass("d-none");
            }
        }

        function edit_note(i) {
          //  $(".popup").addClass("d-none");
            $("#edit_popup_" + i).removeClass("d-none");
        }

        function edit_close(i) {
          //  $(".popup").addClass("d-none");
            $("#edit_popup_" + i).addClass("d-none");
        }

        
    $(function() {
        $("#example1").DataTable();
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });
    </script>
</body>

</html>
