<?php
session_start();
include('../../config.php');

// Get the form data
$product_id = $_POST['product_id'];

$quantity = $_POST['qty'];
$job_no = $_POST['job_no']; 
$date = date('Y-m-d'); 
$about=$_POST['about'];



$price_set=$_POST['price'];

 
$product_name=select_item('products','product_name','id='.$product_id,'../../');
$price=select_item('products','price','id='.$product_id,'../../');

$result=select('products','*','id='.$product_id,'../../');
while ($row = $result->fetch()) {
    $pro_name=$row['product_name'];
    $price=$row['price'];
    $unit=$row['cat'];
}

$result=select('price_fm','*','product_id='.$product_id.' AND action=0','../../');
while ($row = $result->fetch()) {
    if($quantity > $row['slb_from'] && $quantity < $row['slb_to']) {
        $price=$row['price'];
    }
}

if(!$price_set ==''){
    $price=$_POST['price'];
}

$action = select_item('job','action','id='.$job_no,'../../');
//echo "$action";

// Prepare the data to be inserted
$insertData = array(
    "data" => array(
        "name" => $product_name,
        "qty" => $quantity,
        "job_no" => $job_no,
        "price" => $price,
        "amount" => $price*$quantity,
        "product_id" => $product_id,
        "date" => $date,
        "about" => $about,
        "status" =>'pending',
        "unit"=>$unit,
    ),
    "other" => array(
    ),
);

// Insert the data into the sales_list table
insert("sales_list", $insertData, '../../');

//$invo = select_item('sales_list',"'job_no='.$job_no ",'../../');


$result = select('product_list', '*', "product_id ='$product_id'", '../../');


for ($i = 0; $row = $result->fetch(); $i++) { 
   if( $_REQUEST['pro_'.$row['id']]>0){

    $insertData = array(
        "data" => array(
            "name" =>$row['name'],
            "product_id" => $product_id,
            "job_no" => $job_no,
            "product_list_id" => $row['id'],

        ),
        "other" => array(
        ),
    );
    
    // Insert the data into the sales_list table
   insert("sales_list_task", $insertData, '../../');
   };
    

}

// Redirect back to the job details page
//header("location: ../../job_view.php?id=" . base64_encode($job_no));
//echo "<script>location.href='../../job_view.php';</script>";

if($action== 2){
    
    $result = update('job', ['action'=>3], 'id='.$job_no, '../../');
    
   header("location: ../../job_view.php?id=" . base64_encode($job_no));
    
 
}
header("location: ../../job_view.php?id=" . base64_encode($job_no));

