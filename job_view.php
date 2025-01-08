<!DOCTYPE html>
<html>
<?php
include("head.php");
include_once("auth.php");
$r = $_SESSION['SESS_LAST_NAME'];
$_SESSION['SESS_FORM'] = 'index';
$_SESSION['SESS_BACK']='job_view';
?>
<style>
.floating-element {
    transition: transform 0.2s ease;
    /* Smooth transition */
}
</style>

<style>
.form-check {
    margin-right: 10px;
}
</style>

<body class="hold-transition skin-blue  sidebar-mini">
    <?php include_once("start_body.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                JOB
                <small>Details</small>
            </h1>
            <?php $id=base64_decode($_GET['id']);
            $result=select('project','*','id='.$id); 
            for ($i = 0; $row = $result->fetch(); $i++) { 
                $company=$row['company_name'];
                $company_id=$row['company_id'];
                $note=$row['note'];
                $action=$row['action'];
                $shift_type_id=$row['shift_type_id'];
            }?>

<?php 
            $result=select('gen_company','*','id='.$company_id); 
            for ($i = 0; $row = $result->fetch(); $i++) { 
                $reg_no=$row['reg_no'];

            }?>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-2">
                    <div id="element1">
                        <div class="box box-info">
                            <div class="box-body">

                                <div style=" margin: 20px;">
                                    <div class="row <?php if($action==1){echo "text-selecter";} ?>">
                                        <div class="col-md-1"><label
                                                class="<?php if($action > 1){echo "text-green";} ?>"><i
                                                    class="fa fa-circle-o"></i></label></div>
                                        <div class="col-md-9 "><label>QUOTATION</label></div>
                                    </div><br>
                                    <div class="row <?php if($action==2){echo "text-selecter";} ?>">
                                        <div class="col-md-1"><label
                                                class="<?php if($action > 2){echo "text-green";} ?>"><i
                                                    class="fa fa-circle-o"></i></label></div>
                                        <div class="col-md-9 "><label>TEAM</label></div>
                                    </div><br>
                                    <div class="row <?php if($action==3){echo "text-selecter";} ?>">
                                        <div class="col-md-1"><label
                                                class="<?php if($action > 3){echo "text-green";} ?>"><i
                                                    class="fa fa-circle-o"></i></label></div>
                                        <div class="col-md-9 "><label>Tools</label></div>
                                    </div><br>
                                    <div class="row <?php if($action==4){echo "text-selecter";} ?>">
                                        <div class="col-md-1"><label
                                                class="<?php if($action > 4){echo "text-green";} ?>"><i
                                                    class="fa fa-circle-o"></i></label></div>
                                        <div class="col-md-9 "><label>PROSESING</label></div>
                                    </div><br>
                                    <div class="row <?php if($action==5){echo "text-selecter";} ?>">
                                        <div class="col-md-1"><label
                                                class="<?php if($action > 5){echo "text-green";} ?>"><i
                                                    class="fa fa-circle-o"></i></label></div>
                                        <div class="col-md-9 "><label>PRICEING </label></div>
                                    </div><br>
                                    <div class="row <?php if($action==6){echo "text-selecter";} ?>">
                                        <div class="col-md-1"><label><i class="fa fa-circle-o"></i></label></div>
                                        <div class="col-md-9 "><label>PAYMENT </label></div>
                                    </div>

                                    <!-- DONUT CHART -->


                                    <?php
                            // Assuming you already have a valid database connection
                            // Assuming $id is already set to the current job_no

                            // Fetching details from the sales_list table for the given job_no
                            $result = select('sales_list', '*', 'job_no=' . $id);

                            // Loop through all rows in the sales_list table for the given job_no
                            while ($row = $result->fetch()) {
                                $approvel_doc = $row['approvel_doc'];
                                $app_note = $row['approvel_note'];  
                                $m_img = $row['m_img'];
                                $sales_list_id = $row['id']; 
                            }

                            // Query to count jobs for each status_id in a specific job_no
                            $query = "SELECT status_id, COUNT(*) AS total_jobs
                                    FROM sales_list
                                    WHERE job_no = :id
                                    GROUP BY status_id";

                            $stmt = $db->prepare($query);
                            $stmt->execute(['id' => $id]);  // Use the current job_no to filter

                            // Prepare data for the chart
                            $status_counts = [0, 0, 0, 0, 0, 0];  // Default counts for [measure, artwork, on_approval, printing, fix, complete]
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $status_id = (int)$row['status_id'];
                                if (isset($status_counts[$status_id])) {
                                    $status_counts[$status_id] = (int)$row['total_jobs'];  // Set the count for each status
                                }
                            }

                            // Pass the status counts to JavaScript for rendering the donut chart
                            echo "<script>
                                var pieData = " . json_encode($status_counts) . ";
                            </script>";
                            ?>
                                </div>
                            </div>
                        </div>


                        <?php if($action >= 3){ ?>



                        <?php } ?>
                    </div>
                </div>
                <div class="col-md-10">
                    <!-- / COMPANY -->
                    <div class="box box-info" style="border: 1px solid #ddd; border-radius: 8px; padding: 20px;">
                        <div class="box-header" style="margin-bottom: 20px;">
                            <div class="row">
                                <!-- Customer Details Header -->
                                <div class="col-md-3">
                                    <h3 style="font-weight: bold;">CUSTOMER <small
                                            style="font-weight: normal;">Details</small></h3>
                                </div>

                                <!-- User Profile Image -->
                                <div class="col-md-9">
                                    <?php 
                $result = query("SELECT user.upic as img FROM user_activity JOIN user ON user_activity.user_id=user.employee_id WHERE user_activity.job_no= '$id' GROUP BY user_activity.user_id ");
                for ($i = 0; $row = $result->fetch(); $i++) { ?>
                                    <img src="<?php echo $row['img']; ?>"
                                        style="width: 30px; border: 2px solid #ddd; border-radius: 50%; padding: 2px; margin-left: 10px; float: right;"
                                        alt="User Image">
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <div class="box-body">
                            <div class="row">
                                <!-- Company and Note Information -->
                                <div class="col-md-6">
                                    <h4 style="font-weight: bold; color: #333;"><?php echo $company; ?></h4>
                                    <h5 style="font-weight: normal; color: #777;"><?php echo $note; ?></h5>
                                </div>
                                <?php 
                        {
                        ?>
                                <!-- Invoice in a Shadow Box -->
                                <div class="col-md-6">
                                    <div
                                        style="background-color: #f9f9f9; border-radius: 8px; padding: 15px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); margin-top: 10px;">
                                        <h4 style="font-weight: bold; margin-bottom: 10px;">Internal Company:</h4>
                                        <p style="margin: 0; font-weight: normal; color: #555;">
                                            <?php 
                        $invoice = select_item('project','internal', "id='$id'"); 
                        echo $invoice;
                        ?>
                                        </p>
                                        <h4 style="font-weight: bold; margin-bottom: 10px;">Shift type:</h4>
                                        <p style="margin: 0; font-weight: normal; color: #555;">
                                            <?php 
                        $invoice = select_item('project','shift_type_name', "id='$id'"); 
                        echo $invoice;
                        ?>
                                        </p>

                                    </div>
                                </div>


                                <?php } ?>
                            </div>
                        </div>
                    </div>







                    <!-- Quotation -->
                    <div class="box box-info">
                        <div class="box-header">
                            <h3>Quotation</h3>
                        </div>

                        <div class="box-body">
                            <form action="save/shift_save.php" method="post">
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>In Time (<b style="color:brown">HH.mm</b>)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="in_time"
                                                    value="<?php echo date('H.i') ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Out Time (<b style="color:brown">HH.mm</b>)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="out_time"
                                                    value="<?php echo date('H.i') ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Note</label>
                                            <input type="text" class="form-control" name="note">
                                        </div>
                                    </div>

                                    <?php

                                    $shift = select_item('project','shift_type_id',"id='$id'");

                                    if($shift == 2 ){
 ?>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Shift Price</label>
                                            <input type="number" class="form-control" name="price" required>
                                        </div>
                                    </div>

                                    <?php } ?>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>janitor Count</label>
                                            <input type="number" class="form-control" name="employee_count" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Supervicer Count</label>
                                            <input type="number" class="form-control" name="sup_count" required>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Working Days</label>
                                            <div class="d-flex flex-column align-items-start gap-2">
                                                <?php
                                                    $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                                                    foreach ($days as $day) {
                                                        echo "<div class='d-flex align-items-center'>
                                                                <input class='form-check-input me-2' type='checkbox' name='w_days[]' value='$day' id='$day'>
                                                                <label for='$day' class='badge bg-green'>$day</label>
                                                            </div>";
                                                    }
                                                    ?>
                                            </div>
                                        </div>
                                    </div>


                                    <input type="hidden" name="company_id" value="<?php echo $company_id; ?>">
                                    <input type="hidden" name="job_id" value="<?php echo $id ?>">

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" value="1" name="id2">
                                            <button type="submit" class="btn btn-info btn-block btn-sm">
                                                <i class="fas fa-save"></i> Save
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="box-body">
                                <table id="example2" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>In Time</th>
                                            <th>Out Time</th>
                                            <th>Working Days</th>
                                            <th>Note</th>
                                            <?php

                                    $shift = select_item('project','shift_type_id',"id='$id'");

                                    if($shift == 2 ){
                                    ?>
                                            <th>Price</th>

                                            <?php } ?>
                                            <th>Employee Count</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                        $result = select('gen_shift', '*','job_id='.$id);
                        while ($row = $result->fetch()) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['in_time']}</td>
                                    <td>{$row['out_time']}</td>
                                    <td>{$row['working_days']}</td>
                                    <td>{$row['note']}</td>
                                    <td>{$row['price']}</td>
                                    <td>{$row['employee_count']}</td>
                                </tr>";
                        }
                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <?php
                            $result = select('sales', '*', 'job_no = ' . $id);
                            $type = '';
                        if ($result) {
                            while ($row = $result->fetch()) {
                                $type = $row['pay_type'];
                            }
                        }
                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charges -->
                    <div class="box box-info">
                        <div class="box-header">
                            <h3> Charges <small>apply</small></h3>
                        </div>

                        <div class="box-body">


                            <form action="save/job/charge_save.php?id=<?php echo $id ?>" method="post">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Extra Users</label>
                                            <select class="form-control select2 " id="mat_id" name="mat_id"
                                                style="width: 100%;" tabindex="1" autofocus required>
                                                <?php 
                                                                    $result = select('gen_extracharges', '*');
                                                                    while ($row = $result->fetch()) { 
                                                                     $mat_id = $row['id']; 
                                                                    ?>
                                                <option value="<?php echo $row['id']; ?>">
                                                    <?php echo $row['name']; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>




                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Price</label>
                                            <input type="number" class="form-control" name="price" id="qty" step="0.001"
                                                min="0" style="width: 100%;">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>note</label>
                                            <input type="text" class="form-control" name="note" id="qty" "
                                               style=" width: 100%;">
                                        </div>
                                    </div>
                                    <input type="hidden" name="job_id" value="<?php echo $id ?>">

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <input type="hidden" value="1" name="id2">
                                            <input type="submit" style="margin-top: 23px; width: 100%;" id="u3"
                                                value="Save" class="btn btn-info btn-sm">
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <a href="extra_charge_add.php">
                                <button class="btn btn-sm btn-info">Add charges</button>
                            </a>

                            <div class="box-body">
                                <table id="example2" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Record</th>
                                            <th>Note</th>
                                            <th>Price</th>
                                            <th>@</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                                         // Fetch fix materials data from the database
                                                          $result = select('gen_excharge_rec', '*', 'project_id=' . $id);
                                                           while ($row = $result->fetch()) { ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['recored']; ?></td>
                                            <td><?php echo $row['note']; ?></td>
                                            <td><?php echo $row['price']; ?></td>

                                            <td> <a class="btn btn-sm btn-danger"
                                                    onclick="confirmDelete2(<?php echo $row['id']; ?>)"><i
                                                        class="fa fa-trash"></i></a></td>

                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>

                            </div>




                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-right">
                                        <?php  
                                            // Fetch the pay_type from the sales table for the current job_no
                                            $result = select('sales', '*', 'job_no = ' . $id);

                                            // Initialize variable for pay_type
                                            $type = '';

                                            // Fetch the pay_type from the database if the record exists
                                            if ($result) {
                                                while ($row = $result->fetch()) {
                                                    $type = $row['pay_type'];
                                                }
                                            }

                                            // Check if the pay_type is 'credit'
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sp note -->
                    <div class="box box-info">
                        <div class="box-header">
                            <h3>Special <small>Notes</small></h3>
                        </div>

                        <div class="box-body">
                            <form action="save/job/sp_note_save.php?id=<?php echo $id ?>" method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <h4>Select Notes</h4>
                                            <?php
                                            $result = select('gen_special_note', '*');
                                            while ($row = $result->fetch()) { ?>
                                            <div class="checkbox-item">
                                                <input type="checkbox" name="notes[]"
                                                    id="checkbox_<?php echo $row['id']; ?>"
                                                    value="<?php echo $row['id']; ?>" class="product-checkbox">
                                                <label for="checkbox_<?php echo $row['id']; ?>"
                                                    class="product-label"><?php echo $row['name']; ?></label>
                                            </div>
                                            <?php } ?>
                                        </div>

                                        <input type="hidden" name="job_id" value="<?php echo $id ?>">

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="hidden" value="1" name="id2">
                                                <input type="submit" style="margin-top: 23px; width: 100%;" id="u3"
                                                    value="Save" class="btn btn-info btn-sm">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>



                            <hr>

                            <div class="box-body">
                                <h4>Saved Notes</h4>
                                <table id="example2" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Record</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $result = select('gen_special_note_rec', '*', 'project_id=' . $id);
                                        while ($row = $result->fetch()) { ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td>
                                                <a class="btn btn-sm btn-danger"
                                                    onclick="confirmDelete2(<?php echo $row['id']; ?>)">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                            <a class="pull-right" href="save/print.php?id=<?php echo base64_decode($_GET['id']); ?>">
                                <button class="btn btn-sm btn-primary" onclick="this.disabled = true; clikup();"
                                    id="generate_invo">Generate Quotation</button>
                            </a>
                            <a href="gen_spnote_add.php">
                                <button class="btn btn-sm btn-warning">Add Notes</button>
                            </a>
                        </div>
                    </div>

                    <!-- agreement -->

                    <div class="box box-info">
                        <div class="box-header">
                            <h3> Agreement <small>Details</small></h3>
                        </div>

                        <div class="box-body">
                        <form action="save/job/agreement_save.php?id=<?php echo $id; ?>" method="post">
    <div class="row">
        <!-- 1st Party Name -->
        <div class="col-md-3">
            <label style="font-weight: bold;">1st Party Name</label>
            <div style="border: 1px solid red; background-color: #ffe6e6; padding: 10px; border-radius: 5px; color: #333;">
                <h4 style="margin: 0; font-weight: bold;"><?php echo htmlspecialchars($company); ?></h4>
            </div>
        </div>

        <!-- Register Number -->
        <div class="col-md-3">
            <div class="form-group">
                <label>Register Number</label>
                <input type="text" name="reg_no" class="form-control" value="<?php echo htmlspecialchars($reg_no); ?>" readonly>
            </div>
        </div>

        <!-- Open Date -->
        <div class="col-md-3">
            <div class="form-group">
                <label>Open Date</label>
                <input class="form-control" type="text" id="open_date" name="open_date" placeholder="Select date" autocomplete="off">
            </div>
        </div>

        <div class="col-md-3">
                <div class="form-group">
                    <label>Close Date</label>
                    <input class="form-control" type="text" id="datepicker1" name="close_date" placeholder="Select date" autocomplete="off">
                </div>
            </div>

        <!-- 2nd Party Name -->
        <div class="col-md-3">
            <div class="form-group">
                <label>2nd Party Name</label>
                <?php
                $result = select('info', '*');
                $owner = ''; // Default value to avoid undefined variable warnings
                $nic_no = '';
                while ($row = $result->fetch()) { 
                    $owner = $row['owner'];
                    $nic_no = $row['nic_no'];
                }
                ?>
                <input type="text" class="form-control" name="owner" value="<?php echo htmlspecialchars($owner); ?>" readonly>
            </div>
        </div>

        <!-- 2nd Party ID -->
        <div class="col-md-3">
            <div class="form-group">
                <label>2nd Party ID Number</label>
                <input type="text" class="form-control" name="nic" value="<?php echo htmlspecialchars($nic_no); ?>" readonly>
            </div>
        </div>

        <!-- Hidden Fields -->
        <input type="hidden" name="job_id" value="<?php echo htmlspecialchars($id); ?>">
        <input type="hidden" name="company" value="<?php echo htmlspecialchars($company); ?>">
        <input type="hidden" name="id2" value="<?php echo htmlspecialchars($shift_type_id); ?>">


        <!-- Save Button -->
        <div class="col-md-3">
            <div class="form-group">
                <input type="submit" style="margin-top: 23px; width: 100%;" id="u3" value="genarate agreement" class="btn btn-info btn-sm">
            </div>
        </div>
    </div>
</form>




    <!-- Table for Fix Materials -->

</div>

                    </div>

                    <!-- Pricing -->
                    <div class="box box-info">
                        <div class="box-header">
                            <h3>Price <small>Generate</small></h3>

                        </div>

                        <!-- Add New Job Popup -->
                        <div class="container-up d-none" id="add_job_popup">
                            <div class="row w-70">
                                <div class="box box-success popup" style="width: 150%;">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Add Descount</h3>
                                        <small onclick="click_close('add')" class="btn btn-sm btn-success pull-right">
                                            <i class="fa fa-times"></i>
                                        </small>
                                    </div>

                                    <div class="box-body d-block">
                                        <form method="POST" action="save/job/job_save.php">

                                            <div class="row" style="display: block;">






                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Discount</label>
                                                        <input type="number" name="discount" class="form-control"
                                                            name="dis" id="dis" style="width: 100%;">
                                                    </div>
                                                </div>





                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input type="hidden" name="unit" value="1">
                                                        <input type="hidden" name="id2" value="1">

                                                        <input type="submit" style="margin-top: 23px; width: 100%;"
                                                            id="u1" value="Save" class="btn btn-info btn-sm pull-right">
                                                    </div>
                                                </div>


                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box-body <?php if ($action >= 4) {} else { echo 'd-none'; } ?>">
                            <?php
                            $result = select('sales_list', '*', "job_no = $id AND status != 'reject' AND status != 'delete'", '');
                            if ($result) {
                                    $row = $result->fetch();
                                    if ($row) {
                                        $price = $row['price'];
                                        $qty = $row['qty'];
                                        $id1 = $row['id'];
                                    }
                                }
                                ?>

                            <form action="save/job/amount_save.php" method="post">
                                <div class="row">
                                    <!-- Job List -->
                                    <div class="col-md-7" id="select_area">
                                        <div class="form-group">
                                            <label>Job List</label>
                                            <select class="form-control select2" id="price_item" name="id"
                                                style="width: 100%;" onchange="price_type()" required>
                                                <?php 
                                                    // Fetching indirect sales
                                                    $result = select('sales_list', '*', "job_no = $id AND status != 'reject' AND status != 'delete'", '');
                                                    while ($row = $result->fetch()) {  
                                                    ?>
                                                <option pro_type="indirect" value="<?php echo $row['id']; ?>"
                                                    <?php if ($row['id'] == $id1) echo 'selected'; ?>>
                                                    <?php echo $row['name'].' ['.$row['about'].'] '; ?>
                                                </option>
                                                <?php } ?>
                                                <?php 
                                                    // Fetching direct products
                                                    $result = select('products', '*', "type='direct_selling'");
                                                    while ($row = $result->fetch()) { 
                                                    ?>
                                                <option pro_type="direct" value="<?php echo $row['id']; ?>">
                                                    <?php echo $row['product_name']; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Note Input -->
                                    <div class="col-md-3" id="pro_note" style="display: none;">
                                        <div class="form-group">
                                            <label>Note</label>
                                            <input type="text" class="form-control" name="note"
                                                placeholder="Enter note">
                                        </div>
                                    </div>

                                    <!-- Quantity Input -->
                                    <div class="col-md-2" id="qty_input" style="display: none;">
                                        <div class="form-group">
                                            <label>QTY</label>
                                            <input type="number" class="form-control" name="qty" value="1" min="1">
                                        </div>
                                    </div>

                                    <!-- Price Input -->
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Price</label>
                                            <input type="number" class="form-control" id="price" name="price" value="0"
                                                required>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <input type="hidden" value="<?php echo $id; ?>" name="job_no">
                                            <input type="hidden" value="indirect" name="type" id="pricing_type">
                                            <button type="submit" style="margin-top: 23px; width: 100%;" id="u5"
                                                class="btn btn-info btn-sm">
                                                Save
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>


                            <div class="row">
                                <div class="col-md-12">
                                    <table id="example2" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>

                                                <th>Name</th>
                                                <th>Quantity</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $totalAmount = 0;
                                                $discount=select_item('sales','discount',"job_no='$id' AND type='Quotation'");
                                                $result = select('sales_list', '*', 'job_no = ' . $id . ' AND amount > 0');
                                                while ($row = $result->fetch()) { 
                                                    $totalAmount += $row['amount']; // Sum the amounts
                                                ?>
                                            <tr>





                                                <td>
                                                    <div
                                                        style="display: flex; align-items: center; justify-content: space-between;">
                                                        <span><?php echo $row['name']; ?></span>

                                                        <div align="center">
                                                            <?php if (!empty($row['about'])): ?>
                                                            <div class="badge bg-green">
                                                                <?php echo $row['about']; ?>
                                                            </div>
                                                            <br>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </td>



                                                <td><?php echo $row['qty']; ?></td>
                                                <td class="text-right"><?php echo number_format($row['amount'],2); ?>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th colspan="1">Sub Total</th>
                                                <th class="text-right"><?php echo number_format($totalAmount,2); ?></th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th colspan="1">Discount</th>
                                                <th class="text-right"><?php echo number_format($discount,2); ?></th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th colspan="1">NET Total</th>
                                                <th class="text-right">
                                                    <?php echo number_format($net=$totalAmount-$discount,2); ?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-right">
                                        <?php  
                                // Fetch the pay_type from the sales table for the current job_no
                                $result = select('sales', '*', "type !='Quotation' AND job_no =" . $id);

                                // Initialize variable for pay_type
                                $type = '';

                                // Fetch the pay_type from the database if the record exists
                                if ($result) {
                                    while ($row = $result->fetch()) {
                                        $type = $row['pay_type'];
                                    }
                                }

                                // Check if the pay_type is 'credit'
                                if ($type === 'credit') { ?>
                                        <div class="btn-group">
                                            <button type="button"
                                                onclick="location.href = 'save/print.php?id=<?php echo base64_decode($_GET['id']); ?>' "
                                                class="btn btn-default btn-flat"
                                                style="border-radius: 10px 0px 0px 10px">Print</button>
                                            <button type="button" class="btn btn-default btn-flat dropdown-toggle"
                                                data-toggle="dropdown" style="border-radius: 0px 10px 10px 0px">
                                                <span class="caret"></span>
                                                <span class="sr-only">Format</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a
                                                        href="save/print.php?id=<?php echo base64_decode($_GET['id']); ?>&type=location">Location</a>
                                                </li>
                                                <li><a
                                                        href="save/print.php?id=<?php echo base64_decode($_GET['id']); ?>">Product</a>
                                                </li>
                                            </ul>
                                        </div>


                                        <?php } else { ?>
                                        <button onclick="discount(1);" class="btn btn-sm btn-info bg-yellow"
                                            id="generate_invo">Set
                                            Discount</button>


                                        <a href="save/genarate_invoice.php?id=<?php echo base64_decode($_GET['id']); ?>"
                                            onclick="clikup();">
                                            <button class="btn btn-sm btn-info" id="generate_invo">Generate
                                                Invoice</button>
                                        </a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment -->
                    <div class="box box-info">
                        <div class="box-header">
                            <h3>Payment <small>section</small></h3>
                        </div>

                        <div class="box-body <?php if ($action >= 5) {} else { echo 'd-none'; } ?>">
                            <?php
                        $result = select('sales_list', '*', "job_no = $id AND status != 'reject' AND status != 'delete'", '');
                        if ($result) {
                            $row = $result->fetch();
                            if ($row) {
                                $price = $row['price'];
                                $qty = $row['qty'];
                                $id1 = $row['id'];
                            }
                        }
                        ?>

                            <form action="save/job/payment_save.php" method="post">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="pay_type">Type</label>
                                            <select name="pay_type" class="form-control" onchange="select_pay()"
                                                id="pay_type" required>
                                                <option value="">Select type</option>
                                                <option value="card">Card</option>
                                                <option value="cash">Cash</option>
                                                <option value="chq">Cheque</option>
                                                <option value="Bank">Bank</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Pay Amount</label>
                                            <input class="form-control" type="number" name="amount" autocomplete="off"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-md-3 slt-chq" style="display:none;">
                                        <div class="form-group">
                                            <label>Chq Number</label>
                                            <input class="form-control" type="text" name="chq_no" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-md-3 slt-chq" style="display:none;">
                                        <div class="form-group">
                                            <label>Chq Date</label>
                                            <input class="form-control" id="datepicker1" type="text" name="chq_date"
                                                autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-md-3 slt-chq" style="display:none;">
                                        <div class="form-group">
                                            <label>Bank</label>
                                            <input type="text" class="form-control" id="bank_name" name="bank_name"
                                                autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-md-3 slt-bank" style="display:none;">
                                        <label>Bank</label>

                                        <select class="form-control select2 " id="bank_name" name="bank_name"
                                            style="width: 100%;" tabindex="1" autocomplete="off">
                                            <?php 
                                                                        $result = select('bank', '*');
                                                                        while ($row = $result->fetch()) { 
                                                                            $bank_id = $row['id']; 
                                                                    ?>
                                            <option value="<?php echo $row['id']; ?>">
                                                <?php echo $row['name']; ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <input type="hidden" name="id" value="<?php echo base64_decode($_GET['id']); ?>">

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="submit" style="margin-top: 23px; width: 100%;" id="u8"
                                                value="Save" class="btn btn-info btn-sm">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="example2" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Type</th>
                                                    <th>Chq No</th>
                                                    <th>Chq Date</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $result = select('payment', '*', 'job_no = ' . $id);
                                                while ($row = $result->fetch()) { ?>
                                                <tr>
                                                    <td><?php echo $row['pay_type']; ?></td>
                                                    <td><?php echo $row['chq_no']; ?></td>
                                                    <td><?php echo $row['chq_date']; ?></td>
                                                    <td>
                                                        <div style="display: flex; align-items: center;">
                                                            <span
                                                                style="margin-right: 5px;"><?php echo $row['amount']; ?></span>
                                                            <?php if ($row['pay_type'] == 'credit') { ?>
                                                            <div
                                                                style="display: flex; align-items: center; justify-content: center;">
                                                                <div class="badge bg-blue"
                                                                    style="display: inline-block; margin-left: 5px;">
                                                                    <?php echo $row['credit_balance']; ?>
                                                                </div>
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <?php
                                        $totalpayAmount = 0;
                                        $result = select('payment', '*', 'job_no = ' . $id . ' AND pay_type != "credit"');
                                        while ($row = $result->fetch()) {
                                            $totalpayAmount += $row['amount'];
                                        }
                                        ?>

                                        <h5>Total Amount: <?php echo $net; ?></h5>
                                        <h5>Pay Amount: <?php echo $totalpayAmount; ?></h5>
                                        <h5>Balance: <?php echo $net - $totalpayAmount; ?></h5>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>



        </section>


        <div class="container-up d-none" id="container_up">
            <div class="row w-70">
                <div class="box box-success popup" id="popup_1" style="width: 100%;">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Set Discount
                        </h3>
                        <small onclick="discount(2)" class="btn btn-sm bg-gray pull-right"><i
                                class="fa fa-times"></i></small>
                    </div>

                    <div class="box-body d-block">
                        <form method="POST" action="save/discount_save.php">

                            <div class="row" style="display: block;">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" name="amount" value="" placeholder="Discount"
                                            class="form-control" autocomplete="off" required>
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <input type="hidden" name="job_no" value="<?php echo $id ?>">
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

    <?php include_once("script.php"); ?>

    <!-- DataTables -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../../plugins/fastclick/fastclick.js"></script>

    <!-- Select2 -->
    <script src="../../plugins/select2/select2.full.min.js"></script>

    <!-- date-range-picker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="../../plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap datepicker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>


    <script>
    // Calculate total and create labels with percentages
    var total = pieData.reduce((acc, val) => acc + val, 0);

    var pieLabels = ["Measure", "Artwork", "On Approval", "Printing", "Fix", "Complete"].map(function(label, index) {
        var percentage = ((pieData[index] / total) * 100).toFixed(2);
        return label + ' (' + percentage + '%)';
    });

    // Get the context of the canvas where the chart will be drawn
    var pieChartCanvas = document.getElementById("pieChart").getContext("2d");

    // Create the doughnut chart
    var pieChart = new Chart(pieChartCanvas, {
        type: 'doughnut',
        data: {
            labels: pieLabels, // Add labels with percentages
            datasets: [{
                data: pieData, // Actual data values from server
                backgroundColor: ["#f56954", "#f39c12", "#00c0ef", "#3c8dbc", "#d2d6de", "#00a65a"],
                hoverBackgroundColor: ["#f56954", "#f39c12", "#00c0ef", "#3c8dbc", "#d2d6de", "#00a65a"]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutoutPercentage: 60, // Adjust this for the size of the inner hole (50% makes it donut-shaped)
            animation: {
                animateRotate: true,
                animateScale: false
            }
        }
    });

    function discount(action) {
        if (action == 1) {
            document.getElementById('container_up').classList.remove('d-none');
        } else {
            document.getElementById('container_up').classList.add('d-none');
        }

    }

    function pro_select() {

        // Get the selected product ID from the #mat_id dropdown
        let productId = $('#mat_id').val();

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


    function confirmDelete2(id) {
        if (confirm('Are you sure you want to delete this item?')) {
            // Redirect to a PHP page that handles the deletion
            window.location.href = 'delete_fix.php?id=' + id;
        }
    }

    function confirmDelete_product(id) {
        if (confirm('Are you sure you want to delete this item?')) {
            // Redirect to a PHP page that handles the deletion
            window.location.href = 'save/job/product_dll.php?id=' + id + '&job_no=<?php echo $id; ?>';
        }
    }

    function quotation(data) {
        if (data == 1) {
            if (confirm('Did the customer agree with this price?')) {
                // Redirect to a PHP page that handles the deletion
                date = document.getElementById('datepicker').value
                window.location.href = 'save/job/quotation_app.php?id=<?php echo $id; ?>&app=1&date=' + date;
            }
        }
        if (data == 2) {
            if (confirm('Did the customer disagree with this price?')) {
                // Redirect to a PHP page that handles the deletion
                window.location.href = 'save/job/quotation_app.php?id=<?php echo $id; ?>&app=2';
            }
        }
    }

    function quotation1(data) {
        if (data == 1) {
            if (confirm('are you sure?')) {
                // Redirect to a PHP page that handles the deletion
                window.location.href = 'edit/team_driver.php?id=<?php echo $emp_id; ?>&job_no=<?php echo $id; ?>&app=1';
            }
        }
        if (data == 2) {
            if (confirm('Did the customer disagree with this price?')) {
                // Redirect to a PHP page that handles the deletion
                window.location.href = 'edit/team_driver.php?id=<?php echo $emp_id; ?>&job_no=<?php echo $id; ?>&app=2';
            }
        }
    }
    </script>




    <script type="text/javascript">
    window.addEventListener("scroll", () => {
        const scrollPosition = window.scrollY;
        const element1 = document.getElementById("element1");

        // Hold Box 1 to scroll at a slower rate to give a 'held' effect
        element1.style.transform = `translateY(${scrollPosition * 0.85}px)`;


    });


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

<script>
    // Get today's date in the format YYYY-MM-DD
    const today = new Date();
    const formattedDate = today.toISOString().split('T')[0];

    // Set the value of the input field to today's date
    document.getElementById('open_date').value = formattedDate;
</script>

    <script>
    function price_type() {
        var select = document.getElementById('price_item');
        var selectedOption = select.options[select.selectedIndex];
        var item = selectedOption.getAttribute('pro_type'); // Get 'pro_type' attribute

        if (item === 'direct') {
            document.getElementById('qty_input').style.display = 'block';
            document.getElementById('pro_note').style.display = 'block';
            document.getElementById('pricing_type').value = 'direct';
            document.getElementById('select_area').classList.replace('col-md-7', 'col-md-4');
        } else {
            document.getElementById('qty_input').style.display = 'none';
            document.getElementById('pro_note').style.display = 'none';
            document.getElementById('pricing_type').value = 'indirect';
            document.getElementById('select_area').classList.replace('col-md-4', 'col-md-7');
        }
    }


    function select_pay() {
        var val = $('#pay_type').val(); // Added '#' for correct ID selector
        if (val === "Bank") {
            $('.slt-bank').show();
        } else {
            $('.slt-bank').hide();
        }

        if (val === "chq") {
            $('.slt-chq').show();
        } else {
            $('.slt-chq').hide();
        }
    }

    //Date picker
    $('#datepicker1').datepicker({
        autoclose: true,
        datepicker: true,
        format: 'yyyy-mm-dd '
    });
    $('#datepicker').datepicker({
        autoclose: true,
        datepicker: true,
        format: 'yyyy-mm-dd'
    });


    $('#datepickerd').datepicker({
        autoclose: true,
        datepicker: true,
        format: 'yyyy-mm-dd '
    });
    $('#datepickerd').datepicker({
        autoclose: true
    });

    function dll(did) {
        var xmlhttp;
        if (window.XMLHttpRequest) {
            // Modern browsers
            xmlhttp = new XMLHttpRequest();
        } else {
            // Older browsers
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                // Update the content of the 'sub_list' div
                document.getElementById("sub_list").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "package_list_dll.php?id=" + did, true);
        xmlhttp.send();
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