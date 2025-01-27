<?php
session_start();
include('../connect.php');
include('../config.php');

$ui = $_SESSION['SESS_MEMBER_ID'];
$un = $_SESSION['SESS_FIRST_NAME'];

$invo = $_POST['id'];
$sup_id = $_POST['sup_id'];
$pay_type = $_POST['pay_type'];
$pay_amount = $_POST['amount'];
$credit_invo = $_POST['credit_note'];

$acc_no = '';
$bank_name = '';
$chq_no = '';
$chq_bank = '';
$chq_date = '';

// Handling additional fields based on payment type
if ($pay_type == 'Bank') {
    $acc_no = $_POST['acc_no'];
    $bank_name = $_POST['bank_name'];
}

if ($pay_type == 'Chq') {
    $chq_no = $_POST['chq_no'];
    $chq_bank = $_POST['chq_bank'];
    $chq_date = $_POST['chq_date'];
}

$date = date("Y-m-d");
$time = date('H:i:s');

// Fetch shop payment details
$result = query("SELECT * FROM shop_payment WHERE invoice_no = '$invo'", '../');
$row = $result->fetch(); // Assuming your `query` function returns a PDOStatement

// Insert payment data
$insertData = array(
    "data" => array(
        "invoice_no" => $invo,
        "pay_type" => $pay_type,
        "date" => $date,
        "amount" => $pay_amount,
        "pay_amount" => $pay_amount,
        "supply_id" => $sup_id,
        "supplier_invoice" => $credit_invo,
        "type" => 'Credit_payment',
        "chq_no" => $chq_no,
        "chq_bank" => $chq_bank,
        "chq_date" => $chq_date,
        "bank_name" => $bank_name,
        "acc_no" => $acc_no,
    ),
    "other" => array()
);
$result = insert("shop_payment", $insertData, '../');

// Calculate total amount from `shop_sales_list`
$total_amount = 0;
$r2 = query("SELECT * FROM shop_sales_list WHERE invoice_no = '$invo'", '../');

while ($raw = $r2->fetch()) {
    $amount = $raw['amount'];
    $total_amount += $amount;
}

echo $total_amount;

// Insert data into `shop_sales`
$insertData = array(
    "data" => array(
        "invoice_number" => $invo,
        "type" => $pay_type,
        "date" => $date,
        "amount" => $total_amount, // Use the total amount calculated
    ),
    "other" => array()
);
$result = insert("shop_sales", $insertData, '../');

// Redirect to another page if required
 header("Location: ../shop_index.php");
?>
