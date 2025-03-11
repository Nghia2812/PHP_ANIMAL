<?php
session_start();
include "config.php";


// Kiểm tra phương thức POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $animal_id = $_POST['animal_id'] ?? 0;
    $comment = trim($_POST['comment']);

    // Kiểm tra thú cưng có tồn tại không
    $check_animal = "SELECT animal_id FROM animals WHERE animal_id = ?";
    $stmt_check = $conn->prepare($check_animal);
    $stmt_check->bind_param("i", $animal_id);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows == 0) {
        $response["message"] = "Lỗi: Thú cưng không tồn tại!";
        echo json_encode($response);
        exit;
    }
    

    // Thêm bình luận vào database
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $sql = "INSERT INTO reviews (animal_id, user_id, comment, status, created_at) 
                VALUES (?, ?, ?, 'pending', NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $animal_id, $user_id, $comment);
    } else {
        $guest_name = trim($_POST['guest_name'] ?? '');
        $guest_email = trim($_POST['guest_email'] ?? '');

        if (empty($guest_name) || empty($guest_email)) {
            $response["message"] = "Vui lòng nhập tên và email!";
            echo json_encode($response);
            exit;
        }

        $sql = "INSERT INTO reviews (animal_id, name, email, comment, status, created_at) 
                VALUES (?, ?, ?, ?, 'pending', NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $animal_id, $guest_name, $guest_email, $comment);
    }

    if ($stmt->execute()) {
        header("Location: detail_animal.php?id=" . $animal_id . "#comments"); // Chuyển về trang chi tiết
        exit();
    } else {
        echo "Lỗi khi gửi bình luận!";
    }
}

?>
