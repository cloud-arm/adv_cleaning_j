<?php
session_start();
include('../config.php');
include('../connect.php');

$id=$_POST['id'];
$id2=$_POST['id2'];
$name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
$category=$_POST['category'];
//$qty= floatval ($_POST['qty']);
//$unit_price= floatval ($_POST['unit_price']);
//$code=$_POST['code'];
//$re_order=$_POST['re_order'];

echo $id2;
echo $id;

//echo  $unit_id;

if($id2 == '0'){
    $result = update('tools', 
    [
     'name' => $name ,
    // 'category' => $category

    ], 'id='.$id, '../');
}
else{

$insertData = array(
    "data" => array(
        "name" => $name,
      // "open_stock" => $open_stock,
        "category_name" => select_item("tools_category", "name", "id=".$category,'../'),
        "category_id" => $category,

      // "available_qty" => $qty,
       // "unit_id" => $unit_id,
       // "unit" => $unit,
    ),
    "other" => array(
    ),
);
$result=insert("tools", $insertData,'../');
}

echo $result['status'];
header("location: ../tools");

?>