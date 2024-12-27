<?php
session_start();
include('connect.php');
date_default_timezone_set("Asia/Colombo");
include('config.php');

function AddPlayTime($times)
{

    $minutes = 0; //declare minutes either it gives Notice: Undefined variable
    // loop thought all the times

    foreach ($times as $time) {
        list($hour, $minute) = explode('.', $time);
        $minutes += $hour * 60;
        $minutes += $minute;
    }

    $hours = floor($minutes / 60);
    $minutes -= $hours * 60;

    // returns the time already formatted
    return sprintf('%02d.%02d', $hours, $minutes);
}

function TimeSet($times)
{

    $minutes = 0;
    list($hour, $minute) = explode(".", $times);
    $minutes += $minute + $hour * 60;

    return $minutes / 60;
}


$date = $_POST['date']; // Retrieve the date range
echo $date;

if (!empty($date)) { 
    // Separate the two dates using explode
    list($start_date, $end_date) = explode("-", $date, 2); 
    $d1 = date("Y-m-d", strtotime(trim($start_date))); // Trim and format start date
    $d2 = date("Y-m-d", strtotime(trim($end_date)));   // Trim and format end date
}

// Output for verification
echo "Start Date: " . $d1 . "<br>";
echo "End Date: " . $d2;





$result1 = $db->prepare("SELECT * FROM employee");
$result1->bindParam(':userid', $res);
$result1->execute();
for ($i = 0; $row1 = $result1->fetch(); $i++) {
    $id = $row1['id'];
    $name = $row1['name'];
    $rate = $row1['rate'];
    $epf = $row1['epf_amount'];
    $well = $row1['well'];
    $well_amount = $row1['well'];

    $ot = 0;
    $hour = 0;
    $amount = 0;
    $ot_tot = 0;
    $ot_rate = 0;
    $ot_time = 0;
    $allowances = 0;
    $normal_ot = 0;
    $special_ot = 0;

    $r2 = select('holidays', '*', 'date = "' . $d1 . '"');
    for ($i = 0; $row = $r2->fetch(); $i++) {
        $holiday = $row['date'];

    }

    $result = $db->prepare("SELECT work_time,ot FROM attendance WHERE emp_id='$id' AND date BETWEEN '$d1' AND '$d2' ORDER BY id ASC");
    $result->bindParam(':userid', $date);
    $result->execute();
    for ($i = 0; $row = $result->fetch(); $i++) {
        $hour = $row['work_time'];
        $ot = $row['ot'];
        $dinner = $row['dinner'];
        $normal_ot = is_numeric($row['normel_ot']) ? $row['normel_ot'] : 0;
        $special_ot = is_numeric($row['special_ot']) ? $row['special_ot'] : 0;
    }

    $result = $db->prepare("SELECT count(id) FROM attendance WHERE emp_id='$id' AND date BETWEEN '$d1' AND '$d2' ");
    $result->bindParam(':userid', $date);
    $result->execute();
    for ($i = 0; $row = $result->fetch(); $i++) {
        $day = $row['count(id)'];
        $att_day = $row['count(id)'];

    }





    $result = $db->prepare("SELECT sum(amount) FROM hr_allowances WHERE emp_id='$id' AND date BETWEEN '$d1' AND '$d2' ");
    $result->bindParam(':userid', $date);
    $result->execute();
    for ($i = 0; $row = $result->fetch(); $i++) {
        $allowances = $row['sum(amount)'];
    }


    $commission = 0;
    //$result = $db->prepare("SELECT sum(commission) FROM sales JOIN job ON sales.invoice_number = job.invoice_no  WHERE job.type='Close' AND job.r_person = '$id' AND close_date BETWEEN '$d1' AND '$d2'");


    // ------------------------------------Check Advance
    if ($adv == '') {
        $adv = 0;
    }

    //--------------- OT Time -----------------// 
    //$ot_tot = ($rate * 142.86) / 100 * AddPlayTime($ot);

    //$ot_rate = ($rate * 142.86) / 100;
    //$ot_time = TimeSet($ot);

    //holyday
    
if(($holiday == $d1)){
    $h_price =  500; 

     } else { 
     $h_price =  0; 
     }

     //dinner 
     if(($dinner == "yes")){
       $d_price =  300;

         } else { 
$d_price =  0;
        } 
    //--------------- Worck hour -------------//
    $hour = AddPlayTime($hour);

    $basic = $rate * $day;

    $etf = $basic *3/100;
   // $day = TimeSet($hour);

    $amount = ($ot_tot + $basic + $allowances+$special_ot+$normal_ot+$d_price+$h_price) - $epf - $adv - $well;

    $empid = 0;
    $result = $db->prepare("SELECT * FROM hr_payroll WHERE emp_id ='$id' AND date='$date' ORDER BY id ASC");
    $result->bindParam(':userid', $date);
    $result->execute();
    for ($i = 0; $row = $result->fetch(); $i++) {
        $empid = $row['emp_id'];
    }

            $time = date('H:i:s');
            $sql = "INSERT INTO hr_payroll (name,emp_id,amount,date,time,day_pay,day_rate,ot,ot_rate,commis,advance,epf,day,ot_time,etf) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $q = $db->prepare($sql);
            $q->execute(array($name, $id, $amount, $date, $time, $basic, $rate, $ot_tot, $ot_rate, $allowances, $adv, $epf, $day, $ot_time, $epf / 8 * 3));


        
    
}


header("location: hr_payroll_print.php?id=1&date=$date");
