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

echo $invo;

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
$result = $db->prepare("SELECT * FROM shop_payment WHERE invoice_no = :id");
$result->bindParam(':id', $invo);
$result->execute();
$row = $result->fetch();

// Insert payment details into `shop_payment`
$sql = 'INSERT INTO shop_payment (amount, pay_amount, pay_type, date, invoice_no, supply_id, supplier_invoice, type, chq_no, chq_bank, chq_date, bank_name, acc_no)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
$q = $db->prepare($sql);
$q->execute([
    $pay_amount,
    $pay_amount,
    $pay_type,
    $date,
    $invo,
    $sup_id,
    $credit_invo,
    'Credit_payment',
    $chq_no,
    $chq_bank,
    $chq_date,
    $bank_name,
    $acc_no,
]);

// Fetch `shop_sales_list` records
$r2 = $db->prepare("SELECT * FROM shop_sales_list WHERE invoice_no = :invoice_no");
$r2->bindParam(':invoice_no', $invo);
$r2->execute();

$total_amount = 0;

while ($raw = $r2->fetch()) {
    $amount = $raw['amount'];
    $total_amount = $total_amount+ $amount;
}

    // Insert data into `shop_sales`
    $sql = "INSERT INTO shop_sales (invoice_number, date, type, amount)
            VALUES (:invoice_no, :date,:type, :amount)";
    $re = $db->prepare($sql);
    $re->execute([
        ':invoice_no' => $invo,
        ':date' => $date,
        ':type' => $pay_type,
        ':amount' => $amount,

    ]);


// Redirect to another page if required
header("Location: ../shop_index.php");
?>
