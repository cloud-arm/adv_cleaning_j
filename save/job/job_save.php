<?php
session_start();
include('../../config.php');

$com_id=$_POST['com_id'];
$note=$_POST['note'];
$internal=$_POST['int_name'];
$shift_type = $_POST['shift_type'];


$r1=select_item('company','name','id='.$com_id,'../../');

$r2=select_item('internal_company','name','id='.$internal,'../../');

$r3=select_item('gen_shift_types','name','id='.$shift_type,'../../');


echo $r1;


$invo=date('ymdHis');



    $insertData = array(
        "data" => array(
            "company_id" => $_POST['com_id'],
            "company_name" => $r1,
            "date" => date('Y-m-d'),
            "time" => date('H.i.s'),
            "note" => $note,
            "action" => '1',
            "invoice_no" => $invo,
            "status" => 'pending',
            //"user_id" => $_SESSION['SESS_MEMBER_ID'],
            "internal" => $r2,
            "shift_type_id" => $shift_type,
            "shift_type_name" => $r3,




        ),
        "other" => array(
        ),
    );
    $result=insert("project", $insertData,'../../');
  




 


$id=base64_encode(select_item('project','id','invoice_no='.$invo,'../../'));



//echo $result['status'];
header("location: ../../job_view.php?id=$id");