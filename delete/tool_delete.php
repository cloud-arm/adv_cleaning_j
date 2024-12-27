<?php
include '../connect.php'; // include your database connection
include '../config.php'; // include your config file

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $r=select_item('tools','id','id='.$id,'../');
    $id=$r['id'];
    
    
    try {
        // Prepare the delete statement
        $stmt = $db->prepare("DELETE FROM tools WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        // Redirect back to the list page after deletion
        header("Location: ../tools.php");
    } catch (PDOException $e) {
        // Handle any errors
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
