<?php
include "config.php"; // Kết nối database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password']; // Không mã hóa mật khẩu

    // Kiểm tra xem email hoặc username đã tồn tại chưa
    $check = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $check->bind_param("ss", $username, $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) { // Sử dụng num_rows thay cho rowCount()
        echo "<script>alert('Username hoặc Email đã tồn tại!'); window.history.back();</script>";
        exit();
    } 
    $check->close(); // Đóng truy vấn trước khi tiếp tục

    // Lưu mật khẩu trực tiếp (không mã hóa)
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);
    
    if ($stmt->execute()) {
        // Chuyển hướng sang trang đăng nhập
        header("Location: /.php/sign_in.php");
        exit();
    } else {
        echo "<script>alert('Có lỗi xảy ra!'); window.history.back();</script>";
    }
}
?>
