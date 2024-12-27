<?php
session_start();
include('connect.php');
include('config.php');

$id = $_POST['id'];
$username = date('ymdhis');

$img_path = save_image($username, $_FILES["image"]["name"], "user_pic/");

$msg = $img_path['status'];

if ($msg == 'success') {
    $sql = "UPDATE Employees  SET pic=? WHERE id=?";
    $q = $db->prepare($sql);
    $q->execute(array($img_path['path'], $id));
}

header("location: hr_employee_profile.php?id=$id&$msg");
