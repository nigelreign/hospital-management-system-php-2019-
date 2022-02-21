<?php
if(!isset($_SESSION)){
    session_start();
}

session_destroy();
session_regenerate_id( true);
$message = $_GET['message'];
header("Location: ../signin/index.php?message=$message");