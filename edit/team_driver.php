<?php
session_start();
include('../config.php');
include('../connect.php');

$id=$_GET['id'];
$job_no = $_GET['job_no'];
$app = $_GET['app'];

echo $id;
echo $job_no;


if($app == '1'){
    $result = update('job_team', 
    [
     'ex_work' => 'yes',


    ], 'emp_id='.$id AND 'job_id ='.$job_no, '../');

}
if($app == '2'){
    $result = update('job_team', 
    [
     'ex_work' => 'no',


    ], 'emp_id='.$id AND 'job_id ='.$job_no, '../');

}






echo $result['status'];
header("location: ../job_view.php?id=".base64_encode($job_no));

?>