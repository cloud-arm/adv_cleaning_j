<?php
include '../connect.php'; // include your database connection
include '../config.php'; // include your config file

if (isset($_GET['id'])) {
    $id = $_GET['id'];

     $result = select('tools_list','*', 'id=' . $id , '../');
    for ($i = 0; $row = $result->fetch(); $i++) {
        $tool_id = $row['tool_id']; 
        $Qty = $row['qty']; 
    }   
    
    try {
        // Prepare the delete statement
        $stmt = $db->prepare("DELETE FROM tools_list WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        // Redirect back to the list page after deletion
        header("Location: ../tool_list.php?id=$tool_id");
    } catch (PDOException $e) {
        // Handle any errors
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
