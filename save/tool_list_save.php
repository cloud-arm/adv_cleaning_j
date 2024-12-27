<?php
session_start();
include('../config.php');
include('../connect.php');

$id=$_POST['id'];
$name = htmlspecialchars($_POST['des'], ENT_QUOTES, 'UTF-8');
$s_no=$_POST['s_no'];
$qty= floatval ($_POST['qty']);
$value= floatval ($_POST['value']);

echo $id;


/*
if($id2 == '0'){
    $result = update('tools', 
    [
    'name' => $name ,
     'category' => $category,
     'unit_price' => $unit_price,
     'code' => $code ,
     're_order' => $re_order, 
     'available_qty' => $qty,
     'unit_id'=> $unit_id,
     'unit' => $unit
    ], 'id='.$id, '../');
}
else
*/

$insertData = array(
    "data" => array(
        "note" => $name,
      // "open_stock" => $open_stock,
        "tool_name" => select_item("tools", "name", "id=".$id,'../'),
        "tool_id" => $id,
        "serial_no" => $s_no,
        "value" => $value,
        "qty" => $qty,
       // "unit_id" => $unit_id,
       // "unit" => $unit,
    ),
    "other" => array(
    ),
);
$result=insert("tools_list", $insertData,'../');

$old_qty = select_item('tools', 'qty', 'id='.$id, '../');
$old_value = select_item('tools', 'value', 'id='.$id, '../');


$result = update('tools', 
[
    'qty' => $old_qty + $qty, // This will add $qty to the existing qty in the database
    'value' => $old_value + $value, // This will add $value to the existing value in the database


], 'id='.$id, '../');



echo $result['status'];
header("location: ../tool_list.php?id=$id");

?>