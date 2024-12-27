<!DOCTYPE html>
<html>
<?php 
include("head.php");
include("connect.php");
?>

<body class="hold-transition skin-blue sidebar-mini">
    <?php 
include_once("auth.php");
$r=$_SESSION['SESS_LAST_NAME'];

if($r =='Cashier'){

header("location:./../../../index.php");
}
if($r =='admin'){

include_once("sidebar.php");
}
?>


    <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->


        <section class="content-header">
            <h1>
                New Employee
                <small>Preview</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Forms</a></li>
                <li class="active">Advanced Elements</li>
            </ol>
        </section>
        <section class="content">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Employee Add</h3>

                </div>
                <!-- /.box-header -->

                <div class="box-body">
                    <form method="post" action="hr_employee_save.php">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input class="form-control" type="text" name="name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone No</label>
                                        <input class="form-control" type="text" name="phone_no">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>NIC</label>
                                        <input class="form-control" type="text" name="nic">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input class="form-control" type="text" name="address">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Hour Rate</label>
                                        <input class="form-control" type="text" name="rate">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Designation</label>
                                        <select class="form-control" name="type" >
                                            <?php 
                                            $result = $db->prepare("SELECT * FROM Employees_des ");
                                            $result->bindParam(':userid', $res);
                                            $result->execute();
                                            for($i=0; $row = $result->fetch(); $i++){
                                            ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>EPF NO <span id="epf_err" style="color: #ff0000;display: none">* This number is duplicate !!</span></label>
                                        <input class="form-control" onkeyup="epf_get()" id="epf_txt" type="text" name="etf_no">
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>EPF Amount</label>
                                        <input class="form-control" type="text" name="etf_amount">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>OT</label>
                                        
                                        <select class="form-control" name="ot" id="">
                                            <option value="1">Eligible</option>
                                            <option value="2">Not Eligible</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Welfare Amount</label>
                                        <input class="form-control" type="text" name="well_amount">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box -->
                        <input id="emp_save" class="btn btn-info" type="submit" value="Save">
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </section>
    <!-- /.content -->
    </div>
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

    <!-- jQuery 2.2.3 -->
    <script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../../plugins/fastclick/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
    <!-- Dark Theme Btn-->
    <script src="https://dev.colorbiz.org/ashen/cdn/main/dist/js/dark_theme_btn.js"></script>
    <!-- page script -->
    <script>




function epf_get(){

var val = document.getElementById('epf_txt').value;


fetch("hr_epf_get.php?id="+val)
  .then((response) => response.json())
  .then((json) => console.log(json));

var info = 'id=' + val;
$.ajax({
    type: "GET",
    url: "hr_epf_get.php",
    data: info,
    success: function(resp) {
        console.log(resp);
        if(resp=='1'){
            document.getElementById("epf_err").style.display = "inline";
            document.getElementById("emp_save").setAttribute("disabled", "");
        }
        if(!resp){
            document.getElementById("epf_err").style.display = "none";
            document.getElementById("emp_save").removeAttribute("disabled");
        }
    }
});


}

    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal 
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
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