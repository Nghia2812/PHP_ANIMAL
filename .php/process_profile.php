<?php
include 'config.php'; // Kết nối database

// Chỉ gọi session_start() nếu chưa có session nào hoạt động
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: /.php/sign_in.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Lấy user_id từ session

// Truy vấn lấy thông tin người dùng
$stmt = $conn->prepare("SELECT username, email, full_name, phone, address FROM users WHERE user_id = ?");
if (!$stmt) {
    die("Lỗi chuẩn bị truy vấn: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Kiểm tra nếu có dữ liệu gửi lên
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? $user['username'];
    $email = $_POST['email'] ?? $user['email'];
    $full_name = $_POST['full_name'] ?? $user['full_name'];
    $phone = $_POST['phone'] ?? $user['phone'];
    $address = $_POST['address'] ?? $user['address'];

    // Kiểm tra lại user_id (tránh lỗi nếu mất session)
    if (empty($user_id)) {
        die("Lỗi: Không xác định được user_id.");
    }

    // Cập nhật dữ liệu vào MySQL
    $sql = "UPDATE users SET username = ?, email = ?, full_name = ?, phone = ?, address = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Lỗi SQL: " . $conn->error);
    }

    // Ràng buộc tham số
    $stmt->bind_param("sssssi", $username, $email, $full_name, $phone, $address, $user_id);

    // Thực thi câu lệnh
    if ($stmt->execute()) {
        echo "<script>alert('Cập nhật thành công!'); window.location.href='profile.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi cập nhật dữ liệu: " . $stmt->error . "'); window.history.back();</script>";
    }

    // Đóng statement
    $stmt->close();
}

// Đóng kết nối
$conn->close();
?>
