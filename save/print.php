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
    $job_id = $_GET['id'];
    $return = '../job_view=' . base64_encode($job_id);
    ?>

    <?php if (isset($_GET['print'])) { ?>
    <body onload="window.print()" style="font-size: 14px; font-family: Arial; margin: 20px;">
    <?php } else { ?>
    <body style="font-size: 14px; font-family: Arial; margin: 20px;">
    <?php } ?>


    <?php $path="../";
					$result = query("SELECT * FROM info ",$path);
					
					for ($i = 0; $row = $result->fetch(); $i++) {
						$info_name = $row['name'];
						$info_add = $row['address'];
						$info_vat = $row['vat_no'];
						$info_con = $row['phone_no'];
						$info_mail = $row['email'];
					}

   
								$result = $db->prepare("SELECT * FROM project WHERE   id='$job_id'");
								$result->bindParam(':userid', $date);
								$result->execute();
								for ($i = 0; $row = $result->fetch(); $i++) {
									$id1 = $row['id']; // Corrected this line

									$cus_name = $row['company_name'];
                                    $internal=$row['internal'];
                                    $address=$row['address'];
                                    $cus_id=$row['company_id'];
									$date=$row['date'];
								} 
								$phone=select_item('customer','contact','id='.$cus_id,'../');
								?>

        <div style="max-width: 800px; margin: auto;">
            <!-- Company Header -->
            <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid #000; padding-bottom: 10px;">
                <div>
                    <img src="../img/logo/logo.jpg" alt="Logo" width="120">
                </div>
                <div style="text-align: right;">
                    <h2 style="margin: 0;"><?php echo $info_name; ?></h2>
                    <p style="margin: 5px 0;"><?php echo $info_add; ?></p>
                    <p style="margin: 5px 0;">Phone: <?php echo $info_con; ?></p>
                    <p style="margin: 5px 0;">Email: <a href="#" style="color: blue;"><?php echo $info_mail; ?></a></p>
                </div>
            </div>

            <!-- Title 
            <div style="text-align: center; margin: 20px 0;">
                <h1 style="margin: 0;"><?php echo ($action == 2) ? "QUOTATION" : "INVOICE"; ?></h1>
            </div>

                            -->

            <!-- Customer Information -->
            <div style="margin-bottom: 20px;">
                <h3 style="border-bottom: 1px solid #000; padding-bottom: 5px;">Customer Details</h3>
                <p><strong>Customer Name:</strong> <?php echo $cus_name; ?></p>
                <p><strong>Address:</strong> <?php echo $address; ?></p>
                <p><strong>Phone:</strong> <?php echo $phone; ?></p>
                <p><strong>Job Number:</strong> <?php echo $job_id; ?></p>
                <p><strong>Invoice Number:</strong> <?php echo $id1; ?></p>
                <p><strong>Date:</strong> <?php echo $date; ?></p>
            </div>

            <!-- Product Details -->
            <div>
                <h3 style="border-bottom: 1px solid #000; padding-bottom: 5px;">Extra charges list</h3>
                <?php
                $tot_amount = 0;
                $result = $db->prepare("SELECT * FROM gen_excharge_rec WHERE project_id = :job_no");
                $result->bindParam(':job_no', $job_id);
                $result->execute();
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $price = $row['price'];
                   // $amount = $price * $row['qty'];
                   // $tot_amount += $amount;
                    ?>
                    <div style="margin-bottom: 10px; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                        <p><strong>Extra charge Name:</strong> <?php echo $row['recored']; ?></p>
                        <p><strong>Price:</strong> Rs.<?php echo number_format($price, 2); ?></p>
                    </div>
                <?php } ?>
            </div>


                        <!-- Product Details -->
                        <div>
                <h3 style="border-bottom: 1px solid #000; padding-bottom: 5px;">Shift list</h3>
                <?php
                $tot_amount = 0;
                $result = $db->prepare("SELECT * FROM gen_shift WHERE job_id = :job_no");
                $result->bindParam(':job_no', $job_id);
                $result->execute();
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $working_days = $row['working_days'];
                     $employee_count = $row['employee_count'];
                     $sup_count = $row['sup_count'];
                     $in_time = $row['in_time'];
                     $out_time = $row['out_time'];


                    ?>
                    <div style="margin-bottom: 10px; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                        <p><strong>In time:</strong> <?php echo $row['in_time']; ?></p>
                        <p><strong>Out time:</strong> <?php echo $row['out_time']; ?></p>
                        <p><strong>working days:</strong> <?php echo $row['working_days']; ?></p>
                        <p><strong>supervisor count:</strong> <?php echo $row['sup_count']; ?></p>
                        <p><strong>Employee count:</strong> <?php echo $row['employee_count']; ?></p>


                    </div>
                <?php } ?>
            </div>

                                   <!-- Product Details -->
                                   <div>
                <h3 style="border-bottom: 1px solid #000; padding-bottom: 5px;">Special Note list</h3>
                <?php
                $tot_amount = 0;
                $result = $db->prepare("SELECT * FROM gen_special_note_rec WHERE project_id = :job_no");
                $result->bindParam(':job_no', $job_id);
                $result->execute();
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {



                    ?>
                    <div style="margin-bottom: 10px; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                        <?php echo $row['name']; ?></p>



                    </div>
                <?php } ?>
            </div>




            <!-- Footer -->
            <div style="margin-top: 40px; text-align: center; font-size: 12px;">
                <p>Make all Cheques payable to <strong>"Advanced Cleaners"</strong></p>
                <p>Negombo: 031228645 | Colombo Branch: 112690944</p>
                <p>Thank you for your business!</p>
                <p><small>This is a system-generated document and does not require a signature.</small></p>
            </div>
        </div>
    </body>
</html>


</html>