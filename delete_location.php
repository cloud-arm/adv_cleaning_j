<?php
include 'connect.php'; // include your database connection
include 'config.php'; // include your config file

if (isset($_GET['id'])) {
    $location_id = $_GET['id'];

    $r=select_item('location','company_id','id='.$location_id);
    $id=$r['company_id'];
    
    
    try {
        // Prepare the delete statement
        $stmt = $db->prepare("DELETE FROM location WHERE id = :id");
        $stmt->bindParam(':id', $location_id);
        $stmt->execute();
        
        // Redirect back to the list page after deletion
        header("Location: company_view.php?id=$id");
    } catch (PDOException $e) {
        // Handle any errors
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
