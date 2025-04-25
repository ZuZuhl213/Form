<?php
session_start();
include '../../config/db.php';

// Lấy thông tin từ form đăng nhập
$email = $_POST['email'];
$password = $_POST['password'];

// Kiểm tra thông tin đăng nhập trong cơ sở dữ liệu
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // So sánh mật khẩu trực tiếp
    if ($password === $user['password']) {
        // Lưu thông tin người dùng vào session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['ho'] . ' ' . $user['ten'];

        // Chuyển hướng đến trang thay đổi thông tin
        header("Location: ../views/edit_info.php");
        exit();
    } else {
        echo "Sai mật khẩu!";
    }
} else {
    echo "Email không tồn tại!";
}

$stmt->close();
$conn->close();
?>