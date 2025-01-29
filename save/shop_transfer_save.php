<?php
session_start();
include('../config.php');
include('../connect.php');



$product_id=$_POST['product_id'];
$location1 = $_SESSION['USER_LOCATION'];
$unit=$_POST['unit'];
$qty=$_POST['qty'];
if($unit_id==0){
    $unit=select_item('materials','unit','id='.$product_id,'../');
}else{
    $unit= select_item('unit_record','unit','id='.$unit_id,'../');
}
$invoice=$_POST['invoice'];

echo $invoice;



$insertData = array(
    "data" => array(
        "name" => select_item('stock','name',"product_id='$product_id'",'../'),
        "mat_id" => $product_id,
        "store_location" => $location1,
        "invoice_no" => $invoice,
        "qty" => $qty,
        "unit" => $unit,
        "date"=>date("Y-m-d"),
    ),
    "other" => array(
    ),
);
$result=insert("shop_shere_items", $insertData,'../');


echo $result['status'];
header("location: ../shop_shere.php?id=$invoice");
