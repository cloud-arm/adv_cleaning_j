<?php
session_start();
include('connect.php');
include('config.php');

$name = $_POST['name'];
$contact = $_POST['contact'];
$nic = $_POST['nic'];
$address = $_POST['address'];
$des_id = $_POST['des'];
$group_id = $_POST['group'];
$epf_no = $_POST['epf_no'];
$epf_amount = $_POST['epf_amount'];
$rate = $_POST['rate'];
$id = $_POST['id'];
$ot = $_POST['ot'];
$well = $_POST['well'];
$username = $_POST['nikname'];
$pin = $_POST['pin'];

if (isset($_POST['rem_ref'])) {
    $rem_ref = $_POST['rem_ref'];
} else {
    $rem_ref = 0;
}
if (isset($_POST['mech'])) {
    $mech = $_POST['mech'];
} else {
    $mech = 0;
}
if (isset($_POST['tin'])) {
    $tin = $_POST['tin'];
} else {
    $tin = 0;
}
if (isset($_POST['fib_pls'])) {
    $fib_pls = $_POST['fib_pls'];
} else {
    $fib_pls = 0;
}
if (isset($_POST['paint'])) {
    $paint = $_POST['paint'];
} else {
    $paint = 0;
}
if (isset($_POST['cut_polis'])) {
    $cut_polis = $_POST['cut_polis'];
} else {
    $cut_polis = 0;
}

$result = $db->prepare("SELECT * FROM Employees_des WHERE id='$des_id'");
$result->bindParam(':userid', $res);
$result->execute();
for ($i = 0; $row = $result->fetch(); $i++) {
    $des = $row['name'];
    $type = $row['type'];
}

$result = $db->prepare("SELECT * FROM Employees_group WHERE id='$group_id'");
$result->bindParam(':userid', $res);
$result->execute();
for ($i = 0; $row = $result->fetch(); $i++) {
    $group = $row['name'];
}


$sql = "UPDATE Employees 
        SET name=?,address=?,nic=?,phone_no=?,hour_rate=?,des=?,epf_amount=?,epf_no=?,ot=?,well=?,type=?,
        rem_ref=?, mechanic=?, tink_dent=?, fiber_plast=?, paint=?, cut_polish=?,username=?, des_id=?,pin=?, group_id=?,group_name=?
		WHERE id=?";
$q = $db->prepare($sql);
$q->execute(array($name, $address, $nic, $contact, $rate, $des, $epf_amount, $epf_no, $ot, $well, $type, $rem_ref, $mech, $tin, $fib_pls, $paint, $cut_polis, $username, $des_id, $pin, $group_id, $group, $id));


header("location: hr_employee_profile.php?id=$id");
