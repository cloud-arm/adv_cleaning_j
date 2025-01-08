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

<body style="font-size: 14px; font-family: Arial; margin: 0; padding: 20px; background-color: #f4f4f4;">
    <?php
    $sec = "1";
    $job_id = $_GET['id'];
    $type = $_GET['type'];
    $return = '../job_view=' . base64_encode($job_id);
    ?>

    <?php if (isset($_GET['print'])) { ?>
        <body onload="window.print()" style="font-size: 14px; font-family: Arial;">
    <?php } else { ?>
        <body style="font-size: 14px; font-family: Arial;">
    <?php } ?>

    <?php 
    $path = "../";
    $result = query("SELECT * FROM info", $path);
    while ($row = $result->fetch()) {
        $info_name = $row['name'];
        $info_add = $row['address'];
        $info_vat = $row['vat_no'];
        $info_con = $row['phone_no'];
        $info_mail = $row['email'];
        $owner = $row['owner'];
        $nic = $row['nic_no']; 
    }

    $action=$_GET['type'];


    $result = $db->prepare("SELECT * FROM project WHERE id = :job_id");
    $result->bindParam(':job_id', $job_id);
    $result->execute();
    while ($row = $result->fetch()) {
        $cus_name = $row['company_name'];
        $internal = $row['internal'];
        $address = $row['address'];
        $cus_id = $row['company_id'];
        $date = $row['date'];
    }
    $phone = select_item('gen_company', 'contact', 'id=' . $cus_id, '../');
    $reg_no = select_item('gen_company', 'reg_no', 'id=' . $cus_id, '../');
    $name2 = select_item('gen_company', 'name', 'id=' . $cus_id, '../');



    ?>

    <div style="max-width: 900px; margin: auto; background-color: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 20px;">
        <!-- Company Header -->
        <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid #000; padding-bottom: 15px;">
            <div>
                <img src="../img/logo/logo.jpg" alt="Logo" width="100" style="border-radius: 5px;">
            </div>
            <div style="text-align: right;">
                <h2 style="margin: 0; color: #333;"> <?php echo $info_name; ?></h2>
                <p style="margin: 5px 0; color: #666;"> <?php echo $info_add; ?></p>
                <p style="margin: 5px 0; color: #666;"> Phone: <?php echo $info_con; ?></p>
                <p style="margin: 5px 0; color: #666;">Email: <a href="#" style="color: blue;"><?php echo $info_mail; ?></a></p>
            </div>
        </div>

        <!-- Customer Details -->
        <div style="margin: 20px 0;">
            <h3 style="border-bottom: 1px solid #000; padding-bottom: 5px; color: #333;">Customer Details</h3>
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
    <div>
        <p><strong>Name:</strong> <?php echo $cus_name; ?></p>
        <p><strong>Address:</strong> <?php echo $address; ?></p>
        <p><strong>Phone:</strong> <?php echo $phone; ?></p>
    </div>
    <div style="text-align: right;">
        <p><strong>Project ID:</strong> <?php echo $job_id; ?></p>
        <p><strong>Date:</strong> <?php echo $date; ?></p>
    </div>
</div>
        </div>

        <?php 
        if($type ==1){ ?>
            <div style="margin-bottom: 20px;">
            <h3 style="border-bottom: 1px solid #000; padding-bottom: 5px; color: #333;">Agreement details</h3>
            <div style="margin-bottom: 10px; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background-color: #f9f9f9;">
            <p>
                <strong><?php echo $name2; ?></strong>, registered under Company No. <strong><?php echo $reg_no; ?></strong> 
                (hereinafter referred to as the <strong>"First Party"</strong>), 
                and <strong><?php echo $owner; ?></strong>, ID No. <strong><?php echo $nic; ?></strong>, 
                of <strong>Advanced Cleaning Services (PVT) Ltd., Negombo</strong> 
                (hereinafter referred to as the <strong>"Second Party"</strong>).
            </p>
            <p>
                The purpose of this Agreement is to define the terms and conditions for the provision of cleaning services 
                as agreed by both parties.
            </p>
            <p>
                Both parties agree to be legally bound by the following terms:
            </p>
            <ul style="margin-left: 20px;">
                <li>The First Party agrees to provide the required services as outlined in this Agreement.</li>
                <li>The Second Party will ensure timely payment for the services rendered.</li>
                <li>Any modifications to this Agreement must be agreed upon by both parties in writing.</li>
            </ul>
            <p>
                This Agreement shall remain valid for a period of 45 days from the date of signing unless terminated earlier by mutual consent.
            </p>

            </div>



            <?php
            $result = $db->prepare("SELECT * FROM gen_special_note_rec WHERE project_id = :job_no");
            $result->bindParam(':job_no', $job_id);
            $result->execute();
            
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            ?>

            <?php } ?>
        </div>
      <?php  } ?>


<!-- Shift Details -->
<div style="margin-bottom: 20px;">
    <h3 style="border-bottom: 1px solid #000; padding-bottom: 5px; color: #333;"> Shift List</h3>
    <?php
    $result = $db->prepare("SELECT * FROM gen_shift WHERE job_id = :job_no");
    $result->bindParam(':job_no', $job_id);
    $result->execute();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $jenitors = $row['employee_count'];
        $supervisors = $row['sup_count'];
    ?>
<div style="margin-bottom: 10px; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background-color: #f9f9f9; display: flex; flex-direction: column; justify-content: space-between;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
        <p><strong> Janitors:</strong> <?php echo($row['employee_count']); ?></p>
        <p><strong> Supervisors:</strong> <?php echo($row['sup_count']); ?></p>
        <p><strong>In Time:</strong> <?php echo($row['in_time']); ?></p>
        <p><strong> Out Time:</strong> <?php echo($row['out_time']); ?></p>
    </div>
    <div style="text-align: lrft;">
        <p><strong> Working Days:</strong> <?php echo($row['working_days']); ?></p>
    </div>
</div>

    <?php } ?>
</div>


        <!-- Special Notes -->
        <div style="margin-bottom: 20px;">
            <h3 style="border-bottom: 1px solid #000; padding-bottom: 5px; color: #333;">Special Notes</h3>
            <div style="margin-bottom: 10px; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background-color: #f9f9f9;">
            <p>Prior to the agreement the sites cleaning requirement to be conveyed to Advanced cleaning and minimum required carder to provide a smooth operation is <?php echo $jenitors; ?> janitors and <?php echo $supervisors; ?>  supervisor.</p>

            </div>

            <div style="margin-bottom: 10px; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background-color: #f9f9f9;">
            <p>Please note quotation 
            validity period is 45 days from its issuing date</p>
            </div>

            <?php
            $result = $db->prepare("SELECT * FROM gen_special_note_rec WHERE project_id = :job_no");
            $result->bindParam(':job_no', $job_id);
            $result->execute();
            
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div style="margin-bottom: 10px; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background-color: #f9f9f9;">
                <p><?php echo $row['name']; ?></p>
            </div>
            <?php } ?>
        </div>



        <!-- Charges Details -->
        <div>
            <h3 style="border-bottom: 1px solid #000; padding-bottom: 5px; color: #333;">Charges List</h3>
            <?php
            $result = $db->prepare("SELECT * FROM gen_excharge_rec WHERE project_id = :job_no");
            $result->bindParam(':job_no', $job_id);
            $result->execute();
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div style="margin-bottom: 10px; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background-color: #f9f9f9;">
                <p><?php echo $row['recored']; ?></p>
                <p><strong> Price:</strong> Rs. <?php echo number_format($row['price'], 2); ?></p>
            </div>
            <?php } ?>
        </div>

        <div style="margin-bottom: 20px;">
            <h3 style="border-bottom: 1px solid #000; padding-bottom: 5px; color: #333;">Confidentiality </h3>
            <div style="margin-bottom: 10px; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background-color: #f9f9f9;">
            <p> a. Confidential information refers to any data or information relating 
to the business of the Client which would reasonably be considered 
to be proprietary to the client including. But not limited to, accounting 
records, business processes, and Client records and that is not 
generally known in the industry of the Client and where the release 
of that confidential information could reasonably be expected harm 
to the Client. 
<br> <br>

b. The Service Provider agrees that they will not disclose, divulge, 
reveal, report or use, for any purpose, any confidential information 
which the Cleaning service has obtained, except as authorized by the 
Client. The obligation will end on the termination of this Agreement. </p>

            </div>




        </div>


        <div>
            <h3 style="border-bottom: 1px solid #000; padding-bottom: 5px; color: #333;">Agreement is validation</h3>
            <?php
            $result = $db->prepare("SELECT * FROM gen_agreement WHERE job_id = :job_no");
            $result->bindParam(':job_no', $job_id);
            $result->execute();
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $close_date = $row['close_date'];
                $open_date = $row['open_date'];
            }
            ?>
            <div style="margin-bottom: 10px; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background-color: #f9f9f9;">
                <p>This Agreement is valid for a period</p>
                <p><strong> Start date:</strong>  <?php echo $open_date ?></p>
                <p><strong> Close date:</strong>  <?php echo $close_date ?></p>
                <p>The PARTY Of the FIRST PART may terminate the services of the PARTY of the 
SECOND PART by giving ONE MONTH’s notice in writing to the PARTY of the . SECOND PART, on grounds of breach of any of the above conditions or 
general misconduct of the PARTY of the SECOND PART. 
</p> <br>
<p>The PARTY of the SECOND PART may terminate this agreement for their good 
reasons by giving ONE MONTH’S notice in writing to PRTY of the FIRST PART. 
</p> 

            </div>
        </div>

        <div style="font-family: Arial, sans-serif; color: #333;">
    <h3 style="border-bottom: 2px solid #007BFF; padding-bottom: 5px; color: #007BFF;">Payment Details</h3>

    <div style="margin-bottom: 15px; padding: 15px; border: 1px solid #ccc; border-radius: 8px; background-color: #f9f9f9; line-height: 1.6;">
        <p>Payments should be made via cheques payable to <strong>ADVANCED CLEANING SERVICES (PRIVATE) LIMITED</strong> 
        or through online transfers to the bank account provided below. Payments must be completed within 
        <strong>14 days</strong> of receiving an invoice for the preceding month as the monthly charge for cleaning services.</p>
        
        <p><strong>Bank Details:</strong></p>
        <ul style="list-style: none; padding: 0; margin: 0;">
            <li><strong>Account Name:</strong> ADVANCED CLEANING SERVICES (PRIVATE) LIMITED</li>
            <li><strong>Bank Name:</strong> Hatton National Bank</li>
            <li><strong>Bank Branch:</strong> Negombo</li>
            <li><strong>Account Number:</strong> 024010046629</li>
        </ul>
    </div>
</div>




        <!-- Signature Section -->
        <div style="margin-top: 20px;">
            <h4 style="border-bottom: 1px solid #000; padding-bottom: 5px; color: #333;">Signatures</h4>
            <div style="display: flex; justify-content: space-between; margin-top: 30px;">
                <div style="text-align: center; width: 45%;">
                    <p>__________________________</p>
                    <p><strong>First Party</strong></p>
                    <p><?php echo $name2; ?></p>
                </div>
                <div style="text-align: center; width: 45%;">
                    <p>__________________________</p>
                    <p><strong>Second Party</strong></p>
                    <p><?php echo $owner; ?></p>
                </div>
            </div>
        </div>







        </div>

        

        <a href="print_agreement1?id=<?php echo $job_id.'&type='.$action; ?>&print" class="btn btn-danger">
        <i class="fa fa-print"></i> Print</a>

        <!-- Footer -->
        <div style="margin-top: 20px; text-align: center; font-size: 12px; color: #666;">
            <p> Negombo: 031228645 | Colombo Branch: 112690944</p>
            <p><small>This is a system-generated document and does not require a signature.</small></p>
        </div>
    </div>

   

        

 
    </div>
</body>


</html>


</html>