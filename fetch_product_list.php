<?php
include 'connect.php'; // Include your database connection

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Query to fetch product details from product_list based on product_id
    $stmt = $db->prepare("SELECT * FROM product_list WHERE product_id = ?");
    $stmt->execute([$product_id]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the result as JSON
    echo json_encode($data);
}
