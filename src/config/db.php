<?php
$servername = "localhost";
$username = "root";        
$password = "1";            
$dbname = "persons";       

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>