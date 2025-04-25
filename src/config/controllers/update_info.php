<!-- filepath: c:\xampp\htdocs\Form\src\config\controllers\update_info.php -->
<?php
session_start();
include '../../config/db.php';

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/Login.html");
    exit();
}

// Lấy thông tin từ form
$user_id = $_SESSION['user_id'];
$ho = $_POST['ho'];
$ten = $_POST['ten'];
$password = $_POST['password'];

// Cập nhật thông tin người dùng
if (!empty($password)) {
    // Nếu người dùng nhập mật khẩu mới, mã hóa mật khẩu
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET ho = ?, ten = ?, password = ? WHERE id = ?");
    $stmt->bind_param("sssi", $ho, $ten, $hashed_password, $user_id);
} else {
    // Nếu không thay đổi mật khẩu
    $stmt = $conn->prepare("UPDATE users SET ho = ?, ten = ? WHERE id = ?");
    $stmt->bind_param("ssi", $ho, $ten, $user_id);
}

if ($stmt->execute()) {
    echo "Cập nhật thông tin thành công!";
    header("Location: ../views/edit_info.php");
    exit();
} else {
    echo "Lỗi: " . $conn->error;
}

$stmt->close();
$conn->close();
?>