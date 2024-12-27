<!DOCTYPE html>
<html>

<head>
    <?php
	session_start();
	include("../connect.php");
	include("../config.php");
	date_default_timezone_set("Asia/Colombo");
	?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CLOUD ARM | Invoice..</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="../../../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

    <style>
    @media print {
        h5 {
            line-height: 1.5;
            margin-bottom: 0;
        }

        h4 span {
            float: right;
        }

        h3 {
            line-height: 1.5;
            font-weight: 600;
            text-decoration: underline;
        }

        #btn-box {
            display: none !important;
        }

        a {
            color: #3c8dbc !important;
            text-decoration: underline;
        }

        hr {
            border-color: #000 !important;
            text-decoration: underline;
            margin: 0 !important;
        }

        table thead tr th {
            text-align: center;
        }
    }
    </style>
</head>

<body>
    <?php
	$sec = "1";
	$job_id=$_GET['id'];
	$return =  '../job_view='.base64_encode($job_id);

    
	?>
    <?php if (isset($_GET['print'])) { ?>

    <body onload="window.print()" style=" font-size: 13px;font-family: arial;">
        <?php } else { ?>

        <body style=" font-size: 13px; font-family: arial;margin: 0 10px;overflow-x: hidden;">
            <?php } ?>


            <div class="wrapper">
                <!-- Main content -->
                <section class="invoice">

                    <?php $path="../";
					$result = query("SELECT * FROM info ",$path);
					
					for ($i = 0; $row = $result->fetch(); $i++) {
						$info_name = $row['name'];
						$info_add = $row['address'];
						$info_vat = $row['vat_no'];
						$info_con = $row['phone_no'];
						$info_mail = $row['email'];
					}

                   
                    
                    $action=$_GET['type'];
                    


					?>


                    <div class="row">
                        <!-- accepted payments column -->

                        <div class="col-xs-6">
                            <div class="col-xs-4">
                                <img src="../img/logo/logo.jpg" width="140" alt="Logo" style="margin-bottom: 10px;">
                            </div>
                            <div class="col-xs-8">
                                <h5>
                                    <b><?php echo $info_name; ?></b> <br>

                                    <?php echo $info_add; ?> <br>
                                    <?php echo $info_con; ?> <br>
                                    <a href="#" style="color:blue"><?php echo $info_mail; ?></a>
                                </h5>
                            </div>

                        </div>

                        <div class="col-xs-12">
                            <hr>
                        </div>

                        <div class="col-xs-12">
                            <h3 style="text-align: center;">
                                <?php if ($action == 2) {
									echo "QUTATION";
								} else {
									echo "INVOICE";
									
								} ?>
                            </h3>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-7">
                            <h5>

                                <?php
								$result = $db->prepare("SELECT * FROM job WHERE   id='$job_id'");
								$result->bindParam(':userid', $date);
								$result->execute();
								for ($i = 0; $row = $result->fetch(); $i++) {

									$invoice = $row['invoice_name'];
									$invoice_action = $row['invoice_action'];


								} ?>





                                <?php
								$result = $db->prepare("SELECT * FROM sales WHERE   job_no='$job_id'");
								$result->bindParam(':userid', $date);
								$result->execute();
								for ($i = 0; $row = $result->fetch(); $i++) {
									$id1 = $row['transaction_id']; // Corrected this line

									$cus_name = $row['customer_name'];
                                    $cus_id=$row['customer_id'];
                                    $address=$row['address'];
									$discount=$row['discount'];
                                   
                                    $invo=$row['invoice_number'];
									$date=$row['date'];
								} 
								$phone=select_item('customer','contact','id='.$cus_id,'../');
								?>

                                <b>INVOICE TO:</b> <br>
                                <?php echo $cus_name; ?> <br>
                                <?php echo $address; ?> <br>
                                <?php if($invoice_action != 0) {?>
                                <b>Invoice Name: </b> <?php echo $invoice; ?> <br>
                                <?php } ?>
                                <b>Customer id: </b> <?php echo $cus_id; ?> <br>
                                <b>Job Number: </b> <?php echo $job_id; ?><br>
                                <b>Product List:</b><br>


                            </h5>
                        </div>
                        <!-- /.col -->

                        <div class="col-xs-5 pull-right">
                            <h5 style="float:right">
                                <b>No. #<?php echo $id1; ?></b> <br>

                                <b> Date:</b> <?php echo $date; ?> <br>

                                <br>
                                <small>
                                    Print Date: <?php echo date('Y-m-d'); ?> <br>
                                    Print Time- <?php echo date('H:i:s'); ?>
                                </small>
                            </h5>
                        </div>

                    </div>


                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
									date_default_timezone_set("Asia/Colombo");
									$tot_amount = 0;
									$num = 0;

									$result = $db->prepare("SELECT * FROM sales_list WHERE job_no = :job_no");
									$result->bindParam(':job_no', $job_id);
									$result->execute();

									while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
										$num += 1;
										$price = $row['price'] - ($row['dic'] / $row['qty']);
										$amount = $price * $row['qty'];
										$product_id = $row['product_id'];
										$name = $row['product_id'] == 4 ? $row['about'] : $row['name'];
										$name1 = '';

										try {
											$task_result = $db->prepare("SELECT * FROM sales_list_task WHERE job_no = :job_no AND product_id = :product_id");
											$task_result->bindParam(':job_no', $job_id);
											$task_result->bindParam(':product_id', $product_id);
											$task_result->execute();

											while ($task_row = $task_result->fetch(PDO::FETCH_ASSOC)) {
												$name1 .=  "* " . htmlspecialchars($task_row['name']) . "<br>"; // Gather task names
											}
										} catch (PDOException $e) {
											echo "Error: " . htmlspecialchars($e->getMessage());
										}
										
									?>



								<tr>
    <td><?php echo $num; ?></td>
    <td>
        <?php echo $name; ?>
        <?php if (!empty($name1)) { ?>
        <div style="font-size: 0.85em; color: gray; padding-left: 15px;">
            <?php echo $name1; ?>
        </div>
        <?php } ?>
        <div style="font-size: 0.9em; color: black; padding-top: 5px;">
            Basically provide a thorough and high-quality cleaning for every job
        </div>
    </td>
    <td><?php echo $row['qty']; ?></td>
    <td>Rs.<?php echo number_format($price, 2); ?></td>
    <td>Rs.<?php echo number_format($amount, 2); ?></td>
    <?php $tot_amount += $amount; ?>
</tr>
                                <?php } ?>
                                <tr>
                                    <td colspan="3"></td>
                                    <td>SUB Total: </td>
                                    <th>Rs.<?php echo number_format($tot_amount, 2); ?></th>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td>Discount: </td>
                                    <th>Rs.<?php echo number_format($discount, 2); ?></th>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td>NET Total: </td>
                                    <th>Rs.<?php echo number_format($tot_amount - $discount, 2); ?></th>
                                </tr>
                            </tbody>
                            <tfoot></tfoot>
                        </table>


                        <div class="row">


                            <?php if(!$action==2){$action=1;} ?>
                            <div class="col-xs-4" id="btn-box" style="display: flex;gap: 15px;justify-content: center;">
                                <a href="print?id=<?php echo $job_id.'&type='.$action; ?>&print" class="btn btn-danger">
                                    <i class="fa fa-print"></i> Print</a>
                                <a href="../pdfd/table?id=<?php echo $job_id . '&type=' . $action; ?>&phone=<?php echo $phone ?> "
                                    class="btn btn-success"> <i class="fa fa-whatsapp"></i> Whatsapp To
                                    [<?php echo $phone; ?>]</a>
                                <a href="../job_view?id=<?php echo base64_encode($job_id); ?>" class="btn btn-warning">
                                    <i class="fa fa-home"></i> Home</a>
                            </div>
                        </div>

                    </div>

                    <br><br><br>
                    <div class="row">
                        <div class="col-md-12">Make all Cheques payable to "Advanced Cleaners"
                            FOR ENQUIRIES Negombo -031228645 COLOMBO BRANCH - 112690944 <br>
                            Thank you for your business!
                        </div>
                    </div>

                    <br><br><br>
                    <div class="row">
                        <div class="col-xs-12" style="text-align: center;">
                            This is a system generated document and signature is not required
                        </div>
                    </div>
                </section>
            </div>
            <script>
            async function send() {
                try {
                    // Get the selected product ID from the #mat_id dropdown (uncomment if needed)
                    // let productId = $('#mat_id').val();

                    // Fetch units for selected product
                    const response = await fetch(
                        `../pdf/invoice.php?id=<?php echo $job_id . '&type=' . $action; ?>`, {
                            method: "GET",
                            headers: {
                                "Content-type": "application/json; charset=UTF-8"
                            }
                        });

                    // Parse the response as JSON
                    const json = await response.json();
                    console.log(json);

                    // Redirecting to job view page
                    window.location.href = '../job_view?id=<?php echo base64_encode($job_id); ?>';

                } catch (error) {
                    console.error('Error:', error);
                }
            }
            </script>
        </body>

</html>