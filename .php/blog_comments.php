<?php
session_start();
include "config.php";  // Kết nối CSDL

$post_id = $_GET['post_id'] ?? 0;  // Lấy ID bài viết


// Xử lý khi người dùng gửi bình luận
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_id = $_POST['post_id'] ?? 0;
    $comment = $_POST['comment'];

    // Kiểm tra post_id có tồn tại không
    $check_post = "SELECT post_id FROM blog_posts WHERE post_id = ?";
    $stmt_check = $conn->prepare($check_post);
    $stmt_check->bind_param("i", $post_id);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows == 0) {
        die("Lỗi: Bài viết không tồn tại!");
    }

    if (isset($_SESSION['user_id'])) {
        // Nếu đã đăng nhập
        $user_id = $_SESSION['user_id'];
        $sql = "INSERT INTO blog_comments (post_id, user_id, content) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $post_id, $user_id, $comment);
        $stmt->execute();
    } else {
        // Nếu chưa đăng nhập
        $name = $_POST['name'];
        $email = $_POST['email'];
        $sql = "INSERT INTO blog_comments (post_id, author_name, author_email, content) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $post_id, $name, $email, $comment);
        $stmt->execute();
    }

    
    // Load lại trang để hiển thị bình luận mới
header("Location: detail_blog.php?id=" . urlencode($post_id));
exit();

}


// Lấy danh sách bình luận
$sql = "SELECT c.*, u.username FROM blog_comments c 
        LEFT JOIN users u ON c.user_id = u.user_id
        WHERE c.post_id = ? 
        ORDER BY c.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->execute([$post_id]);

$result = $stmt->get_result(); // Lấy kết quả
$comments = $result->fetch_all(MYSQLI_ASSOC); // Chuyển thành mảng kết hợp

// Kiểm tra lỗi nếu có

?>
