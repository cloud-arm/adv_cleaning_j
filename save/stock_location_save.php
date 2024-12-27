<?php
session_start();
include('../config.php');
include('../connect.php');


$name = isset($_POST['name']) ? $_POST['name'] : '';






$insertData = array(
    "data" => array(
        "location" => $name,

    ),
    "other" => array(
    ),
);
$result=insert("stock_location", $insertData,'../');


//print_r( $result);
header("location: ../gate_pass.php");

?>