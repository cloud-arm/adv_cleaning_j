<!DOCTYPE html>
<html>
<?php
include("head.php");
include_once("auth.php");

$r = $_SESSION['SESS_LAST_NAME'];
$_SESSION['SESS_FORM'] = 'gate_pass';
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
                Gate Pass details
                <small>Preview</small>
            </h1>
        </section>



        <section class="content">
            <div class="box">
                <div class="box-header">
                    <div class="row align-items-center mb-3">
                        <div class="col-md-6 d-flex align-items-center">
                            <h3 class="box-title me-3">Tools Data</h3>
                            <button onclick="click_open('add')" class="btn btn-primary me-2">Add Pass</button>
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
                                <th>User</th>
                                <th>Note</th>

                                <th>Action</th>
                                <th>Date</th>
                                <th>Location</th>
                                <th>Store location</th>

                                <th>#</th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php
                                $result = select('gate_pass', '*');
                                for ($i = 0; $row = $result->fetch(); $i++) {
                                    $id = $row['id'];
                                    $location_id = $row['location_id']; ?>

                            <tr>
                                <th><?php echo $row['id']; ?></th>
                                <th><?php echo $row['name']; ?></th>
                                <th><?php echo $row['user_name']; ?></th>
                                <th><?php echo $row['note']; ?></th>
                                <th><?php echo $row['action']; ?></th>
                                <th><?php echo $row['date']; ?></th>
                                <?php
                                    // Correctly call the select function with location_id
                                    $loc = select_item('stock_location', 'location', "id = $location_id");
                                    ?>

                                <th><?php echo $loc; // Example: display location name ?></th>
                                <th><?php echo $row['stored_location']; ?></th>


                                <th>
                                    <?php   if($row['action']=='out'){?>
                                    <a class="btn btn-sm btn-danger" <button onclick="click_open('cat')"
                                        class="btn btn-primary me-2">Reseved</button>

                                        <?php } ?>


                                </th>
                            </tr>
                            <!-- Edit Popup for each material -->

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
            <div class="box box-success popup" style="width: 50%;">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Geta Pass</h3>
                    <small onclick="click_close('add')" class="btn btn-sm btn-success pull-right"><i
                            class="fa fa-times"></i></small>
                    <i class="fa fa-times"></i>
                    </small>
                </div>
                <div class="box-body d-block">
                    <form method="POST" action="save/gate_pass_save.php">
                        <div class="row" style="display: block;">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Note</label>
                                    <input type="text" name="note" class="form-control" autocomplete="off">
                                </div>
                            </div>


                            <div class="col-md-10">
                                <div class="form-group">
                                    <label>Tool name</label>
                                    <select class="form-control select2" name="tool_name" style="width: 100%;"
                                        autofocus>
                                        <?php
                                        $result = select("tools", "*");
                                        for ($i = 0; $row = $result->fetch(); $i++) {
                                        ?>
                                        <option value="<?php echo $row['id']; ?>"> <?php echo $row['name']; ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-10">
                                <div class="form-group">
                                    <label>Employee</label>
                                    <select class="form-control select2" name="user_name" style="width: 100%;"
                                        autofocus>
                                        <?php
                                        $result = select("user", "*");
                                        for ($i = 0; $row = $result->fetch(); $i++) {
                                        ?>
                                        <option value="<?php echo $row['id']; ?>"> <?php echo $row['name']; ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-10">
                                <div class="form-group">
                                    <label>Location</label>
                                    <select class="form-control select2" name="s_location" style="width: 100%;"
                                        autofocus>
                                        <?php
                                        $result = select("stock_location", "*");
                                        for ($i = 0; $row = $result->fetch(); $i++) {
                                        ?>
                                        <option value="<?php echo $row['id']; ?>"> <?php echo $row['location']; ?>
                                        </option>
                                        <?php } ?>
                                    </select>
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
                    <h3 class="box-title">Reseved location</h3>
                    <small onclick="click_close('cat')" class="btn btn-sm btn-success pull-right"><i
                            class="fa fa-times"></i></small>
                    <i class="fa fa-times"></i>
                    </small>
                </div>
                <div class="box-body d-block">
                    <form method="POST" action="<?php echo 'edit/gate_pass_edit.php?id=' . $id; ?>">
                        <div class="row" style="display: block;">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Location</label>
                                    <select class="form-control select2" name="rese_location" style="width: 100%;"
                                        autofocus>
                                        <?php
                                        $result = select("stock_location", "*");
                                        for ($i = 0; $row = $result->fetch(); $i++) {
                                        ?>
                                        <option value="<?php echo $row['location']; ?>"> <?php echo $row['location']; ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>









                            <div class="col-md-12">
                                <div class="form-group">

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
        if (confirm('Are you Confirm This item is Reseved?')) {
            // Redirect to a PHP page that handles the deletion
            window.location.href = 'edit/gate_pass_edit.php?id=' + id;
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