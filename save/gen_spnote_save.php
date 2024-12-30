<?php
session_start();
include('../config.php');

//echo $location_id = $_POST['location_id'];




// Initialize variables
$des = $_POST['des'];


// Process each location ID
//foreach ($_POST['location_id'] as $id) {
  //  $username = select_item('holidays', 'name', 'id=' . $id, '../');

  $r1 = select_item('gen_extracharges','des','id='.$mat_id,'../');

  echo $r1;

    // Prepare data for insertion
    $insertData = array(
        "data" => array(
            "name" => $des,





        ),
        "other" => array()
    );

    // Insert data into the "gen_shift" table
    $result = insert("gen_special_note", $insertData, '../');

    if (!$result) {
        die("Failed to save data for location ID: $id");
    }
// }

// Redirect to job view page
header("Location:../gen_spnote_add.php");
exit();
