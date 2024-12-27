<?php
include '../connect.php'; // include your database connection
include '../config.php'; // include your config file

$name = $_POST['value'];
$product_id = $_POST['product'];
$job_no = $_POST['job_no'];

echo $product_id;



   {

    $insertData = array(
        "data" => array(
            "name" =>$name,
            "product_id" => $product_id,
            "job_no" => $job_no,

        ),
        "other" => array(
        ),
    );
    
    // Insert the data into the sales_list table
   insert("sales_list_task", $insertData, '../');
   };

   header("Location:../add_tasks.php?id=" . ($job_no) . "&id2=" . ($product_id));
   exit(); // Always use exit() after a header redirect
   
    


?>