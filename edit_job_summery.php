<?php

session_start();
include('config.php');

$id=$_POST['id'];
$width = $_POST['width'];
$height = $_POST['height'];
$note = htmlspecialchars($_POST['note'], ENT_QUOTES, 'UTF-8');
$art_note = htmlspecialchars($_POST['art_note'], ENT_QUOTES, 'UTF-8');
$about = htmlspecialchars($_POST['about'], ENT_QUOTES, 'UTF-8');


$result = update('sales_list', ['width' => $width , 'height' => $height,'note' => $note,'about' => $about,'art_note' => $art_note ,'sqrt'=> $height*$width], 'id='.$id, '');

header("location:job_summery.php?id=$id");

?>