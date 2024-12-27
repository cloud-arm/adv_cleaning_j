<?php

session_start();
include('config.php');

$id = $_POST['id'];
$name = $_POST['name'];
$address = $_POST['address'];
$email = $_POST['email'];

echo $id;

// Perform the update operation
$result = update('company', ['name' => $name, 'address' => $address, 'email' => $email], 'id=' . $id, '');

// Check if the update was successful
if ($result) {
    // If successful, show an alert message
    echo "<script>
            alert('Company details updated successfully!');
            window.location.href='company.php';
          </script>";
} else {
    // In case of failure, show an error message
    echo "<script>
            alert('Error updating company details. Please try again.');
            window.location.href='company.php';
          </script>";
}

?>
