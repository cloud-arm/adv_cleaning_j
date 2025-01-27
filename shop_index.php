<!DOCTYPE html>

<html>

<?php
include("head.php");
include_once("auth.php");

$r = $_SESSION['SESS_LAST_NAME'];
$_SESSION['SESS_DEPARTMENT'] = 'shop';
$_SESSION['SESS_FORM'] = 'index';
$user_level = $_SESSION['USER_LEWAL'];

?>

<body class="hold-transition skin-yellow skin-orange sidebar-mini">

    <?php include_once("start_body.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">

            <h1>
                Home
                <small>Preview</small>
            </h1>
        </section>
        <!-- Main content -->
        <section class="content">
            <?php

            include('connect.php');
            date_default_timezone_set("Asia/Colombo");
            $cash = $_SESSION['SESS_FIRST_NAME'];
            $date =  date("Y-m-d");
            ?>


            <div class="row">
                <div class="col-sm-6 col-md-4 col-xs-12">

                    <div class="info-box">
                        <span class="info-box-icon"><i class="fa fa-file-text"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Sales COUNT</span>
                            <span class="info-box-number"><?php echo $tot_job=select_item('shop_sales','COUNT(transaction_id)'); ?></span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <span class="progress-description">
                                Total running jobs
                            </span>
                        </div>

                    </div>
                </div>

                <div class="col-sm-6 col-md-4 col-xs-12">

                    <div class="info-box">
                        <span class="info-box-icon"><i class="fa fa-building"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">NEXT</span>
                            <span class="info-box-number"></span>
                            <div class="progress">
                                <div class="progress-bar" style="width: <?php echo ($cop_job/$tot_job)*100 ?>%"></div>
                            </div>
                            
                        </div>

                    </div>
                </div>

                <div class="col-sm-6 col-md-4 col-xs-12">

                    <div class="info-box">
                        <span class="info-box-icon"><i class="fa fa-shopping-cart"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">NEXT</span>
                            <span class="info-box-number"></span>
                            <div class="progress">
                                <div class="progress-bar" style="width: <?php echo ($ret_job/$tot_job)*100 ?>%"></div>
                            </div>
                            
                        </div>

                    </div>
                </div>

                
            </div>

   
  

            <div class="box">
    <div class="box-header">
        <div class="row">
            <div class="col-md-9">
                <h3 class="box-title">Sales LIST</h3>
            </div>
            <div class="col-md-3 text-right">
                <a href="shop.php">
                    <i class="fa fa-plus mr-2"></i> Add New Sale
            </div>
        </div>



        <!-- Search Bar -->
        <?php if($user_level != 5){ ?>
<div class="row mt-2">
    <small>

    </small>
</div>
<?php }?>

    </div>

    <!-- Job List Table -->
    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Customer Name</th>
                    <th>Note</th>
                    <th>Internal company</th>
                </tr>
            </thead>
            <tbody>
            <?php
                    // For level 5 users, default to showing retail jobs
                    if (!isset($_GET['type']) || $_GET['type'] == 'retail') {
                        // If no type is set or type is 'retail', show retail jobs
                        $result = select('shop_sales', '*');
                    } else {
                        // In case someone manually tries to set another type, force retail jobs
                        $result = select('shop_sales', '*');
                    }
                

                for ($i = 0; $row = $result->fetch(); $i++) {
                    $id = $row['transaction_id'];

                    {
                ?>
                <tr>
                    <td><?php echo $row['transaction_id']; ?></td>
  
                    <td><?php echo $row['invoice_number']; ?></td>
                    <td><?php echo $row['date']; ?></td>

                    <td><?php echo $row['amount']; ?></td>


 

  




 
                </tr>

                <!-- Edit Popup for each job -->

                <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>


    </div>


        <!-- Add New Job Popup -->
        <div class="container-up d-none" id="add_job_popup">
            <div class="row w-70">
                <div class="box box-success popup" style="width: 50%;">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add New Job</h3>
                        <small onclick="click_close('add')" class="btn btn-sm btn-success pull-right">
                            <i class="fa fa-times"></i>
                        </small>
                    </div>

                <div class="box-body d-block">
                    <form method="POST" action="save/job/job_save.php">

                        <div class="row" style="display: block;">







                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>company Name</label>
                                    <select class="form-control select2 " id="com_id" name="com_id"
                                            style="width: 100%;" tabindex="1" autocomplete="off">
                                            <?php 
                                                                        $result = select('gen_company', '*');
                                                                        while ($row = $result->fetch()) { 
                                                                        $com_id = $row['id']; 
                                                                    ?>
                                            <option value="<?php echo $row['id']; ?>">
                                                <?php echo $row['name']; ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Internal company Name</label>
                                    <select class="form-control select2 " id="com_id" name="int_name"
                                            style="width: 100%;" tabindex="1" autocomplete="off">
                                            <?php 
                                                                        $result = select('internal_company', '*');
                                                                        while ($row = $result->fetch()) { 
                                                                        $com_id = $row['id']; 
                                                                    ?>
                                            <option value="<?php echo $row['id']; ?>">
                                                <?php echo $row['name']; ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                </div>
                            </div>
                            <div class="col-md-12">

                            <div class="form-group">
                                    <label>Shift Type</label>
                                    <select class="form-control select2 " id="com_id" name="shift_type"
                                            style="width: 100%;" tabindex="1" autocomplete="off">
                                            <?php 
                                                                        $result = select('gen_shift_types', '*');
                                                                        while ($row = $result->fetch()) { 
                                                                        $com_id = $row['id']; 
                                                                    ?>
                                            <option value="<?php echo $row['id']; ?>">
                                                <?php echo $row['name']; ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                </div>
                            </div>

 



                            <div class="col-md-10">
                                <div class="form-group">
                                    <label>Note</label>
                                    <textarea name="note" cols="70" rows="10" class="form-control"></textarea>
                                </div>
                            </div>

                            

                           

                            

                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" name="cus_id" value="0" id="cus_id">

                                    <input type="submit"    style="margin-top: 23px; width: 100%;" id="u1" value="Save"
                                        class="btn btn-info btn-sm pull-right">
                                </div>
                            </div>


                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-wrapper -->

    <?php include("dounbr.php"); ?>

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

    

    <script type="text/javascript">
        $(function() {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": false,
                "autoWidth": false
            });
        });
    </script>

<script> 
function find_cus(){
    var contact = document.getElementById('phone').value;
   
    var data = 'ur';
        fetch("customer_data_get.php?contact=" + contact)
            .then((response) => response.json())
            .then((json) => fill(json));
}

function fill(json) {
        console.log(json);

        if (json.action == "true") {
            console.log("old patient");
            document.getElementById('cus_name').value = json.cus_name;
            document.getElementById('cus_address').value = json.cus_address;
            document.getElementById('phone').value = json.cus_phone_no;
            document.getElementById('cus_id').value = json.cus_id;


            document.getElementById('cus_name').disabled = true;
            document.getElementById('cus_address').disabled = true;
            

            document.getElementById('cus_name').style= 'border: 1px solid #0cc40f';
            document.getElementById('cus_address').style= 'border: 1px solid #0cc40f';
            document.getElementById('phone').style= 'border: 1px solid #0cc40f';


        } else {
            console.log("new patient");
            document.getElementById('cus_name').value = '';
            document.getElementById('cus_address').value = '';
            document.getElementById('cus_id').value = '0';


            document.getElementById('cus_name').disabled = false;
            document.getElementById('cus_address').disabled = false;
            document.getElementById('phone').disabled = false;

            document.getElementById('cus_name').style= 'border: 1px solid ';
            document.getElementById('cus_address').style= 'border: 1px solid ';
            document.getElementById('phone').style= 'border: 1px solid ';

        }
    }

 function confirmDelete(id) {
     if (confirm('Are you sure you want to delete this item?')) {
         // Redirect to a PHP page that handles the deletion
         window.location.href = 'job_dill.php?id=' + id;
     }
 }

        </script>





  
<script>
    function click_open(type, id = null) {
        // Hide all popups initially
        document.querySelectorAll('.container-up').forEach(function(popup) {
            popup.classList.add('d-none');
        });

        // Open the Add New Job popup
        if (type === 'add') {
            document.getElementById('add_job_popup').classList.remove('d-none');
        }
        
        // Open the Edit Job popup for the given ID
        if (type === 'edit') {
            document.getElementById('edit_popup_' + id).classList.remove('d-none');
        }
    }

    function click_close(type) {
        // Close the Add Job popup
        if (type === 'add') {
            document.getElementById('add_job_popup').classList.add('d-none');
        } 
        // Close the Edit Job popup for the given ID
        else {
            document.getElementById('edit_popup_' + type).classList.add('d-none');
        }
    }
</script>






</body>

</html>
