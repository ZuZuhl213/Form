<?php
include '../../config/db.php';

// Lấy dữ liệu từ form
$ho = $_POST['ho'];
$ten = $_POST['ten'];
$password = $_POST['password'];
$email = $_POST['email'];
$dob = $_POST['dob'];
$gender = $_POST['gender'];
$city = $_POST['city'];

// Kiểm tra xem người dùng có chọn sở thích hay không
$hobbies = isset($_POST['hobbies']) ? implode(", ", $_POST['hobbies']) : "";
$bio = isset($_POST['bio']) ? $_POST['bio'] : "";

// Kiểm tra email đã tồn tại hay chưa (dùng prepared statement)
$checkStmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$checkStmt->bind_param("s", $email);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    die("Email đã tồn tại. Vui lòng sử dụng email khác.");
}
$checkStmt->close();

// Thêm người dùng mới 
$insertStmt = $conn->prepare("INSERT INTO users (ho, ten, password, email, dob, gender, city, hobbies, bio)
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$insertStmt->bind_param("sssssssss", $ho, $ten, $password, $email, $dob, $gender, $city, $hobbies, $bio);

if ($insertStmt->execute()) {
    echo "Đăng ký thành công!";
    header("Location: ../views/Login.html");
} else {
    echo "Lỗi: " . $conn->error;
}

$insertStmt->close();
$conn->close();
?>