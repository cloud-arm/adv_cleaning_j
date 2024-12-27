<?php
session_start();
include('../config.php');
include('../connect.php');

$id=$_POST['id'];
$name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
$date=$_POST['date'];
//$qty= floatval ($_POST['qty']);
//$unit_price= floatval ($_POST['unit_price']);
//$code=$_POST['code'];
//$re_order=$_POST['re_order'];

echo $id;

//echo  $unit_id;



$insertData = array(
    "data" => array(
        "name" => $name,
      // "open_stock" => $open_stock,
        "date" => $date,

      // "available_qty" => $qty,
       // "unit_id" => $unit_id,
       // "unit" => $unit,
    ),
    "other" => array(
    ),
);
$result=insert("holidays", $insertData,'../');


echo $result['status'];
header("location: ../holidays");

?>