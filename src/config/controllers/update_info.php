<?php
// src/config/views/edit_info.php
session_start();
include '../../config/db.php';

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/Login.html");
    exit();
}

// Lấy thông tin từ form
$user_id = $_SESSION['user_id'];
$fields = [];
$params = [];
$types = "";

// Kiểm tra và thêm từng trường vào câu lệnh UPDATE nếu có giá trị
if (!empty($_POST['ho'])) {
    $fields[] = "ho = ?";
    $params[] = $_POST['ho'];
    $types .= "s";
}
if (!empty($_POST['ten'])) {
    $fields[] = "ten = ?";
    $params[] = $_POST['ten'];
    $types .= "s";
}
if (!empty($_POST['password'])) {
    $fields[] = "password = ?";
    $params[] = $_POST['password']; 
    $types .= "s";
}
if (!empty($_POST['dob'])) {
    $fields[] = "dob = ?"; 
    $params[] = $_POST['dob'];
    $types .= "s";
}
if (!empty($_POST['gender'])) {
    $fields[] = "gender = ?";
    $params[] = $_POST['gender'];
    $types .= "s";
}
if (!empty($_POST['city'])) {
    $fields[] = "city = ?";
    $params[] = $_POST['city'];
    $types .= "s";
}
if (!empty($_POST['hobbies'])) {
    $fields[] = "hobbies = ?"; 
    $params[] = implode(',', $_POST['hobbies']);
    $types .= "s";
}
if (!empty($_POST['bio'])) {
    $fields[] = "bio = ?";
    $params[] = $_POST['bio'];
    $types .= "s";
}

// Nếu không có trường nào được cập nhật, dừng lại
if (empty($fields)) {
    echo "Không có thông tin nào để cập nhật.";
    exit();
}

// Xây dựng câu lệnh UPDATE
$query = "UPDATE users SET " . implode(", ", $fields) . " WHERE id = ?";
$params[] = $user_id;
$types .= "i";

// Chuẩn bị và thực thi câu lệnh
$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    // Cập nhật thành công
    header("Location: ../views/edit_info.php?success=1");
    exit();
} else {
    // Lỗi khi cập nhật
    echo "Lỗi: " . $conn->error;
}

$stmt->close();
$conn->close();
?>