<?php
session_start();
include('../config.php');
include('../connect.php');

$id=$_POST['id'];
$s_no=$_POST['s_no'];
$description = htmlspecialchars($_POST['note'], ENT_QUOTES, 'UTF-8');

echo $id;



    $result = update('tools_list', 
    [
     'note' => $description,
     'serial_no' => $s_no,
    ], 'id='.$id, '../');


    $re = select('tools_list', '*', 'id=' . $id , '../');
    $user_name = ''; // Initialize the variable to check later
    
    while ($row = $re->fetch()) {

        $tool_id=$row['tool_id'];
    }







echo $result['status'];
header("location: ../tool_list.php?id=$tool_id");

?>