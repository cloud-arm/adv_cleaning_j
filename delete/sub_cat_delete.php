<?php
include '../connect.php'; // include your database connection
include '../config.php'; // include your config file

if (isset($_GET['id'])) {
    $unit_id = $_GET['id'];
   // $job_no = $_GET['job'];
   // $product_id = $_GET['pro'];




    
    
    try {
        // Prepare the delete statement
        $stmt = $db->prepare("DELETE FROM product_list WHERE id = :id");
        $stmt->bindParam(':id', $unit_id);
        $stmt->execute();
        
        // Redirect back to the list page after deletion
        header("Location: ../sub_cat.php");

    } catch (PDOException $e) {
        // Handle any errors
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
