<?php
session_start();
include('../../config.php');

$id = $_GET['id'];
//echo $id;

// Fetch the current data from the sales_list
$result = select('sales_list', '*', 'job_no=' . $id, '../../');

if ($result) {
    $row = $result->fetch();
    if ($row) {
        $product_id = $row['product_id'];
        $location_id = $row['location_id'];
        $product_name = $row['name'];
        //$job_no = $row['job_no'];
       $s_id = $row['id'];
    }
}

// Get the approval note from POST
///$approve_note = isset($_POST['note']) ? htmlspecialchars($_POST['note'], ENT_QUOTES, 'UTF-8') : '';  // Sanitize special characters
 
// Handle document upload
$approvel_doc = '';
if (isset($_FILES['document']) && $_FILES['document']['error'] == 0) {
    $allowedTypes = ['pdf', 'jpg', 'jpeg', 'png'];  // Allowed file extensions
    $file = $_FILES['document'];
    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);

    // Check if the file type is allowed
    if (in_array(strtolower($fileExtension), $allowedTypes)) {
        $uploadDir = '../../app/save/uploads/product_img/';  // Directory where files will be saved (adjust as needed)
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);  // Create the directory if it doesn't exist
        }


        // Create a unique file name
        $fileName = date('ymdHis') . '.' . $fileExtension;
        $filePath = $uploadDir . $fileName;

        //echo $fileName;

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            $approvel_doc = $fileName;  // Save the file name to be stored in the database
        } else {
            echo "<script>alert('Failed to upload document.');</script>";
        }
    } else {
        echo "<script>alert('Invalid file type. Only PDF, JPG, JPEG, and PNG are allowed.');</script>";
    }
}

// Prepare the data to update in the sales_list table
/*$updateData = [
    'status' => 'printing',
    'approvel_note' => $approve_note
];
*/
echo $approvel_doc;

// If a document was uploaded, include it in the update
if (!empty($approvel_doc)) {
    $updateData['approvel_doc'] = $approvel_doc;
}

// Update the sales_list table
//$result = update('sales_list', $updateData, 'id=' . $id, '../../');

$insertData = array(
    "data" => array(
        "type" =>'approve_img',
        "job_no" => $id,
        "source_id" => $id,
        "date" => date('Y-m-d'),
        "time" => date('H.i.s'),
        "name" => $approvel_doc, //photo need to be save this colomn
        "action" => '',

    ),
    "other" => array(
    ),
);
$result=insert("img_hub", $insertData,'../../');
//echo $result['massage'];



if ($result) {
    // Success message
    echo "<script>alert('Approved successfully!');</script>";
} else {
    // Error message
    echo "<script>alert('Failed to update status.');</script>";
}

// Redirect back to the job summary page
echo "<script>window.location.href = ' ../../job_view.php?id=" . base64_encode($id)."';</script>";
//header("location: ../../job_view.php?id=" . base64_encode($id));

exit;
?>
