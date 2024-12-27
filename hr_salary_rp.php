<!DOCTYPE html>
<html>
<?php
include("head.php");
include("connect.php");
?>

<body class="hold-transition skin-blue sidebar-mini">
    <?php
    include_once("auth.php");
    $r = $_SESSION['SESS_LAST_NAME'];

    if ($r == 'Cashier') {

        header("location:./../../../index.php");
    }
    if ($r == 'admin') {

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
                Salary Report
                <small>Preview</small>
            </h1>
        </section>

        <section class="content">
            <div class="box bg-none">
                <div class="box-body">

                    <form action="" method="GET">
                        <div class="row flex-center">
                            <div class="col-lg-1"></div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="form-control select2" name="year" style="width: 100%;" tabindex="1" autofocus>
                                        <option> <?php echo date('Y') - 1 ?> </option>
                                        <option selected> <?php echo date('Y') ?> </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="form-control select2" name="month" style="width: 100%;" tabindex="1" autofocus>
                                        <?php for ($x = 1; $x <= 12; $x++) { ?>
                                            <option> <?php echo sprintf("%02d", $x); ?> </option>
                                        <?php  } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input class="btn btn-info" type="submit" value="Search">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Salary Report</h3>
                </div>

                <a href="hr_salary_rp_print.php?date=<?php echo $_GET['year'] . '-' . $_GET['month']; ?>"><button class="btn btn-info" style="width: 123px; height:35px; margin-top:-8px;margin-left:8px;">
                        <i class="icon icon-search icon-large"></i> print
                    </button></a>
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">

                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Name</th>
                                <th>Day Pay</th>
                                <!-- <th>Day rate</th> -->
                                <th>OT</th>
                                <!-- <th>OT Rate</th> -->
                                <th>Commission</th>
                                <th>Sub Total</th>
                                <th>Advance</th>
                                <th>EPF</th>
                                <th>Deduction</th>
                                <th>Balance</th>
                                <!-- <th>Day</th> -->
                                <!-- <th>OT</th> -->
                            </tr>

                        </thead>

                        <tbody>
                            <?php
                            $date = $_GET['year'] . '-' . $_GET['month'];
                            $tot = 0;
                            $result = $db->prepare("SELECT * FROM hr_payroll WHERE  date='$date'  ");
                            $result->bindParam(':userid', $date);
                            $result->execute();
                            for ($i = 0; $row = $result->fetch(); $i++) {
                                $id = $row['emp_id'];
                            ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td>
                                        <span class="badge bg-aqua">Day: <?php echo number_format($row['day'], 2); ?></span>
                                        <span class="badge bg-olive">Rate: <?php echo number_format($row['day_rate'], 2); ?></span>
                                        <span class="badge bg-orange">Pay: <?php echo number_format($row['day_pay'], 2); ?></span>
                                    </td>
                                    <!-- <td><?php echo number_format($row['day_rate'], 2); ?></td> -->
                                    <td>
                                        <span class="badge bg-blue">OT: <?php echo number_format($row['ot'], 2); ?></span>
                                        <span class="badge bg-green">Rate: <?php echo number_format($row['ot_rate'], 2); ?></span>
                                        <span class="badge bg-yellow">Time: <?php echo number_format($row['ot_time'], 2); ?></span>
                                    </td>
                                    <!-- <td><?php echo number_format($row['ot_rate'], 2); ?></td> -->
                                    <td><?php echo number_format($row['commis'], 2); ?></td>
                                    <td><?php echo number_format($row['day_pay'] + $row['ot'] + $row['commis'], 2); ?></td>
                                    <td><?php echo number_format($row['advance'], 2); ?></td>
                                    <td><?php echo number_format($row['epf'], 2); ?></td>
                                    <td><?php echo number_format($row['advance'] + $row['epf'], 2); ?></td>
                                    <td><?php echo number_format($row['amount'], 2); ?></td>
                                    <!-- <td><?php echo $row['day']; ?></td> -->
                                    <!-- <td><?php echo $row['ot_time']; ?></td> -->
                                <?php
                                if ($row['amount'] > 0) {
                                    $tot += $row['amount'];
                                }
                            } ?>
                                </tr>


                        </tbody>
                        <tfoot>
                            <?php
                            $result = $db->prepare("SELECT sum(day_pay),sum(ot),sum(commis),sum(advance),sum(epf),sum(amount) FROM hr_payroll WHERE  date='$date'  ");
                            $result->bindParam(':userid', $date);
                            $result->execute();
                            for ($i = 0; $row = $result->fetch(); $i++) {
                            ?>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>Rs.<?php echo number_format($row['sum(day_pay)'], 2);  ?></th>
                                    <!-- <th></th> -->
                                    <th>Rs.<?php echo number_format($row['sum(ot)'], 2);  ?></th>
                                    <!-- <th></th> -->
                                    <th>Rs.<?php echo number_format($row['sum(commis)'], 2);  ?></th>
                                    <th>Rs.<?php echo number_format($row['sum(commis)'] + $row['sum(ot)'] + $row['sum(day_pay)'], 2);  ?></th>
                                    <th>Rs.<?php echo number_format($row['sum(advance)'], 2);  ?></th>
                                    <th>Rs.<?php echo number_format($row['sum(epf)'], 2);  ?></th>
                                    <th>Rs.<?php echo number_format($row['sum(advance)'] + $row['sum(epf)'], 2);  ?></th>
                                    <th>Rs.<?php echo $tot ?></th>
                                    <!-- <th></th> -->
                                    <!-- <th></th> -->
                                </tr>
                            <?php } ?>
                        </tfoot>
                    </table>
                </div>

        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-5">

                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Summary</h3>
                        </div>
                        <!-- /.box-header -->
                        <?php
                        $result = $db->prepare("SELECT sum(commis),sum(advance),sum(epf),sum(amount) FROM hr_payroll WHERE  date='$date' ");
                        $result->bindParam(':userid', $date);
                        $result->execute();
                        for ($i = 0; $row = $result->fetch(); $i++) {
                            $com_tot = $row['sum(commis)'];
                            $adv_tot = $row['sum(advance)'];
                            $blc_tot = $row['sum(amount)'];
                            $epf_tot = $row['sum(epf)'];
                        }
                        ?>
                        <div class="box-body">
                            <table class=" table">
                                <tr>
                                    <td>
                                        <h3 style="margin: 0">Total Rs.</h3>
                                    </td>
                                    <td>
                                        <h3 style="margin: 0"><?php echo number_format($tot, 2); ?></h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h4 style="margin: 0;">Commission Rs.</h4>
                                    </td>
                                    <td>
                                        <h4 style="margin: 0"><?php echo number_format($com_tot, 2) ?></h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h4 style="margin: 0">Advance Rs.</h4>
                                    </td>
                                    <td>
                                        <h4 style="margin: 0"><?php echo number_format($adv_tot, 2); ?></h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h4 style="margin: 0">Balance Rs.</h4>
                                    </td>
                                    <td>
                                        <h4 style="margin: 0"><?php echo number_format($blc_tot, 2) ?></h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h4 style="margin: 0">EPF Rs.</h4>
                                    </td>
                                    <td>
                                        <h4 style="margin: 0"><?php echo number_format($epf_tot, 2) ?></h4>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

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
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Dark Theme Btn-->
    <script src="https://dev.colorbiz.org/ashen/cdn/main/dist/js/dark_theme_btn.js"></script>
    <!-- page script -->
    <script>
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


        $('#datepicker').datepicker({
            autoclose: true,
            datepicker: true,
            format: 'yyyy-mm-dd '
        });
        $('#datepicker').datepicker({
            autoclose: true
        });



        $('#datepickerd').datepicker({
            autoclose: true,
            datepicker: true,
            format: 'yyyy-mm-dd '
        });
        $('#datepickerd').datepicker({
            autoclose: true
        });
    </script>
</body>

</html>