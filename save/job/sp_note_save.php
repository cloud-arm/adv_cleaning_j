<?php
session_start();
include('../../config.php');

// Retrieve form data
$job_id = $_POST['job_id'];
$selected_notes = isset($_POST['notes']) ? $_POST['notes'] : [];

// Generate a unique invoice number

// Prepare required data
$project_name = select_item('project', 'name', 'id=' . $job_id, '../../');

// Insert special notes into the `gen_special_note_rec` table
foreach ($selected_notes as $note_id) {
    $note_name = select_item('gen_special_note', 'name', 'id=' . $note_id, '../../');
    $insertData = array(
        "data" => array(
            "project_id" => $job_id,
            "project_name" => $project_name,
            "note_id" => $note_id,
            "name" => $note_name,
            "date" => date('Y-m-d'),
            "time" => date('H.i.s'),
        ),
        "other" => array(),
    );
    $result = insert("gen_special_note_rec", $insertData, '../../');
}

// Redirect to the job view page with the encoded project ID
$id = base64_encode($job_id);
header("location: ../../job_view.php?id=$id");
exit();
