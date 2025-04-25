<!-- filepath: c:\xampp\htdocs\Form\src\config\views\edit_info.php -->
<?php
session_start();
include '../../config/db.php';

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.html");
    exit();
}

// Lấy thông tin người dùng từ cơ sở dữ liệu
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Không tìm thấy thông tin người dùng!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../asset/css/style.css">
    <title>Thay đổi thông tin</title>
</head>
<body>
    <header>
        <h1>Thay đổi thông tin</h1>
    </header>

    <main>
        <form action="../controllers/update_info.php" method="POST">
            <div class="formgroup">
                <label class="label" for="ho">Họ</label>
                <input type="text" id="ho" name="ho" value="<?php echo htmlspecialchars($user['ho']); ?>" required>
            </div>
            <div class="formgroup">
                <label class="label" for="ten">Tên</label>
                <input type="text" id="ten" name="ten" value="<?php echo htmlspecialchars($user['ten']); ?>" required>
            </div>
            <div class="formgroup">
                <label class="label" for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
            </div>
            <div class="formgroup">
                <label class="label" for="dob">Ngày sinh</label>
                <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($user['dob']); ?>" required>
            </div>
            <div class="formgroup">
                <label class="label" for="gender">Giới tính</label>
                <select id="gender" name="gender" required>
                    <option value="Nam" <?php echo $user['gender'] === 'Nam' ? 'selected' : ''; ?>>Nam</option>
                    <option value="Nữ" <?php echo $user['gender'] === 'Nữ' ? 'selected' : ''; ?>>Nữ</option>
                    <option value="Khác" <?php echo $user['gender'] === 'Khác' ? 'selected' : ''; ?>>Khác</option>
                </select>
            </div>
            <div class="formgroup">
                <label class="label" for="city">Thành phố</label>
                <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($user['city']); ?>" required>
            </div>
            <div class="formgroup">
                <label class="label" for="hobbies">Sở thích</label>
                <textarea id="hobbies" name="hobbies" rows="3"><?php echo htmlspecialchars($user['hobbies']); ?></textarea>
            </div>
            <div class="formgroup">
                <label class="label" for="description">Mô tả bản thân</label>
                <textarea id="description" name="description" rows="4"><?php echo htmlspecialchars($user['description']); ?></textarea>
            </div>
            <div class="formgroup">
                <label class="label" for="password">Mật khẩu mới</label>
                <input type="password" id="password" name="password" placeholder="Nhập mật khẩu mới (nếu muốn thay đổi)">
            </div>
            <div class="btn-group">
                <button type="submit" class="btn">Cập nhật</button>
                <button type="button" class="btn" onclick="window.location.href='../controllers/logout.php'">Đăng xuất</button>
            </div>
        </form>
    </main>
</body>
</html>