<?php
session_start();
include('../config.php');

//echo $location_id = $_POST['location_id'];
echo $company_id = $_POST['company_id'];
echo $job_id = $_POST['job_id'];



// Initialize variables
$com_id = $_POST['company_id'];
$job_id = base64_encode($_POST['job_id']);
$note = $_POST['note'];
$price = $_POST['price'];
$employee_count = $_POST['employee_count'];


// Process each location ID
//foreach ($_POST['location_id'] as $id) {
  //  $username = select_item('holidays', 'name', 'id=' . $id, '../');

    // Prepare data for insertion
    $insertData = array(
        "data" => array(
            //"name" => $username,
            "company_id" => $com_id,
            "job_id" => $_POST['job_id'],
            "in_time" => $_POST['in_time'],
            "out_time" => $_POST['out_time'],
            "working_days" => implode(',', $_POST['w_days']),
            "note" => $note,
            "price" => $price,
            "employee_count" => $employee_count,
        ),
        "other" => array()
    );

    // Insert data into the "gen_shift" table
    $result = insert("gen_shift", $insertData, '../');

    if (!$result) {
        die("Failed to save data for location ID: $id");
    }
// }

// Redirect to job view page
//header("Location: ../../job_view.php?id=$job_id");
exit();
