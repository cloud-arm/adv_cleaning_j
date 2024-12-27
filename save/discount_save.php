<?php
session_start();
include('../config.php');

$amount=$_POST['amount'];
$id=$_POST['job_no'];

$r1 = select('sales', '*', "job_no='$id' AND type='Quotation'",'../');
for ($i = 0; $row = $r1->fetch(); $i++) { 
    $transaction_id = $row['transaction_id'];
}

$cus_id=select_item('job','company_id', 'id='.$id,'../');
$totalAmount = 0;
$result = select('sales_list', '*', 'job_no = ' . $id . " AND  status !='delete' ", '../');
while ($row = $result->fetch()) { 
    $totalAmount += $row['amount']; // Sum the amounts
}


 if($transaction_id > 0){ 
    update('sales',['discount'=>$amount , 'amount' => $totalAmount- $amount],"job_no='$id' AND type='Quotation'",'../');
 }else{

$cus_id=select_item('job','company_id', 'id='.$id,'../');
$totalAmount = 0;
$result = select('sales_list', '*', 'job_no = ' . $id . " AND  status !='delete' ", '../');
while ($row = $result->fetch()) { 
    $totalAmount += $row['amount']; // Sum the amounts
}


  $invoiceNumber = 'QT'.date('ymdHis'); 
  $insertData = array(
    "data" => array(
        "customer_id" => $cus_id,
       "customer_name" => select_item('job', 'name', 'id=' . $id, '../'),
        "invoice_number" => $invoiceNumber,
        "cashier" => $_SESSION['SESS_MEMBER_ID'],
        "action" => '20',
        "date" => date('Y-m-d'), 
        "pay_type" => 'credit',
        "comment" => 'No',
        "type" => 'Quotation',
        "job_no" => $id,
        "discount" => $amount,


        ),
        "other" => array(),
    );
    $result = insert("sales", $insertData, '../');
 }





header("location: ../job_view?id=".base64_encode($id));
