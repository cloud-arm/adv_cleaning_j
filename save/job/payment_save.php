<?php
session_start();
include('../../config.php');

// Input validation
$id = ($_POST['id']);
$chq_no = ($_POST['chq_no']);
$chq_date = ($_POST['chq_date']);
$amount = ($_POST['amount']);
$pay_type = ($_POST['pay_type']);
$bank = ($_POST['bank_name']);

if ($id <= 0 || $amount <= 0 || empty($pay_type)) {
    exit("Invalid input data.");
}

// Fetch bank details
$bank_result = select('bank', '*', "id = $bank", '../../');
$bank_data = $bank_result->fetch() ;

if ($pay_type === 'Bank' && $bank_data) {
    // Update bank balance
    $new_balance = $bank_data['amount'] + $amount;
    update('bank', ['amount' => $new_balance], "id = $bank", '../../');

    // Add transaction record
    $transaction_data = array(
        "data" => array(
            "transaction_type" => 'Bank_transaction',
            "type" => "cash_transfer",
            "record_no" => date('YmdHis'),
            "amount" => $amount,
            'date' => date('Y-m-d'),
            'time' => date('H:i:s'),
            'credit_acc_name' => $bank_data['name'],
            'user_id' => 1,
        ),
        "other" => array(),
    );
    insert("bank_record", $transaction_data, '../../');
}

// Adjust credit balance for non-credit payments
if ($pay_type !== 'credit') {
    query("UPDATE `payment` SET credit_balance = credit_balance - $amount WHERE job_no = $id AND pay_type = 'credit'", '../../');

    $credit_result = select('payment', 'credit_balance', "job_no = $id AND pay_type = 'credit'", '../../');
    $credit_data =  $credit_result->fetch();

    if ($credit_data && $credit_data['credit_balance'] <= 0) {
        query("UPDATE `job` SET status = 'finish' WHERE id = $id", '../../');
    }
}

// Record payment details
$payment_data = array(
    "data" => array(
        "chq_no" => $chq_no,
        "chq_date" => $chq_date,
        "pay_type" => $pay_type,
        "bank_name" => '',
        "amount" => $amount,
        'date' => date('Y-m-d'),
        'time' => date('H:i:s'),
        'invoice_no' => date('YmdHis'),
        'job_no' => $id,
    ),
    "other" => array(),
);
insert("payment", $payment_data, '../../');

// Redirect (optional)
 header("location: ../../job_view.php?id=" . base64_encode($id));
exit;
?>
