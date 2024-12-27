<?php
include 'connect.php'; // include your database connection
include 'config.php'; // include your config file

if (isset($_GET['id'])) {
    $id = $_GET['id'];


    echo $id;
    
    try {
        // Prepare the delete statement
        $stmt = $db->prepare("DELETE FROM gen_extracharges WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        // Redirect back to the list page after deletion
        header("Location: ../extra_charge_add.php");
    } catch (PDOException $e) {
        // Handle any errors
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
