<!DOCTYPE html>
<html>
<?php
include("head.php");
include_once("auth.php");
$r = $_SESSION['SESS_LAST_NAME'];
$_SESSION['SESS_DEPARTMENT'] = 'Inventory';

$_SESSION['SESS_FORM'] = 'store_manage.php';
date_default_timezone_set("Asia/Colombo");
?>

<body class="hold-transition skin-blue skin-orange sidebar-mini ">

    <?php include_once("start_body.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Order
                <small>Report</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-sm-6 col-md-4 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon"><i class="fa fa-file-text"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Product Under re order Level</span>
                            <span class="info-box-number">
                                <?php 
                        $totalCount = 0; // Initialize total count for retail jobs

                        $salesResult = select('materials', 'COUNT(id) AS total1', 'available_qty < re_order');
                        if ($salesResult) {
                            $salesRow = $salesResult->fetch();
                            if ($salesRow) {
                                $totalCount += $salesRow['total1']; // Accumulate the count
                            }
                        }
                    
                
                        echo number_format($totalCount); // Display the total corporate jobs with two decimal places
                        ?>
                            </span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 0%"></div>
                            </div>
                            <span class="progress-description"> available</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon"><i class="fa fa-file-text"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Today Removal Item Quantity</span>
                            <span class="info-box-number">
                                <?php 
                $totalCount2 = 0; // Initialize total count for IDs
                $totalQuantity = 0; // Initialize total quantity for items removed

                $currentDate = date('Y-m-d');
                // Modify the query to get both the count of IDs and the sum of quantities
                $salesResult = select('inventory', 'COUNT(id) AS total2, SUM(qty) AS totalQuantity', 'type = "out" AND DATE(date) = "' . $currentDate . '"');
                
                if ($salesResult) {
                    $salesRow = $salesResult->fetch();
                    if ($salesRow) {
                        $totalCount2 = $salesRow['total2']; // Total count of IDs
                        $totalQuantity = $salesRow['totalQuantity']; // Total quantity removed
                    }
                }

                echo number_format($totalCount2); // Display the total ID count with formatting
                ?>
                            </span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 0%"></div>
                            </div>
                            <span class="progress-description">
                                <?php echo "Total Quantity Removed Today: " . number_format($totalQuantity); ?>
                            </span>
                        </div>
                    </div>
                </div>


                <div class="col-sm-6 col-md-4 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon"><i class="fa fa-file-text"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total GRN</span>
                            <span class="info-box-number">
                                <?php 
                              $totalCount2 = 0; // Initialize total count for corporate jobs

                        $salesResult = select('purchases_list', 'SUM(id) AS total2', 'approve = 1 AND type = "GRN"');
                        if ($salesResult) {
                            $salesRow = $salesResult->fetch();
                            if ($salesRow) {
                                $totalCount2 += $salesRow['total2']; // Accumulate the count
                            }
                        }
                    
                
                        echo number_format($totalCount2); // Display the total corporate jobs with two decimal places
                        ?>
                            </span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 0%"></div>
                            </div>
                            <span class="progress-description"> available</span>
                        </div>
                    </div>
                </div>









            </div>


            <!-- All jobs -->

            <?php
      include("connect.php");
      date_default_timezone_set("Asia/Colombo");






      ?>
            <div class="box box-info">

                <div class="box-header with-border">
                    <h3 class="box-title" style="text-transform: capitalize;">Order</h3>
                </div>

                <div class="box-body d-block">
                    <table id="example" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>Invoice</th>
                                <th>Supplier</th>
                                <th>PO</th>
                                <th>status</th>
                                <th>Amount</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
              $a = 0;
              $pay_total = 0;
              $bill_total = 0;
             

                $re = select_query("SELECT * FROM `purchases` WHERE action = '0' AND type = 'Order'");
                for ($i = 0; $r0 = $re->fetch(); $i++) {
                  $bill = $r0['amount'];
                  $bill_total += $bill;
              ?>
                            <tr>
                                <td><?php echo ++$a;  ?></td>
                                <td><?php echo $r0['invoice_no'];  ?></td>
                                <td><?php echo $r0['supplier_name'];  ?></td>
                                <td><?php echo $r0['supplier_invoice'];  ?></td>
                                <td><?php echo $r0['approve'];  ?></td>

                                <td><?php echo $bill; ?></td>
                                <td>
                                    <a href="grn_order_view.php?id=<?php echo $r0['invoice_no']; ?>"
                                        class="btn btn-primary btn-sm">View</a>
                                </td>
                            </tr>
                            <?php }
              ?>

                        </tbody>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <h4 style="margin-bottom: 0;"> Total</h4>
                                </td>
                                <td>
                                    <h4 style="margin-bottom: 0;"><?php echo $bill_total; ?>.00</h4>
                                </td>

                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </section>

    </div>

    <!-- /.content-wrapper -->
    <?php
  include("dounbr.php");
  ?>
    <div class="control-sidebar-bg"></div>
    </div>

    <?php include_once("script.php"); ?>

    <!-- DataTables -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- InputMask -->
    <script src="../../plugins/input-mask/jquery.inputmask.js"></script>
    <script src="../../plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="../../plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <!-- date-range-picker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="../../plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap datepicker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- iCheck 1.0.1 -->
    <script src="../../plugins/iCheck/icheck.min.js"></script>
    <!-- FastClick -->
    <script src="../../plugins/fastclick/fastclick.js"></script>

    <script type="text/javascript">
    $(function() {
        $("#example").DataTable();
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



    <!-- Page script -->
    <script>
    $(function() {
        //Initialize Select2 Elements
        $(".select2").select2();

        //Datemask dd/mm/yyyy
        $("#datemask").inputmask("YYYY/MM/DD", {
            "placeholder": "YYYY/MM/DD"
        });
        //Datemask2 mm/dd/yyyy
        $("#datemask2").inputmask("YYYY/MM/DD", {
            "placeholder": "YYYY/MM/DD"
        });
        //Money Euro
        $("[data-mask]").inputmask();

        //Date range picker
        $('#reservation').daterangepicker();
        //Date range picker with time picker
        //$('#datepicker').datepicker({datepicker: true,  format: 'yyyy/mm/dd '});
        //Date range as a button
        $('#daterange-btn').daterangepicker({
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },
            function(start, end) {
                $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
                    'MMMM D, YYYY'));
            }
        );

        //Date picker
        $('#datepicker').datepicker({
            autoclose: true,
            datepicker: true,
            format: 'yyyy/mm/dd '
        });
        $('#datepicker').datepicker({
            autoclose: true
        });



        $('#datepickerd').datepicker({
            autoclose: true,
            datepicker: true,
            format: 'yyyy/mm/dd '
        });
        $('#datepickerd').datepicker({
            autoclose: true
        });


        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass: 'iradio_minimal-red'
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });


    });
    </script>

</body>

</html>