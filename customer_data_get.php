<?php

include_once("config.php");

$contact = $_GET['contact'];
$cus_id = 0;
$result = select('customer', '*', "contact	 = '$contact'");
for ($i = 0; $row = $result->fetch(); $i++){
    $cus_id = $row['id'];
    $name = $row['name'];
    $cus_address = $row['address'];
    $cus_phone_no = $row['contact'];
    
    

}

    if($cus_id > 0){
        $response = array('cus_name'=>$name,'cus_phone_no'=>$cus_phone_no,'cus_address'=>$cus_address, 'cus_id'=>$cus_id,'action'=>'true');
    }else{
        $response = array('action'=>'false');
    }




$json_response = json_encode($response);
echo $json_response;

