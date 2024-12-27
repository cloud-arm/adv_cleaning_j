<?php
session_start();
include('connect.php');
date_default_timezone_set("Asia/Colombo");
include('config.php');

// Trim and ensure proper date format
$d1 = $_POST['date1'];
$d2 = $_POST['date2'] ;
$id = $_POST['id'];


if (!$d1 || !$d2) {
    die("Start and End dates are required.");
}

echo "Start Date: " . $d1 . "<br>";
echo "End Date: " . $d2;

// Fetch all employees
$result1 = $db->prepare("SELECT * FROM employee WHERE id = '$id'");
$result1->execute();

while ($row1 = $result1->fetch(PDO::FETCH_ASSOC)) {
    $name = $row1['name'];
    $rate = $row1['rate'];
    $epf = $row1['epf_amount'];
    $well = $row1['well'];
    $s_ot_rate = $row1['s_ot_rate'];
}

    // Initialize variables
    $ot_tot = 0;
    $allowances = 0;
    $normal_ot = 0;
    $special_ot = 0;
    $dinner = "no";
    $h_price = 0;
    $d_price = 0;

    $date = date('Y-m-d');
    $time = date('H:i:s');

    // Check if the start date is a holiday
    $r2 = $db->prepare("SELECT date FROM holidays WHERE date = ?");
    $r2->execute([$d1]);
    if ($holidayRow = $r2->fetch(PDO::FETCH_ASSOC)) {
        $holiday = $holidayRow['date'];
    } else {
        $holiday = null;
    }

    // Fetch attendance details
    $result = $db->prepare("SELECT * FROM attendance WHERE emp_id = ? AND date BETWEEN ? AND ? ORDER BY id ASC");
    $result->execute([$id, $d1, $d2]);
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $ot_tot += is_numeric($row['ot']) ? $row['ot'] : 0;
        $normal_ot += is_numeric($row['normel_ot']) ? $row['normel_ot'] : 0;
        $special_ot += is_numeric($row['special_ot']) ? $row['special_ot'] : 0;
        $dinner = $row['dinner'];

        $total_normal_ot += $normal_ot;
        $total_special_ot += $special_ot;
    }


    $result = $db->prepare("SELECT count(id) FROM attendance WHERE emp_id='$id' AND date BETWEEN '$d1' AND '$d2' ");
    $result->bindParam(':userid', $date);
    $result->execute();
    for ($i = 0; $row = $result->fetch(); $i++) {
        $day = $row['count(id)'];
        $att_day = $row['count(id)'];

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

    $ot1=$total_normal_ot*120;

    $ot2 = $total_special_ot*$s_ot_rate;
    // Calculate holiday price
    if(($holidays != 0)){
        $h_price =  500; 
        $h_price= $h_price*$holidays;
    
         } else { 
         $h_price =  0; 
         }

      //dinner 
      if(($dinner_count != 0)){
        $d_price =  300;

        $d_price = $d_price*$dinner_count;
 
          } else { 
            $d_price =  0;
         } 

    // Calculate basic pay
    $basic = $rate * $day;
    echo $basic;'-';


    $etf = $epf *3/8;


    // Total amount calculation
    $amount = ($basic + $allowances + $ot1 + $ot2 + $d_price + $h_price) - $epf - $well;

    // Insert into payroll
    $sql = "INSERT INTO hr_payroll (name, emp_id, amount, date, time, day_pay, day_rate, ot, ot_rate, commis, advance, epf, day, ot_time, etf,s_ot,n_ot) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)";
    $q = $db->prepare($sql);
    $q->execute([
        $name, 
        $id, 
        $amount, 
        $date, 
        $time, 
        $basic, 
        $rate, 
        $ot_tot, 
        $s_ot_rate, 
        $allowances, 
        0, // Assuming advance is not used in the calculation
        $epf, 
        $day, 
        $ot_tot, // Assuming OT time matches OT total
        $etf, /// ETF Calculation
        $special_ot,
        $normal_ot,
    ]);

    header("location: hr_payroll_print.php?id=$id&date=$date&d1=$d1&d2=$d2");


?>
