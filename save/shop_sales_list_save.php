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


$result = select('materials', '*' , 'id='.$pro, '../');
while ($product = $result->fetch()) { 
    $pro_name = $product['name'];
    $available_qty = $product['available_qty'];
    $sell_price = $product['unit_sall_price'];
    $unit_price = $product['unit_price'];
}


echo $sell_price;
echo $unit_price;




$available_qty = $available_qty- $qty;
/*
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



$result = update('materials', 
[
 'available_qty' => $available_qty,

], 'id='.$pro, '../');




  // Prepare data for insertion
  $insertData = array(
    "data" => array(
        "invoice_no" => $invo,
        "name" => $pro_name,
        "qty" => $qty,
        "date" => $date,
        "product_id" => $pro,
        "sell" => $sell_price,
        "type" => $type,
        "user_id" => $u,
        "stock_id" => $stock,
        "amount" => $amount,
        "unit" => $unit,
        "unit_id" => $unit_id,

    ),
    "other" => array()
);

// Insert data into the "gen_shift" table
$result = insert("shop_sales_list", $insertData, '../');




// Redirect to the shop page
header("Location: ../shop?id=" . ($invo));
exit;
?>
