<?php
session_start();
include('../connect.php');
include('../config.php');

$u = $_SESSION['SESS_MEMBER_ID'];

$invo = $_POST['id'];
$type = $_POST['type'];
$qty = $_POST['qty']; // Ensure qty is an integer
$id2 = $_POST['id2'];
$pro = $_POST['pr'];
$unit_id = $_POST['unit'];

if ($unit_id == 0) {
    $unit = select_item('materials', 'unit', 'id=' . $pro, '../');
} else {
    $unit = select_item('unit_record', 'unit', 'id=' . $unit_id, '../');
}

$dic = 0; // Discount initialized to 0
$stock = 0; // Default stock value

// Fetch product details securely
$result = $db->prepare("SELECT * FROM materials WHERE id = :id");
$result->execute([':id' => $pro]);



$product = $result->fetch();
if (!$product) {
    die("Product not found");
}
    

$pro_name = $product['name'];
$available_qty = $product['available_qty'];
$sell_price = $product['unit_sall_price'];
$unit_price = $product['unit_price'];

/*

$available_qty -= $qty;
if ($available_qty < 0) {
    echo "<script>
        alert('Insufficient stock');
        window.location.href = 'shop.php';
    </script>";
    exit; // Stop further execution of the script
}
*/
$amount = $sell_price * $qty;
$date = date("Y-m-d");

// Update the stock quantity in the database
$updateAmount = $db->prepare("UPDATE materials SET available_qty = :qty WHERE id = :pro");
$updateAmount->execute([
    ':qty' => $available_qty,
    ':pro' => $pro
]);

// Insert the sales record into the shop_sales_list table
$sql = "INSERT INTO shop_sales_list (invoice_no, name, qty, date, product_id, sell, type, user_id, stock_id, amount, unit, unit_id) 
        VALUES (:invoice_no, :name, :qty, :date, :product_id, :sell, :type, :user_id, :stock_id, :amount, :unit, :unit_id)";
$re = $db->prepare($sql);
$re->execute([
    ':invoice_no' => $invo,
    ':name' => $pro_name,
    ':qty' => $qty,
    ':date' => $date,
    ':product_id' => $pro,
    ':sell' => $sell_price,
    ':type' => $type,
    ':user_id' => $u,
    ':stock_id' => $stock,
    ':amount' => $amount,
    ':unit' => $unit,
    ':unit_id' => $unit_id
]);

// Redirect to the shop page
header("Location: ../shop?id=" . ($invo));
exit;
?>
