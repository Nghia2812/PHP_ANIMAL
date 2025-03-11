<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Kiểm tra xem username có tồn tại không
    $stmt = $conn->prepare("SELECT user_id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($password === $result["password"]) {
        $_SESSION["user_id"] = $result["user_id"];
        $_SESSION["username"] = $result["username"];
        echo "✅ Đăng nhập thành công!";
        header("Location: index.php");
        exit();
    } else {
        echo "❌ Sai mật khẩu!";
    }
}
    
?>
