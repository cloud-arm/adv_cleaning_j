<?php
require('fpdf.php');
include("../connect.php");
include("../config.php");
$id=$_GET['id'];
$type=$_GET['type'];

if($type==1){
$ms="Thank you for choosing us for your cleaning needs. Please find your invoice attached for reference. We'd appreciate it if you could reply with a rating from 0-5 and share any feedback on our service. We look forward to adding you to our list of satisfied customers. Don't hesitate to reach out for any future needs! Best regards, The Advanced Cleaning Services Team";
}else{
$ms="Welcome to Advanced Cleaning Services! Please find your quote attached. We look forward to your feedback and are excited to provide you with our top-quality service. Thank you for choosing us! Best regards, The Advanced Cleaning Services Team";
}

whatsApp($_GET['phone'], 
$ms,
'https://adcleaning.colorbiz.org/main/pages/forms/pdfd/doc360?id='.$id.'&type='.$type);

header('location:../job_view?id='.base64_encode($id));