<?php  
$conn = mysqli_connect('localhost', 'root', 'mysql');
    if (! $conn) {  
die("Connection failed" . mysqli_connect_error());  
}  
    else {  
mysqli_select_db($conn, 'hospital_system');
}  
?>