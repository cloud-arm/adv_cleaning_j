<?php
session_start();
include('../config.php');
include('../connect.php');

$id=$_GET['id'];
$rese_location = $_POST['rese_location'];


echo $id;



    $result = update('gate_pass', 
    [
     'action' => 'in',
     'location_id'=>'1',
        'stored_location'=>$rese_location

    ], 'id='.$id, '../');










echo $result['status'];
header("location: ../gate_pass");

?>