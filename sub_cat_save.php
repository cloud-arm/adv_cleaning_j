<?php
session_start();
include('config.php');
include('connect.php');


$product_id=$_POST['product'];
$value=$_POST['value'];

echo $product_id;

$product_name=select_item('products','product_name','id='.$product_id,'');
//$unit=select_item('unit','name','id='.$unit_id,'../');


$insertData = array(
    "data" => array(
        "name" => $value,
        "product_id" => $product_id,
        "product_name"=>$product_name,
    ),
    "other" => array(
    ),
);
$result=insert("product_list", $insertData,'');


//print_r( $result);
header("location:sub_cat.php");

?>