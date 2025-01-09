<?php
session_start();
include('../config.php');

//echo $location_id = $_POST['location_id'];




// Initialize variables
$job_id = ($_POST['job_id']);
$confident = $_POST['confident'];

$company_id = $_POST['company_id'];



// Process each location ID
//foreach ($_POST['location_id'] as $id) {
  //  $username = select_item('holidays', 'name', 'id=' . $id, '../');



    // Prepare data for insertion
    $insertData = array(
        "data" => array(
            //"name" => $username,
            "job_no" => $job_id,
            "name" => $confident,
  
            "com_id" => $company_id,





        ),
        "other" => array()
    );

    // Insert data into the "gen_shift" table
    $result = insert("gen_confident", $insertData, '../');



    if (!$result) {
        die("Failed to save data for location ID: $id");
    }
// }

echo $job_id;
header("Location: ../job_view.php?id=" . base64_encode($job_id));



exit();
