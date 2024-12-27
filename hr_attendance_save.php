<?php
session_start();
include('connect.php');
include('config.php');
date_default_timezone_set("Asia/Colombo");

$time = date('H.i');

$id = $_POST['id'];
$date = $_POST['date'];
$in_time = $_POST['in_time'];
$out_time = $_POST['out_time'];
$outdate = $_POST['date2'];

function AddPlayTime($times)
{
    $minutes = 0;
    foreach ($times as $time) {
        list($hour, $minute) = explode('.', $time);
        $minutes += $hour * 60;
        $minutes += $minute;
    }

    $hours = floor($minutes / 60);
    $minutes -= $hours * 60;

    return sprintf('%02d.%02d', $hours, $minutes);
}

function TimeSet($times)
{
    list($hour, $minute) = explode(".", $times);
    $minutes = $minute + ($hour * 60);

    return $minutes / 60;
}

if ($outdate > $date) {
    $out_time = 24.00 + $out_time;
}

$result = $db->prepare("SELECT * FROM employee WHERE id = :userid");
$result->bindParam(':userid', $id);
$result->execute();
$row = $result->fetch();
$name = $row['name'];

$s_ot = 0;
$n_ot = 0;

if ($in_time < 8) {
    $in_ti = "8.00";
} else {
    $in_ti = $in_time;
}
$out_ti = $out_time;

list($out_h, $out_m) = explode('.', $out_ti);
list($in_h, $in_m) = explode('.', $in_ti);

$deff_h = $out_h - $in_h;
$deff_m = $out_m - $in_m;
if ($deff_m < 0) {
    $deff_m += 60;
    $deff_h -= 1;
}

$deff = $deff_h . "." . sprintf("%02d", $deff_m);

if ($deff_h >= 10) {
    $work_time = '10.00';
} else {
    $work_time = $deff;
}

if ($deff_h < 10) {
    $ot = '0.00';
} else {
    $wh = 10;
    $ot_h = $deff_h - $wh;
    $ot_m = $deff_m;
    $ot = $ot_h . '.' . sprintf("%02d", $ot_m);
}

if ($out_time >= 18.30 && $out_time <= 22.30) {
    $n_ot = AddPlayTime([sprintf('%02d.%02d', floor($out_time - 18.30), ($out_time - 18.30) * 60 % 60)]);
}

if ($out_time >= 22.30 && $out_time <= 30.00) {
    $n_ot = AddPlayTime(["04.00"]); // 22.30 - 18.30 is constant
    $s_ot = AddPlayTime([sprintf('%02d.%02d', floor($out_time - 22.30), ($out_time - 22.30) * 60 % 60)]);
}

if ($out_time > 24.00) {
    $tea = 'yes';
} else {
    $tea = 'no';
} 

if ($out_time > 20.00) {
    $dinner = 'yes';
} else {
    $dinner = 'no';
}

$ot = AddPlayTime([$n_ot, $s_ot]);

$sql = "INSERT INTO attendance (emp_id, name, date, time, IN_time, OUT_time, deff_time, ot, work_time, normel_ot, special_ot, dinner, out_date, tea) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$q = $db->prepare($sql);
$q->execute(array(
    $id, $name, $date, $time, $in_time, $out_time, $deff, $ot, $work_time, 
    $n_ot, $s_ot, $dinner, $outdate, $tea
));


$givendate= $date;
$MyGivenDateIn = strtotime($date);
$ConverDate = date("l", $MyGivenDateIn);
$ConverDateTomatch = strtolower($ConverDate);
echo $ConverDateTomatch;
if(($ConverDateTomatch == "sunday")){
    echo "This is a weekend date";

    $result = update(
        'attendance',
        [
            'weekend' => 'sunday',
        ],
        'emp_id = ' . $id . ' AND date = "' . $givendate . '"'
    );
    
} else {
    echo "This is no weekend date";
}

$r2 = query("SELECT * FROM holidays WHERE date = '$date'"); 
for ($i = 0; $row = $r2->fetch(); $i++) {
    $holiday = $row['date'];
    echo $holiday;
    echo $date;
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



header("location: hr_attendance.php");

?>