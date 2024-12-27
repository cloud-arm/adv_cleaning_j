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
    $_SESSION['SESS_FORM'] = 'hr_payroll';

    if ($r == 'Cashier') {

        include_once("sidebar2.php");
    }
    if ($r == 'admin') {

        include_once("start_body.php");
    }
    ?>

    <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Payroll
                <small>Preview</small>
            </h1>
        </section>





        <!-- Main content -->
        <section class="content">.
            <div class="row">
                <div class="col-md-6">

                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Payroll</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <form method="get" action="">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <div class="box-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <select class="form-control select2" name="id"
                                                                style="width: 100%;" tabindex="1" autofocus>
                                                                <option value="0"></option>
                                                                <?php
                                                                $result = $db->prepare("SELECT * FROM employee");
                                                                $result->bindParam(':userid', $res);
                                                                $result->execute();
                                                                for ($i = 0; $row = $result->fetch(); $i++) { ?>
                                                                <option value="<?php echo $row['id']; ?>">
                                                                    <?php echo $row['name']; ?>
                                                                </option>
                                                                <?php 
   } ?>
                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <label>Date range:</label>
                                                        <div class="input-group">
                                                            <div class="input-group-addon"><i
                                                                    class="fa fa-calendar"></i></div>
                                                            <input type="text" class="form-control pull-right"
                                                                id="reservation" name="dates"
                                                                value="<?php echo isset($_GET['dates']) ? $_GET['dates'] : '';?>">
                                                        </div>
                                                    </div>

                                                    <input class="btn btn-info" type="submit" value="Submit">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <?php
 function AddPlayTime($times = [])
 {
     $minutes = 0; // Declare minutes to avoid undefined variable notice
 
     // Check if $times is set and not empty
     if (isset($times) && is_array($times)) {
         // Loop through all the times
         foreach ($times as $time) {
             list($hour, $minute) = explode('.', $time);
             $minutes += $hour * 60;
             $minutes += $minute;
         }
     }
 
     // Calculate hours and remaining minutes
     $hours = floor($minutes / 60);
     $minutes -= $hours * 60;
 
     // Return the time already formatted
     return sprintf('%02d.%02d', $hours, $minutes);
 }

                             {
                                $id =isset( $_GET["id"]) ? $_GET["id"] : 1;
                                $dates = isset($_GET["dates"]) ? $_GET["dates"] : '';



                                if (!empty($dates)) {
                                    list($start_date, $end_date) = explode(" - ", $dates);
                                    $d1 = date("Y-m-d", strtotime($start_date));
                                    $d2 = date("Y-m-d", strtotime($end_date));
                                }


                                    $result = $db->prepare("SELECT count(id) FROM attendance WHERE emp_id='$id' AND date BETWEEN '$d1' AND '$d2' AND weekend = 'sunday' ORDER BY id ASC");
                                    $result->bindParam(':userid', $date);
                                    $result->execute();
                                    for ($i = 0; $row = $result->fetch(); $i++) {
                                        $weekend = $row['count(id)'];
                                    }

                                    $result = $db->prepare("SELECT count(id) FROM attendance WHERE emp_id='$id' AND date BETWEEN '$d1' AND '$d2' AND special_date = 'yes' ORDER BY id ASC");
                                    $result->bindParam(':userid', $date);
                                    $result->execute();
                                    for ($i = 0; $row = $result->fetch(); $i++) {
                                        $holidays = $row['count(id)'];
                                    }

                                    $result = $db->prepare("SELECT count(id) FROM attendance WHERE emp_id='$id' AND date BETWEEN '$d1' AND '$d2' AND normel_ot >= 1.30 ORDER BY id ASC");
                                    $result->bindParam(':userid', $date);
                                    $result->execute();
                                    for ($i = 0; $row = $result->fetch(); $i++) {
                                        $dinner_count = $row['count(id)'];
                                    }

                                    $result = $db->prepare("SELECT count(id) FROM attendance WHERE emp_id='$id' AND date BETWEEN '$d1' AND '$d2' AND tea = 'yes' ORDER BY id ASC");
                                    $result->bindParam(':userid', $date);
                                    $result->execute();
                                    for ($i = 0; $row = $result->fetch(); $i++) {
                                        $tea_count = $row['count(id)'];
                                    }

                                


                                $date = date("Y-m", strtotime($start_date));
                                $con = 0;
                                $result = $db->prepare("SELECT * FROM hr_payroll WHERE emp_id='$id' AND date = '$date' ");
                                $result->bindParam(':userid', $date);
                                $result->execute();
                                for ($i = 0; $row = $result->fetch(); $i++) {
                                    $con = $row['id'];
                                    $name = $row['name'];
                                    $rate = $row['day_rate'];
                                    $ot = $row['ot'];
                                    $commission = $row['commis'];
                                    $epf_8 = $row['epf'];
                                    $adv = $row['advance'];
                                }

                                $oth_ded = 0.00;
                                $commission = 0.00;

                                if ($con > 0) {

                                    $result = $db->prepare("SELECT count(id) FROM attendance WHERE emp_id='$id' AND date BETWEEN '$d1' AND '$d2' ORDER BY id ASC");
                                    $result->bindParam(':userid', $date);
                                    $result->execute();
                                    for ($i = 0; $row = $result->fetch(); $i++) {
                                        $day = $row['count(id)'];
                                    }

                                    $result = $db->prepare("SELECT * FROM employee WHERE id='$id' ");
                                    $result->bindParam(':userid', $date);
                                    $result->execute();
                                    for ($i = 0; $row = $result->fetch(); $i++) {
                                        $well = $row['well'];
                                        $epf1 = $row['epf_amount']; 
                                    }

                                    $h = 0;
                                    $m = 0;
                                    $result = $db->prepare("SELECT work_time,ot FROM attendance WHERE emp_id='$id' AND date BETWEEN '$d1' AND '$d2' ORDER BY id ASC");
                                    $result->bindParam(':userid', $date);
                                    $result->execute();
                                    for ($i = 0; $row = $result->fetch(); $i++) {
                                        $hour[] = $row['work_time'];
                                    }
                                  ?>

                            <div class="form-group">
                                <h2><?php echo $name; ?></h2>

                                <a
                                    href="hr_payroll.php?id=<?php echo $_GET['id'] - 1 ?>&year=<?php echo $_GET['year'] ?>&month=<?php echo $_GET['month'] ?>">
                                    <button class="btn btn-danger" <?php if ($_GET['id'] == 1) { ?>disabled
                                        <?php } ?>>Previous</button>
                                </a>

                                <a
                                    href="hr_payroll.php?id=<?php echo $_GET['id'] + 1 ?>&year=<?php echo $_GET['year'] ?>&month=<?php echo $_GET['month'] ?>">
                                    <button class="btn btn-danger">Next</button>
                                </a>
                                <h4 style="margin: 20px; 0"><?php echo $_GET['year'] . '-' . $_GET['month'] ?></h4>
                            </div>

                            <div class="form-group">
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <td>ATTENDANCE DAYS</td>
                                            <td align="right"><?php echo $day; ?></td>
                                        </tr>

                                        <tr>
                                            <td>Daily Rate</td>
                                            <td align="right">Rs.<?php echo $rate; ?></td>
                                        </tr>
                                    </tbody>
                                </table>  

                            </div>

                            <div class="form-group">
                                <table class="table table-bordered table-striped">

                                    <thead>
                                        <tr style="font-size: 16px;font-weight: 600;">
                                            <th align="left">Earnings</th>
                                            <th align="right">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Basic</td>
                                            <td align="right">Rs.<?php echo $basic = $rate * $day; ?></td>
                                        </tr>

                                        <tr>
                                            <td>OT</td>
                                            <td align="right">Rs.<?php echo number_format($ot, 2); ?></td>
                                        </tr>

                                        <tr>
                                            <td>Job Commission</td>
                                            <td align="right">Rs.<?php echo number_format($commission, 2); ?></td>
                                        </tr>

                                        <?php $allowances = 0;
                                                $result = $db->prepare("SELECT * FROM hr_allowances WHERE emp_id='$id' AND date BETWEEN '$d1' AND '$d2' ORDER BY id ASC");
                                                $result->bindParam(':userid', $date);
                                                $result->execute();
                                                for ($i = 0; $row = $result->fetch(); $i++) { ?>


                                        <?php $allowances += $row['amount'];
                                                } ?>

                                        <tr style="font-size: 15px;font-weight: 600;">
                                            <td align="right">Total</td>
                                            <td align="right">Rs.<?php $er_tot = $basic + $ot + $allowances + $commission;
                                                                            echo number_format($er_tot, 2); ?></td>
                                        </tr>

                                        <tr>
                                            <td>No-pay</td>
                                            <td align="right">Rs.<?php echo $no_pay = "0.00"; ?></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr style="font-size: 15px;font-weight: 600;">
                                            <td align="right">GROSS PAY</td>
                                            <td align="right">Rs.<?php echo number_format($er_tot - $no_pay, 2); ?></td>
                                        </tr>
                                    </tfoot>

                                </table>
                            </div>

                            <div class="form-group">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr style="font-size: 16px;font-weight: 600;">
                                            <th align="left">Deductions</th>
                                            <th align="right">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>EPF - 8%</td>
                                            <td align="right">Rs.<?php echo $epf1 ?></td>
                                        </tr>

                                        <tr>
                                            <td>Welfare</td>
                                            <td align="right">Rs.<?php echo $well; ?></td>
                                        </tr>

                                        <tr>
                                            <td>Advance/Loan</td>
                                            <td align="right">Rs.<?php echo $adv; ?></td>
                                        </tr>

                                        <tr>
                                            <td>Other Deduction</td>
                                            <td align="right"><?php echo $oth_ded; ?></td>
                                        </tr>

                                        <tr style="font-size: 15px;font-weight: 600;">
                                            <td align="right">Total</td>
                                            <td align="right">Rs.<?php $de_tot = $epf_8 + $well + $adv + $oth_ded;
                                                                            echo number_format($de_tot, 2) ?></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <?php $er_tot = $basic + $ot + $allowances + $commission;
                                                                             number_format($er_tot, 2); ?>
                                        <tr style="font-size: 15px;font-weight: 600;">
                                            <td align="right">NET Salary</td>
                                            <td align="right">Rs.<?php echo number_format($er_tot - $de_tot, 2); ?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="form-group">
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <td>EPF - 12%</td>
                                            <td align="right">Rs.<?php echo $epf_12 = $epf1 *12/8; ?></td>
                                        </tr>

                                        <tr>
                                            <td>ETF - 3%</td>
                                            <td align="right">Rs.<?php echo $etf = $epf1 *3/8; ?></td>
                                        </tr>

                                        <tr style="font-size: 15px;font-weight: 600;">
                                            <th align="right">Total</th>
                                            <th align="right">Rs.<?php echo $oth_tot = $epf_12 + $etf; ?></th>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr style="font-size: 15px;font-weight: 600;">
                                            <th align="right">Total Earnings</th>
                                            <th align="center">Rs.<?php $tot_earn = $er_tot + $oth_tot;
                                                                            echo number_format($tot_earn, 2); ?></th>
                                        </tr>
                                        <tr style="font-size: 15px;font-weight: 600;">
                                            <th align="right">Gross Pay</th>
                                            <th align="center">Rs.<?php echo number_format($tot_earn - $oth_tot, 2); ?>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="form-group">
                                <form action="hr_payroll_save.php" method="post">
                                    <input type="hidden" name="date"
                                        value="<?php echo $_GET['year'] . "-" . $_GET['month'] ?>">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <input type="submit" value="Already payroll create" disabled class="btn text-green"
                                        style="width: 100%; font-weight: 600; opacity: 1;">
                                </form>
                            </div>

                            <div class="form-group">
                                <form action="hr_payroll_print.php" method="get">
                                    <input type="hidden" name="date"
                                        value="<?php echo $_GET['year'] . "-" . $_GET['month'] ?>">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <input type="hidden" name="type" value="1">
                                    <input type="submit" value="Print" class="btn btn-info pull-right">
                                </form>
                            </div>
                            <?php } else {

                                    $h = 0;
                                    $m = 0;
                                    $result = $db->prepare("SELECT work_time,ot FROM attendance WHERE emp_id='$id' AND date BETWEEN '$d1' AND '$d2' ORDER BY id ASC");
                                    $result->bindParam(':userid', $date);
                                    $result->execute();
                                    for ($i = 0; $row = $result->fetch(); $i++) {
                                        $hour = isset($row['work_time']) ? $row['work_time'] : 0;
                                        $ot = isset($row['ot']) ? $row['ot'] : 0;

                                    }

                                    $result = $db->prepare("SELECT count(id) FROM attendance WHERE emp_id='$id' AND date BETWEEN '$d1' AND '$d2' ORDER BY id ASC");
                                    $result->bindParam(':userid', $date);
                                    $result->execute();
                                    for ($i = 0; $row = $result->fetch(); $i++) {
                                        $day = $row['count(id)'];
                                    }

                                    $result = $db->prepare("SELECT * FROM employee WHERE id='$id' ");
                                    $result->bindParam(':userid', $date);
                                    $result->execute();
                                    for ($i = 0; $row = $result->fetch(); $i++) {
                                        $name = $row['name'];
                                        $rate = $row['rate'];
                                        $epf_8 = $row['epf_amount'];
                                        $basic = $row['basic'];
                                        $well = $row['well'];
                                        $s_ot_rate = $row['s_ot_rate'];
                                    }

                                    $result = $db->prepare("SELECT sum(amount) FROM salary_advance WHERE emp_id='$id' AND date BETWEEN '$d1' AND '$d2' ORDER BY id ASC");
                                    $result->bindParam(':userid', $date);
                                    $result->execute();
                                    for ($i = 0; $row = $result->fetch(); $i++) {
                                        $adv = $row['sum(amount)'];
                                    }

                                   // $result = $db->prepare("SELECT sum(commission) FROM sales JOIN job ON sales.invoice_number = job.invoice_no  WHERE job.type='Close' AND job.r_person = '$id' AND job.close_date BETWEEN '$d1' AND '$d2'");
                                    $result->bindParam(':userid', $date);
                                    $result->execute();
                                    for ($i = 0; $row = $result->fetch(); $i++) {
                                        //$commission = $row['sum(commission)'];
                                    } ?>

                            <div class=" form-group">
                                <h2><?php echo $name; ?></h2>

                                <a
                                    href="hr_payroll.php?id=<?php echo $_GET['id'] - 1 ?>&year=<?php echo $_GET['year'] ?>&month=<?php echo $_GET['month'] ?>">
                                    <button class="btn btn-danger" <?php if ($_GET['id'] == 1) { ?>disabled
                                        <?php } ?>>Previous</button>
                                </a>

                                <a
                                    href="hr_payroll.php?id=<?php echo $_GET['id'] + 1 ?>&year=<?php echo $_GET['year'] ?>&month=<?php echo $_GET['month'] ?>">
                                    <button class="btn btn-danger">Next</button>
                                </a>
                                <h4 style="margin: 20px; 0"><?php  echo date("Y-m", strtotime($start_date));?></h4>
                            </div>

                            <div class="form-group">
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <td>ATTENDANCE DAYS</td>
                                            <td align="right"><?php echo $day; ?></td>
                                        </tr>

                                        <tr>
                                            <td>Daily Rate</td>
                                            <td align="right">Rs.<?php echo $rate; ?></td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>

                            <div class="form-group">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr style="font-size: 16px;font-weight: 600;">
                                            <th align="left">Earnings</th>
                                            <th align="right">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                                $total_normal_ot = 0;
                                                $total_special_ot = 0;
                                                $allowances = 0;

                                                // Fetch attendance details
                                                $result = $db->prepare("SELECT * FROM attendance WHERE emp_id = :id AND date BETWEEN :d1 AND :d2 ORDER BY id ASC");
                                                $result->bindParam(':id', $id);
                                                $result->bindParam(':d1', $d1);
                                                $result->bindParam(':d2', $d2);
                                                $result->execute();

                                                while ($row = $result->fetch()) {
                                                    $dinner = $row['dinner'];
                                                    $normal_ot = is_numeric($row['normel_ot']) ? $row['normel_ot'] : 0;
                                                    $special_ot = is_numeric($row['special_ot']) ? $row['special_ot'] : 0;

                                                    $total_normal_ot += $normal_ot;
                                                    $total_special_ot += $special_ot;
                                                }

                                                // Display basic pay



                                                $basic = $rate * $day;


                                                ?>

                                        <tr>
                                            <td>Basic</td>
                                            <td align="right">Rs.<?php echo number_format($basic, 2); ?></td>
                                        </tr>


                                        <!-- Display N:OT and S:OT -->
                                        <tr>
                                            <td>N:OT</td>
                                            <td align="right">
                                                Rs.<?php echo $ot2= number_format($total_normal_ot, 2)*120; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>S:OT</td>
                                            <td align="right">
                                                Rs.<?php  echo $ot1= number_format($total_special_ot, 2)*$s_ot_rate; ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Sunday</td>
                                            <?php
                                if(($weekend != 0)){?>

                                            <?php $s_price =  300; 
                            ?>

                                            <td align="right">Rs.<?php echo $s_price= $s_price*$weekend; ?></td>

                                            <?php } else { ?>
                                            <td align="right">Rs.<?php echo $s_price =  0; ?></td>
                                            <?php } ?>
                                        </tr>

                                        <td>Merchant Day</td>
                                        <?php
                                if(($holidays != 0)){?>
                                        <?php  $h_price =  500;
                                 ?>
                                        <td align="right">Rs.<?php echo $h_price= $h_price*$holidays; ?></td>

                                        <?php } else { ?>
                                        <td align="right">Rs.<?php echo $h_price =  0; ?></td>
                                        <?php } ?>
                                        </tr>

                                        <tr>
                                            <td>Dinner</td>
                                            <?php
                                             if(($dinner_count != 0)){?>
                                            <?php $d_price =  300; ?>
                                            <td align="right">Rs.<?php echo $d_price = $d_price*$dinner_count; ?></td>

                                            <?php } else { ?>
                                            <td align="right">Rs.<?php echo $d_price =  0; ?></td>
                                            <?php } ?>
                                        </tr>

                                        <tr>
                                            <td>Tea</td>
                                            <?php
                                             if(($tea_count != 0)){?>
                                            <?php $t_price =  50; ?>
                                            <td align="right">Rs.<?php echo $t_price = $t_price*$tea_count; ?></td>

                                            <?php } else { ?>
                                            <td align="right">Rs.<?php echo $t_price =  0; ?></td>
                                            <?php } ?>
                                        </tr>

                                        <?php
                                            $ot_tot=$total_normal_ot+$total_special_ot;
                                            // Fetch allowances
                                            $result = $db->prepare("SELECT * FROM hr_allowances WHERE emp_id = :id AND date BETWEEN :d1 AND :d2 ORDER BY id ASC");
                                            $result->bindParam(':id', $id);
                                            $result->bindParam(':d1', $d1);
                                            $result->bindParam(':d2', $d2);
                                            $result->execute();

                                            while ($row = $result->fetch()) {
                                                $allowances += $row['amount'];
                                            ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['note']); ?></td>
                                            <td align="right">Rs.<?php echo number_format($row['amount'], 2); ?></td>
                                        </tr>
                                        <?php } ?>

                                        <!-- Total row -->
                                        <tr style="font-size: 15px;font-weight: 600;">
                                            <td align="right">Total</td>
                                            <td align="right">
                                                Rs.<?php echo  number_format( $t1= $basic  + $ot2 + $ot1  + $s_price + $d_price + $h_price + $t_price, 2); ?>
                                            </td>
                                        </tr>

                                        <!-- No-pay -->
                                        <tr>
                                            <td>No-pay</td>
                                            <td align="right">Rs.<?php echo number_format(0, 2); ?></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr style="font-size: 15px;font-weight: 600;">
                                            <td align="right">GROSS PAY</td>
                                            <td align="right">
                                                Rs.<?php echo number_format($basic  + $ot2 + $ot1 + $allowances + $s_price + $d_price + $h_price +$t_price, 2); ?>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>

                            </div>
<?php  
                            $result = $db->prepare("SELECT * FROM employee WHERE id='$id' ");
                                    $result->bindParam(':userid', $date);
                                    $result->execute();
                                    for ($i = 0; $row = $result->fetch(); $i++) {
                                        $well = $row['well'];
                                        $epf1 = $row['epf_amount']; 
                                    }

                                    ?>

                            <div class="form-group">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr style="font-size: 16px;font-weight: 600;">
                                            <th align="left">Deductions</th>
                                            <th align="right">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>EPF - 8%</td>
                                            <td align="right">Rs.<?php echo number_format($epf_= $epf1); ?>
                                            </td>
                                        </tr>



                                        <tr>
                                            <td>Advance/Loan</td>
                                            <td align="right">Rs.<?php echo number_format($adv,2); ?></td>
                                        </tr>

                                        <tr>
                                            <td>Other Deduction</td>
                                            <td align="right"><?php echo number_format($oth_ded,2); ?></td>
                                        </tr>

                                        <tr style="font-size: 15px;font-weight: 600;">
                                            <td align="right">Total</td>
                                            <td align="right">
                                                Rs.<?php echo number_format($de_tot =  $epf_  + $adv + $oth_ded,2); ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr style="font-size: 15px;font-weight: 600;">
                                            <td align="right">NET Salary</td>
                                            <td align="right">Rs.
                                                <?php echo number_format (($t1 - $de_tot),2) ; ?>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="form-group">
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <td>EPF - 12%</td>
                                            <td align="right">Rs.<?php echo $epf_12 = $epf1 *12/8; ; ?></td>
                                        </tr>

                                        <tr>
                                            <td>ETF - 3%</td>
                                            <td align="right">Rs.<?php echo $etf = $epf1 *3/8;?></td>
                                        </tr>

                                        <tr style="font-size: 15px;font-weight: 600;">
                                            <td align="right">Total</td>
                                            <td align="right">Rs.<?php echo $oth_tot = $epf_12 + $etf; ?></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr style="font-size: 15px;font-weight: 600;">
                                            <td align="right">Total Earnings</td>
                                            <td align="center">Rs.
                                                <?//php echo number_format($er_tot + $oth_tot, 2); ?>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="form-group">
                                <form action="hr_payroll_save.php" method="post">
                                    <input type="hidden" name="date1" value="<?php echo $d1?>">
                                    <input type="hidden" name="date2" value="<?php echo $d2?>">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">


                                    <input type="submit" value="Process All" class="btn btn-danger"
                                        style="width: 100%;">
                                </form>
                            </div>
                            <?php } ?>
                            <?php  } ?>
                        </div>
                    </div>


                </div>

                <div class="col-md-6">
                    <?php if (isset($_GET['id'])) { ?>
                    <div class="box box-warning">
                        <div class="box-header">
                            <h3 class="box-title">Attendance List</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            <table id="example2" class="table table-bordered table-striped">

                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>Out Date</th>

                                        <th>IN</th>
                                        <th>OUT</th>
                                        <th>W time</th>
                                        <th>N:ot</th>
                                        <th>S:ot</th>




                                    </tr>

                                </thead>

                                <tbody>

                                    <?php
                                            $total_normal_ot = 0;
                                            $total_special_ot = 0;
                                            $total_wt = 0;
                                         $ot = array();
                                        $result = $db->prepare("SELECT * FROM attendance WHERE emp_id='$id' AND date BETWEEN '$d1' AND '$d2' ORDER BY id ASC");
                                        $result->bindParam(':userid', $date);
                                        $result->execute();
                                        for ($i = 0; $row = $result->fetch(); $i++) {
                                                    // Ensure values are numeric, use 0 if not
                                                $normal_ot = is_numeric($row['normel_ot']) ? $row['normel_ot'] : 0;
                                                $special_ot = is_numeric($row['special_ot']) ? $row['special_ot'] : 0;
                                                $work = $row['deff_time'];
                                                $total_normal_ot += $normal_ot;
                                                $total_special_ot += $special_ot;
                                                $total_wt += $work;
                                                $outtime = $row['OUT_time']
                                        ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['date'] ?></td>
                                        <td><?php echo $row['out_date'] ?></td>


                                        <td><?php echo $row['IN_time']; ?></td>
                                        <?php
                                if ($outtime > 24.00) {
                                    // Subtract 24 and format as time
                                    $time = $row['OUT_time'] - 24.00;
                                    $formattedTime = date("H:i", strtotime(sprintf('%02d:%02d', floor($time), ($time - floor($time)) * 60)));
                                } else {
                                    // Format as time directly
                                    $time = $row['OUT_time'];
                                    $formattedTime = date("H:i", strtotime(sprintf('%02d:%02d', floor($time), ($time - floor($time)) * 60)));
                                }
                                ?>
                                <td><?php echo $formattedTime; ?></td>                                   
                                    <td><?php echo $row['deff_time']; ?></td>

                                        <td><?php echo $row['normel_ot']; ?></td>

                                        <td><?php echo $row['special_ot']; ?></td>

                                        <?php array_push($ot, $row['ot']) ?>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>




                                    <?php
                                    // Function to format total overtime into HH.MM format
                                    function formatTime($timeDecimal)
                                    {
                                        $hours = floor($timeDecimal); // Extract hours
                                        $minutesDecimal = $timeDecimal - $hours; // Extract decimal part
                                        $minutes = round($minutesDecimal * 60); // Convert decimal to minutes
                                        return sprintf('%02d.%02d', $hours, $minutes); // Format as HH.MM
                                    }

                                    // Format the total normal and special overtime
                                    $formatted_work_ot = formatTime($total_wt);

                                    $formatted_normal_ot = formatTime($total_normal_ot);
                                    $formatted_special_ot = formatTime($total_special_ot);
                                    ?>

                                    <!-- Display formatted time in table headers -->
                                    <th><?php echo $total_wt; ?></th>

                                    <th><?php echo $total_normal_ot; ?></th>
                                    <th><?php echo $total_special_ot; ?></th>


                                </tfoot>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <?php } ?>
                    <!-- /.box -->
                </div>

                <div class="col-md-6">
                    <?php if (isset($_GET['id'])) { ?>
                    <div class="box box-danger">
                        <div class="box-header">
                            <h3 class="box-title">Salary Advance List</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            <table id="example2" class="table table-bordered table-striped">

                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>Note</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                        $result = $db->prepare("SELECT * FROM salary_advance WHERE emp_id='$id' AND date BETWEEN '$d1' AND '$d2' ORDER BY id ASC");
                                        $result->bindParam(':userid', $date);
                                        $result->execute();
                                        for ($i = 0; $row = $result->fetch(); $i++) {
                                        ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['date'] ?></td>
                                        <td><?php echo $row['note']; ?></td>
                                        <td>Rs.<?php echo $row['amount']; ?></td>
                                    </tr>
                                    <?php    } ?>
                                </tbody>
                                <tfoot>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Rs.<?php echo number_format($adv, 2); ?></th>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <?php } ?>
                    <!-- /.box -->
                </div>
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
    <?php include_once("script.php"); ?>
    <!-- InputMask -->
    <script src="../../plugins/input-mask/jquery.inputmask.js"></script>
    <script src="../../plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="../../plugins/input-mask/jquery.inputmask.extensions.js"></script>

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

    <!-- date-range-picker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="../../plugins/daterangepicker/daterangepicker.js"></script>
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

    //Date range picker with time picker
    //$('#datepicker').datepicker({datepicker: true,  format: 'yyyy/mm/dd '});
    //Date range as a button
    $('#reservation').daterangepicker();

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