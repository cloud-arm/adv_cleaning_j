<?php
include 'connect.php'; // Include your database connection setup
include 'config.php'; // Include your configuration file

if (isset($_GET['mat_id'])) {
    $product_id = $_GET['mat_id'];

    // Query to get the sell price for the selected product
    $query = $db->prepare("SELECT sell FROM stock WHERE product_id = ? AND location = 'shop'");
    $query->execute([$product_id]);

    if ($row = $query->fetch()) {
        echo $row['sell'];
    } else {
        echo "0"; // Default value if no sell price is found
    }
}
?>