<!DOCTYPE html>
<html>
<?php
include("head.php");
include_once("auth.php");

$r = $_SESSION['SESS_LAST_NAME'];
$_SESSION['SESS_FORM'] = 'tools';
$user_level = $_SESSION['USER_LEWAL'];

?>

<body class="hold-transition skin-blue skin-orange sidebar-mini">

    <?php include_once("start_body.php"); 
  ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
            Holiday details
                <small>Preview</small>
            </h1>
        </section>



        <section class="content">
            <div class="box">
            <div class="box-header">
    <div class="row align-items-center mb-3">
        <div class="col-md-6 d-flex align-items-center">
            <h3 class="box-title me-3">Holiday Data</h3>
            <button onclick="click_open('add')" class="btn btn-primary me-2">Add Holiday Dates</button>
        </div>
    </div>
</div>

                <!-- /.box-header -->

                <div class="box-body">


                    <table id="example1" class="table table-bordered table-striped">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Date</th>

                                <th>#</th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php $result = select('holidays','*');
                            for ($i = 0; $row = $result->fetch(); $i++) {
                                $id = $row['id']; ?>
                            <tr>
                                <th><?php echo $row['id']  ?></th>
                                <th><?php echo $row['name']  ?></th>
                                <th><?php echo $row['date']  ?></th>



                                <th>
                                    <?php if ($user_level == 1){ ?>

                                    <a class="btn btn-sm btn-danger"
                                        onclick="confirmDelete(<?php echo $row['id']; ?>)">Delete</a>

                                    <?php } ?>




                        </a>  

                                </th>
                            </tr>

                            <?php } ?>
                        </tbody>
                    </table>


                </div>

            </div>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Add Material Popup -->
    <div class="container-up d-none" id="add_material_popup">
        <div class="row w-70">
            <div class="box box-success popup" style="width: 150%;">
                <div class="box-header with-border">
                    <h3 class="box-title">Add New Holiday</h3>
                    <small onclick="click_close('add')" class="btn btn-sm btn-success pull-right"><i
                            class="fa fa-times"></i></small>
                    <i class="fa fa-times"></i>
                    </small>
                </div>
                <div class="box-body d-block">
                    <form method="POST" action="save/holiday_save.php">
                        <div class="row" style="display: block;">


                            <div class="row" style="margin-bottom: 20px; display: flex; align-items: end;">
                                <div class="col-lg-12">
                                    <label>Date:</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        <input type="date" class="form-control" name="date" value="<?php echo htmlspecialchars($date); ?>">
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Reason</label>
                                    <input type="text" name="name" class="form-control" autocomplete="off">
                                </div>
                            </div>





                            

                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" name="unit" value="1">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                                    <input type="submit" style="margin-top: 23px; width: 100%;" value="Save"
                                        class="btn btn-info btn-sm">
                                </div>
                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="container-up d-none" id="add_cat_popup">
        <div class="row w-70">
            <div class="box box-success popup" style="width: 150%;">
                <div class="box-header with-border">
                    <h3 class="box-title">Add New Tool catogory</h3>
                    <small onclick="click_close('cat')" class="btn btn-sm btn-success pull-right"><i
                            class="fa fa-times"></i></small>
                    <i class="fa fa-times"></i>
                    </small>
                </div>
                <div class="box-body d-block">
                    <form method="POST" action="save/tools_category_save.php">
                        <div class="row" style="display: block;">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" autocomplete="off">
                                </div>
                            </div>









                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                                    <input type="submit" style="margin-top: 23px; width: 100%;" value="Save"
                                        class="btn btn-info btn-sm">
                                </div>
                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>



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
    get_value('product-box', 'product_table.php?str=all')
    </script>

    <script>
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this item?')) {
            // Redirect to a PHP page that handles the deletion
            window.location.href = 'delete/tool_delete.php?id=' + id;
        }
    }
    </script>

    <!-- page script -->
    <script>
    function click_open(type, id = null) {
        // Hide all popups initially
        document.querySelectorAll('.container-up').forEach(function(popup) {
            popup.classList.add('d-none');
        });

        // Open the Add New Material popup
        if (type === 'add') {
            document.getElementById('add_material_popup').classList.remove('d-none');
            document.getElementById('add_material_container').classList.remove('d-none');
        }

        if (type === 'cat') {
            document.getElementById('add_cat_popup').classList.remove('d-none');
            document.getElementById('add_cat_container').classList.remove('d-none');
        }

        // Open the Edit Material popup for the given ID
        if (type === 'edit') {
            document.getElementById('edit_popup_' + id).classList.remove('d-none');
        }
    }

    function click_close(type) {
        // Close the Add Material popup
        if (type === 'add') {
            document.getElementById('add_material_popup').classList.add('d-none');
            document.getElementById('add_material_container').classList.add('d-none');
        }

        if (type === 'cat') {
            document.getElementById('add_cat_popup').classList.add('d-none');
            document.getElementById('add_cat_container').classList.add('d-none');
        }
        // Close the Edit Material popup for the given ID
        else {
            document.getElementById('edit_popup_' + type).classList.add('d-none');
        }
    }



    $(function() {
        $("#example1").DataTable({
            "autoWidth": false
        });
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