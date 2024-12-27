<?php 

$text='Hi *beautiful*, \n Your appointment was booked .Liyathra salon will be delighted serve you on 11/02/2024 at 9.00 am. \n *_See you soon!_*';

//whatsApp('94779252594',$text,'LIYATHRA_BOOKING.png');
function whatsApp($number , $text, $img) {
    $response='Invalid Host - '.$_SERVER['SERVER_NAME'];
    if($_SERVER['SERVER_NAME']=='liyathra.colorbiz.org'){
   

        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://chatbiz.net/api/send',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
        "number": "'.$number.'",
        "type": "media",
        "message": "'.$text.'",
        "media_url": "https://liyathra.colorbiz.org/main/pages/get/app/img/'.$img.'",
        "instance_id": "65C8624CF2E87",
        "access_token": "65b8742c1285f"
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Cookie: stackpost_session=efk5hfs38t9mtcfe0lq2laprmohinudj'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        echo $response;
        
    }

    return $response;
}

