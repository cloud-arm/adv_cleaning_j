<!DOCTYPE html>
<html>

<head>
    <?php
    include("connect.php");

    $invo = $_GET['id'];
    $co = substr($invo, 0, 2);
    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CLOUD ARM | Invoice</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <style>
        body {
            font-family: 'Poppins';
        }
    </style>
</head>

<body onload="window.print() "  style=" font-size: 13px; font-family: 'Poppins';">

    <div class="wrapper">

        <!-- Main content -->
        <section class="invoice">


            <?php $oth_ded = 0.00;



            $ids = $_GET["id"];
            $date = $_GET["date"];
            $result = $db->prepare("SELECT * FROM hr_payroll WHERE emp_id ='$ids' AND date='$date' ORDER BY id ASC");
            $result->bindParam(':userid', $date);
            $result->execute();
            for ($i = 0; $row = $result->fetch(); $i++) {
                $id = $row['emp_id'];
                $adv = isset($row['advance']) ? $row['advance'] : 0;
                $amount = $row['amount'];
                $rate = $row['day_rate'];
                $s_ot = isset($row['s_ot']) ? $row['s_ot'] : 0;
                $n_ot = isset($row['n_ot']) ? $row['n_ot'] : 0;
                $epf = $row['epf'];
                $etf = $row['etf'];
            }

            $d1 = $_GET['d1'];
            $d2 = $_GET['d2'] ;
            $h = 0;
            $m = 0;
            $result = $db->prepare("SELECT work_time,ot FROM attendance WHERE emp_id='$id' AND date BETWEEN '$d1' AND '$d2' ORDER BY id ASC");
            $result->bindParam(':userid', $date);
            $result->execute();
            for ($i = 0; $row = $result->fetch(); $i++) {
                $hour = $row['work_time'];
                $ot = $row['ot'];
            }

            $result = $db->prepare("SELECT count(id) FROM attendance WHERE emp_id='$id' AND date BETWEEN '$d1' AND '$d2' ORDER BY id ASC");
            $result->bindParam(':userid', $date);
            $result->execute();
            for ($i = 0; $row = $result->fetch(); $i++) {
                $day = $row['count(id)'];
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

            $result = $db->prepare("SELECT * FROM employee WHERE id='$id' ");
            $result->bindParam(':userid', $date);
            $result->execute();
            for ($i = 0; $row = $result->fetch(); $i++) {
                $name = $row['name'];
                // $rate=$row['hour_rate'];
                $epf_no = $row['epf_no'];
              //  $epf = $row['epf_amount'];
                $epf_8 = $row['epf_amount'];
                $basic = $row['basic'];
                $well = $row['well'];
                $s_ot_rate = $row['s_ot_rate'];
            }

            ?>
            <h2 align="center">SALARY SLIP</h2>

            <?php

            $invo = $_GET['id'];
            $tot_amount = 0;
            $result = $db->prepare("SELECT sum(dic) FROM sales_list WHERE   invoice_no='$invo'");
            $result->bindParam(':userid', $date);
            $result->execute();
            for ($i = 0; $row = $result->fetch(); $i++) {
                $dis_tot = $row['sum(dic)'];
            }
            ?>
            <div class="box-body">

                <div>

                    <div class="pull-right" style="width: 48%; ">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <td>ATTENDANCE DAYS</td>
                                    <td align="right"><?php echo $day; ?></td>
                                </tr>

                                <tr>
                                    <td>Day Rate</td>
                                    <td align="right">Rs.<?php echo number_format($rate, 2); ?></td>
                                </tr>
                            </tbody>


                            <thead>
                                <tr style="font-size: 16px;font-weight: 600;">
                                    <th align="left">Earnings</th>
                                    <th align="right">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Basic</td>
                                    <?php echo $day?>
                                    <td align="right">Rs.<?php $basic = $rate * $day;
                                                            echo number_format($basic, 2) ?></td>
                                </tr>
<?php         //    $epf_8 = $basic * 8 / 100; ?>

                                <tr>
                                    <td>S:OT</td>
                                    <td align="right">Rs.<?php $s_ot =number_format($total_special_ot,2)*$s_ot_rate;
                                                            echo number_format($s_ot, 2); ?></td>
                                </tr>
                                <tr>
                                    <td>N:OT</td>
                                    <td align="right">Rs.<?php $n_ot =number_format($total_normal_ot,2)*120;
                                                            echo number_format($n_ot, 2); ?></td>
                                </tr>
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



                                <?php $allowances = 0;
                                $result = $db->prepare("SELECT * FROM hr_allowances WHERE emp_id='$id' AND date BETWEEN '$d1' AND '$d2' ORDER BY id ASC");
                                $result->bindParam(':userid', $date);
                                $result->execute();
                                for ($i = 0; $row = $result->fetch(); $i++) { ?>


                                <?php //$allowances += $row['amount'];
                                } ?>

                                <tr style="font-size: 15px;font-weight: 600;">
                                    <td align="right">Total</td>
                                    <td align="right">Rs.<?php $er_tot = $basic + $s_ot  + $n_ot + $s_price + $h_price + $d_price + $t_price;
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


                            <thead>
                                <tr style="font-size: 16px;font-weight: 600;">
                                    <th align="left">Deductions</th>
                                    <th align="right"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>EPF - 8%</td>
                                    <td align="right">Rs.<?php  echo number_format($epf_8, 2); ?></td>
                                </tr>


                                <tr>
                                    <td>Advance/Loan</td>
                                    <td align="right">Rs.<?php echo number_format($adv, 2); ?></td>
                                </tr>

                                <tr>
                                    <td>Other Deduction</td>
                                    <td align="right"><?php echo number_format($oth_ded, 2); ?></td>
                                </tr>

                                <tr style="font-size: 15px;font-weight: 600;">
                                    <td align="right">Total</td>
                                    <td align="right">Rs.<?php $de_tot =     $oth_ded + $epf_8;
                                                            echo number_format($de_tot, 2); ?></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr style="font-size: 15px;font-weight: 600;">
                                    <td align="right">NET Salary</td>
                                    <td align="right">Rs.<?php echo number_format($er_tot-$de_tot, 2); ?></td>
                                </tr>
                            </tfoot>

                            <tbody>
                                <tr>
                                    <td>EPF - 12%</td>
                                    <td align="right">Rs.<?php $epf_12 = $basic * 12 / 100;
                                                            echo number_format($epf_12, 2); ?></td>
                                </tr>

                                <tr>
                                    <td>ETF - 3%</td>
                                    <td align="right">Rs.<?php $etf = $basic * 3 / 100;
                                                            echo number_format($etf, 2); ?></td>
                                </tr>

                                <tr style="font-size: 15px;font-weight: 600;">
                                    <td align="right">Total</td>
                                    <td align="right">Rs.<?php $oth_tot = $epf_12 + $etf;
                                                            echo number_format($oth_tot, 2) ?></td>
                                </tr>
                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>


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
                                            <th>DATE</th>
                                            <th>AMOUNT</th>
                                            <th>NOTE</th>
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
                                                <td>Rs.<?php echo  $row['amount']; ?></td>
                                                <td><?php echo $row['note']; ?></td>

                                            <?php    } ?>
                                            </tr>
                                    </tbody>
                                    <tfoot>
                                        <th></th>
                                        <th></th>
                                        <th>Rs.<?php echo number_format($adv, 2); ?></th>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>

                    <div style="width:48%;">
                        <h2>ADVANCE CLEANING</h2>
                        <H5>No.57, Bodi Mawatha, Tangalle</H5>
                        <h4>Employee Name : <?php echo $name; ?></h4>
                        <h4>EPF No. :<?php echo $epf_no; ?></h4>
                        <h3><?php echo $_GET['date'] ?></h3>

                        <!-- /.box-header -->

                        <div class="box-body">
                            <table id="example2" class="table table-bordered table-striped">

                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>DATE</th>
                                        <th>IN</th>
                                        <th>OUT</th>
                                        <th>DAY</th>
                                        <th>N:OT</th>
                                        <th>S:OT</th>

                                    </tr>

                                </thead>

                                <tbody>
                                    <?php
                                                                                $total_normal_ot = 0;
                                                                                $total_special_ot = 0;
                                                                             $ot = array();
                                        $result = $db->prepare("SELECT * FROM attendance WHERE emp_id='$id' AND date BETWEEN '$d1' AND '$d2' ORDER BY id ASC");
                                        $result->bindParam(':userid', $date);
                                    $result->execute();
                                    for ($i = 0; $row = $result->fetch(); $i++) {
                                      $normal_ot = is_numeric($row['normel_ot']) ? $row['normel_ot'] : 0;
                                      $special_ot = is_numeric($row['special_ot']) ? $row['special_ot'] : 0;
                                      $total_normal_ot += $normal_ot;
                                      $total_special_ot += $special_ot;
                                    ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['date'] ?></td>
                                            <td><?php echo $row['IN_time']; ?></td>
                                            <td><?php echo $row['OUT_time']; ?></td>
                                            <td><?php echo $row['work_time']; ?></td>
                                            <td><?php echo $row['normel_ot']; ?></td>
                                            <td><?php echo $row['special_ot']; ?></td>


                                        <?php    } ?>
                                        </tr>
                                </tbody>
                                <tfoot>
                                <tfoot>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>


                                    <th><?php echo $hour; ?></th>

                                    <th><?php echo $total_normal_ot; ?></th>
                                    <th><?php echo $total_special_ot; ?></th>

                                </tfoot>
                            </table>
                        </div>

                        <!-- /.box -->
                    </div>

                </div>
                <br><br><br><br><br><br><br><br><br>
                <h4 align="center">AUTHORIZED</h4>
            </div>
    </div>
    </section>

</body>

</html>