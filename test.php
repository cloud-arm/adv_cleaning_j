<?php
session_start();
include('connect.php');
include('config.php');
date_default_timezone_set("Asia/Colombo");

$time = date('H.i');

$id=$_POST['id'];
$date=$_POST['date'];
$in_time=$_POST['in_time'];
$out_time=$_POST['out_time'];
$outdate = $_POST['date2'];

if($outdate > $date){
    $out_time = 24.00 + $out_time;
}

//echo $id;

$result = $db->prepare("SELECT * FROM employee WHERE id ='$id' ");
$result->bindParam(':userid', $res);
$result->execute();
for($i=0; $row = $result->fetch(); $i++){ $name=$row['name'];}

$s_ot=0;
$n_ot=0;

if($in_time < 8){
    $in_ti="8.00";
}else{
    $in_ti=$in_time;
}
$out_ti=$out_time;	


list($out_h, $out_m) = explode('.', $out_ti);
list($in_h, $in_m) = explode('.', $in_ti);

$deff_h=$out_h-$in_h;
$deff_m=$out_m-$in_m;
if ($deff_m < 0) {$deff_m=$deff_m+60; $deff_h=$deff_h-1;}

$deff=$deff_h.".".sprintf("%02d",$deff_m);

if($deff_h >= 10){$work_time='10.00';}else{$work_time=$deff;}

if($deff_h<10){
    $wh=9;
    $wm=60;

    $ot_h=$deff_h-$wh;
    $ot_m=$wm-$deff_m;
    // $ot='-'.$ot_h.'.'.sprintf("%02d",$ot_m);
    $ot=0.00;
}
if($deff_h >= 10){
    $wh=10;

    $ot_h=$deff_h-$wh;
    $ot_m=$deff_m;

    $ot=$ot_h.'.'.sprintf("%02d",$ot_m);
}
if ($out_time >= 18.30 && $out_time <= 22.30) {
    $out_time=$out_time * 60*60;
    $nt=18.30*60*60;

    $n_ot = $out_time - $nt;
    $n_ot =$n_ot/3600;
    $out_time=$out_time/3600;


    
}

if ($out_time >= 22.30 && $out_time <= 30.00) {

    $r1= 22.30*60*60;
    $r2 =18.30*60*60;
    $out_time = $out_time*60*60;


    $n_ot = 22.30 - 18.30;

    $s_ot = $out_time - $r1;
    $s_ot1 = $s_ot%3600;
    $s_ot = $s_ot/3600;
echo $s_ot;

    if($s_ot1 > 60){
        $s_ot = $s_ot - 0.60+1.00;

    }
    $out_time = $out_time/3600;
    echo $s_ot;
}

if ($out_time > 24.00) {

    $tea = 'yes';
    
} else {
    $tea = 'no';
}

if ($out_time > 20.00) {

    $dinner = 'yes';
}else{
    $dinner = 'no';
}



$sql = "INSERT INTO attendance (emp_id,name,date,time,IN_time,OUT_time,deff_time,ot,work_time,normel_ot,special_ot,dinner,out_date,tea) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$q = $db->prepare($sql);
$q->execute(array($id,$name,$date,$time,$in_time,$out_time,$deff,$ot,$work_time,$n_ot,$s_ot,$dinner,$outdate,$tea));


$givendate= $date;
$MyGivenDateIn = strtotime($date);
$ConverDate = date("l", $MyGivenDateIn);
$ConverDateTomatch = strtolower($ConverDate);
//echo $ConverDateTomatch;
if(($ConverDateTomatch == "sunday")){
  //  echo "This is a weekend date";

    $result = update(
        'attendance',
        [
            'weekend' => 'sunday',
        ],
        'emp_id = ' . $id . ' AND date = "' . $givendate . '"'
    );
    
} else {
   // echo "This is no weekend date";
}

$r2 = query("SELECT * FROM holidays WHERE date = '$date'"); 
for ($i = 0; $row = $r2->fetch(); $i++) {
    $holiday = $row['date'];
   // echo $holiday;
   // echo $date;
    if($holiday === $date){
        $result = update(
            'attendance',
            [
                'special_date' => 'yes',
            ],
            'emp_id = ' . $id . ' AND date = "' . $date . '"'
        );
        
    } else {
        $result = update(
            'attendance',
            [
                'special_date' => 'no',
            ],
            'emp_id = ' . $id . ' AND date = "' . $date . '"'
        );
    }
}



//header("location: hr_attendance.php");

?>