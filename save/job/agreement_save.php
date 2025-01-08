<?php
session_start();
include('../../config.php');

//echo $location_id = $_POST['location_id'];




// Initialize variables
$job_id = ($_POST['job_id']);
$reg_no = $_POST['reg_no'];
$open_date = $_POST['open_date'];
$owner = $_POST['owner'];
$nic = $_POST['nic'];
$company = $_POST['company'];
$close_date = $_POST['close_date'];
$shift_type_id = $_POST['id2'];



// Process each location ID
//foreach ($_POST['location_id'] as $id) {
  //  $username = select_item('holidays', 'name', 'id=' . $id, '../');



    // Prepare data for insertion
    $insertData = array(
        "data" => array(
            //"name" => $username,
            "job_id" => $_POST['job_id'],
            "reg_no" => $reg_no,
            "owner" => $owner,
            "nic" => $nic,
            "company" => $company,
            "open_date" => $open_date,
            "close_date" => $close_date,



        ),
        "other" => array()
    );

    // Insert data into the "gen_shift" table
    $result = insert("gen_agreement", $insertData, '../../');

    if (!$result) {
        die("Failed to save data for location ID: $id");
    }
// }

echo $job_id;

// Redirect to job view page
if($shift_type_id==1){
    header("Location: ../print_agreement1.php?id=$job_id & type=1");
}else{
//header("Location: ../../job_view.php?id=$job_id");
}
exit();
