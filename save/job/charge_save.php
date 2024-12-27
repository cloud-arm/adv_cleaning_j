<?php
session_start();
include('../../config.php');

//echo $location_id = $_POST['location_id'];




// Initialize variables
$job_id = base64_encode($_POST['job_id']);
$note = $_POST['note'];
$price = $_POST['price'];
$mat_id = $_POST['mat_id'];


// Process each location ID
//foreach ($_POST['location_id'] as $id) {
  //  $username = select_item('holidays', 'name', 'id=' . $id, '../');

  $r1 = select_item('gen_extracharges','des','id='.$mat_id,'../../');

  echo $r1;

    // Prepare data for insertion
    $insertData = array(
        "data" => array(
            //"name" => $username,
            "project_id" => $_POST['job_id'],
            "r_id" => $mat_id,
            "recored" => $r1,
            "price" => $price,


            "note" => $note,

        ),
        "other" => array()
    );

    // Insert data into the "gen_shift" table
    $result = insert("gen_excharge_rec", $insertData, '../../');

    if (!$result) {
        die("Failed to save data for location ID: $id");
    }
// }

// Redirect to job view page
header("Location: ../../job_view.php?id=". base64_encode($job_id));
exit();
