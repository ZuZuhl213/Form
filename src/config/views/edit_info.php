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
                <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($user['birth']); ?>" required>
            </div>
            <div class="formgroup">
                <div class="gender-options">
                    <label class="label">Giới tính:</label>
                    <input type="radio" id="male" name="gender" value="Nam" <?php echo $user['gender'] === 'Nam' ? 'checked' : ''; ?> required>
                    <label for="male">Nam</label>
                    <input type="radio" id="female" name="gender" value="Nữ" <?php echo $user['gender'] === 'Nữ' ? 'checked' : ''; ?> required>
                    <label for="female">Nữ</label>
                    <input type="radio" id="other" name="gender" value="Khác" <?php echo $user['gender'] === 'Khác' ? 'checked' : ''; ?> required>
                    <label for="other">Khác</label>
                </div>
            </div>
            <div class="formgroup-namngang">
                <label class="label" for="city">Thành phố:</label>
                <select id="city" name="city" required>
                    <option value="" disabled <?php echo empty($user['city']) ? 'selected' : ''; ?>>Chọn thành phố</option>
                    <option value="Hà Nội" <?php echo $user['city'] === 'Hà Nội' ? 'selected' : ''; ?>>Hà Nội</option>
                    <option value="TP HCM" <?php echo $user['city'] === 'TP HCM' ? 'selected' : ''; ?>>TP HCM</option>
                    <option value="Hưng Yên" <?php echo $user['city'] === 'Hưng Yên' ? 'selected' : ''; ?>>Hưng Yên</option>
                </select>
            </div>
            <div class="formgroup">
                <div class="checkbox-group">
                    <label class="label">Sở thích</label>
                    <div>
                        <input type="checkbox" id="hobby1" name="hobbies[]" value="Đọc sách" <?php echo in_array('Đọc sách', explode(',', $user['hobbie'])) ? 'checked' : ''; ?>>
                        <label for="hobby1">Đọc sách</label>
                    </div>
                    <div>
                        <input type="checkbox" id="hobby2" name="hobbies[]" value="Nghe nhạc" <?php echo in_array('Nghe nhạc', explode(',', $user['hobbie'])) ? 'checked' : ''; ?>>
                        <label for="hobby2">Nghe nhạc</label>
                    </div>
                    <div>
                        <input type="checkbox" id="hobby3" name="hobbies[]" value="Xem phim" <?php echo in_array('Xem phim', explode(',', $user['hobbie'])) ? 'checked' : ''; ?>>
                        <label for="hobby3">Xem phim</label>
                    </div>
                    <div>
                        <input type="checkbox" id="hobby4" name="hobbies[]" value="Bóng đá" <?php echo in_array('Bóng đá', explode(',', $user['hobbie'])) ? 'checked' : ''; ?>>
                        <label for="hobby4">Bóng đá</label>
                    </div>
                    <div>
                        <input type="checkbox" id="hobby5" name="hobbies[]" value="Cầu lông" <?php echo in_array('Cầu lông', explode(',', $user['hobbie'])) ? 'checked' : ''; ?>>
                        <label for="hobby5">Cầu lông</label>
                    </div>
                </div>
            </div>
            <div class="formgroup">
                <label for="bio">Mô tả bản thân:</label>
                <textarea id="bio" name="bio" rows="4" cols="50" placeholder="Nhập mô tả về bản thân"><?php echo htmlspecialchars($user['bio']); ?></textarea>
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