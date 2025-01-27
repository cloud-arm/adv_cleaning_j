<!DOCTYPE html>
<html>
<?php
include("head.php");
include_once("auth.php");
$r = $_SESSION['SESS_LAST_NAME'];
$_SESSION['SESS_FORM'] = 'shop';
include('connect.php');

$u = $_SESSION['SESS_MEMBER_ID'];
$invo = $_GET['id'];
$new='SELL'.date('YmdHis');
if(!isset($_GET['id'])){
    header('Location:shop.php?id='.$new);
}

// Assuming you already have a PDO connection ($db)
$stmt = $db->prepare("SELECT * FROM shop_sales_list WHERE user_id = :user_id ");
$stmt->execute(['user_id' => $u]);

// Loop through the results
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
 //   $invo = $row['invoice_no'];
    // Do something with $invo if needed
}
?>


<body class="hold-transition skin-blue skin-orange sidebar-mini">

    <?php include_once("start_body.php"); ?>

    <!-- Content Wrapper. Contains page content -->


</section>

    </div>
    <!-- /.content-wrapper -->
    <?php include("dounbr.php"); ?>

    <div class="control-sidebar-bg"></div>
    </div>

    <?php include_once("script.php"); ?>

    <!-- DataTables -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables/dataTables.bootstrap.min.js"></script>
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

function select_pay() {
            var val = $('#method').val();
            if (val == "Bank") {
                $('.slt-bank').css("display", "block");
            } else {
                $('.slt-bank').css("display", "none");
            }

            if (val == "Chq") {
                $('.slt-chq').css("display", "block");
            } else {
                $('.slt-chq').css("display", "none");
            }
        }


    function pro_select() {
        let productId = $('#p_sel').val();

        // Existing AJAX calls for other functionality
        $.ajax({
            type: "GET",
            url: "grn_status.php",
            data: {
                id: productId,
                type: "Order",
                ac: 0
            },
            success: function(res) {
                $("#status").empty();
                $("#status").append(res);
            }
        });

        $.ajax({
            type: "GET",
            url: "grn_status.php",
            data: {
                id: productId,
                type: "Order",
                ac: 1
            },
            success: function(res) {
                $("#sell1").val(parseFloat(res));
            }
        });

        $.ajax({
            type: "GET",
            url: "grn_status.php",
            data: {
                id: productId,
                type: "Order",
                ac: 2
            },
            success: function(res) {
                $("#cost1").val(parseFloat(res));
            }
        });

        // New AJAX call to fetch units for selected product
        $.ajax({
            type: "GET",
            url: "get_units.php",
            data: {
                mat_id: productId
            },
            success: function(response) {
                // Populate the Unit selector with the received options
                $("#unit").empty();
                $("#unit").append(response);
            },
            error: function() {
                alert("Error fetching unit data");
            }
        });
    }


    $(".dll_btn").click(function() {
        var element = $(this);
        var id = element.attr("id");
        var info = 'id=' + id;
        if (confirm("Sure you want to delete this Collection? There is NO undo!")) {

            $.ajax({
                type: "GET",
                url: "grn_list_dll.php",
                data: info,
                success: function() {

                }
            });
            $(this).parents(".record").animate({
                    backgroundColor: "#fbc7c7"
                }, "fast")
                .animate({
                    opacity: "hide"
                }, "slow");
        }
        return false;
    });

    $(function() {
        $(".select2").select2();


    });
    </script>

    <!-- Page script -->
    <script>
    $(function() {
        //Initialize Select2 Elements
        $(".select2").select2();

        //Date range picker
        $('#reservation').daterangepicker();
        //Date range picker with time picker
        //$('#datepicker').datepicker({datepicker: true,  format: 'yyyy/mm/dd '});
        //Date range as a button


        //Date picker
        $('#datepicker1').datepicker({
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


    });
    </script>

</body>

</html>