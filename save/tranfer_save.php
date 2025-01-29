<?php
session_start();
include('../connect.php');
include('../config.php');

$ui = $_SESSION['SESS_MEMBER_ID'];
$un = $_SESSION['SESS_FIRST_NAME'];
$invo = $_POST['invo'];
$date = date("Y-m-d");
$time = date('H:i:s');

// Fetch all shop share items for the given invoice number
$result = query("SELECT * FROM shop_shere_items WHERE invoice_no = '$invo'", '../');

while ($row = $result->fetch()) {
    $mat_id = $row['mat_id'];
    $name = $row['name'];
    $store_location = $row['store_location'];
    $qty = $row['qty'];
    $unit = $row['unit'];
    $item_date = $row['date'];

    // Reduce stock from the original store location
    $stock_result = query("SELECT * FROM stock WHERE location = '$store_location' AND product_id = '$mat_id'", '../');
    if ($stock_row = $stock_result->fetch()) {
        $new_qty = $stock_row['qty'] - $qty;
        update('stock', ['qty' => $new_qty], "location='$store_location' AND product_id='$mat_id'", '../');
    }

    // Check if the material exists in 'shop' location
    $shop_stock_result = query("SELECT * FROM stock WHERE location = 'shop' AND product_id = '$mat_id'", '../');
    if ($shop_stock_row = $shop_stock_result->fetch()) {
        // Update stock in shop
        $shop_new_qty = $shop_stock_row['qty'] + $qty;
        update('stock', ['qty' => $shop_new_qty], "location='shop' AND product_id='$mat_id'", '../');
    } else {
        // Insert new stock record in shop
        $insertData = array(
            "data" => array(
                "product_id" => $mat_id,
                "qty" => $qty,
                "location" => "shop",
                "unit" => $unit,
                "date" => $item_date
            ),
            "other" => array()
        );
        insert("stock", $insertData, '../');
    }
}

// Redirect after operations are completed
header("Location: ../transfer_history.php");
exit();
?>
