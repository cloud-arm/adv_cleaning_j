<?php
session_start();
include('../config.php');




$insertData = array(
    "data" => array(
        "name" => $_POST['name'],

    ),
    "other" => array(
    ),
);
insert("tools_category", $insertData,'../');


header("location: ../tools");
 