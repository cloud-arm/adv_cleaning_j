<?php
session_start();
include('../config.php');




$insertData = array(
    "data" => array(
        "name" => $_POST['name'],
        "address" => $_POST['address'],
        "type" => $_POST['type'],
        "email" => $_POST['email'],
        "reg_no" => $_POST['reg_no'],   

    ),
    "other" => array(
    ),
);
insert("gen_company", $insertData,'../');


header("location: ../company");
 