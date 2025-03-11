<?php
session_start();
include 'config.php'; // Kết nối database

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: /.php/sign_in.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Lấy ID người dùng từ session

// Truy vấn lấy thông tin user từ database
$sql = "SELECT username, email, profile_image, full_name, phone, address FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Kiểm tra nếu không tìm thấy user
if (!$user) {
    echo "Không tìm thấy thông tin người dùng.";
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="profile-styles.css">
    <link href="../css/profile-style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Bọc toàn bộ trong form -->
<form action="process_profile.php" method="POST">
    <div class="container">
        <div class="top-profile-card">
            <div class="profile-img">
                <!--lấy ảnh từ sql ra-->
                <img src="<?= htmlspecialchars($user['profile_image']) ?>" alt="Profile picture">
            </div>
            <div class="profile-info">
                <h2><?= htmlspecialchars($user['username']) ?></h2>
                <p class="job-title">Public Relations</p>
            </div>
            <div class="profile-actions">
                <a href="#" class="action-item">
                    <i class="fas fa-tablet-alt"></i>
                    <span>App</span>
                </a>
                <a href="#" class="action-item">
                    <i class="fas fa-envelope"></i>
                    <span>Messages</span>
                </a>
                <a href="#" class="action-item">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </div>
        </div>
        
        <div class="main-content">
            <div class="edit-profile-section">
                <div class="section-header">
                    <h3>CHỈNH SỬA HỒ SƠ CÁ NHÂN</h3>
                    <button type="submit" class="settings-btn">LƯU</button>
                </div>

                <div class="user-form">
                    <div class="form-section">
                        <h4 class="section-title">Thông tin người dùng</h4>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="username">Username- Tên đăng nhập</label>
                                <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" id="email" name="email"value="<?= htmlspecialchars($user['email'] ?? '') ?>">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="firstname">Full name</label>
                                <input type="text" id="firstname" name="full_name" value="<?= htmlspecialchars($user['full_name'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label for="lastname">Phone</label>
                                <input type="text" id="lastname" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h4 class="section-title">KẾT NỐI - THÔNG TIN</h4>
                        
                        <div class="form-group full-width">
                            <label for="address">Địa chỉ: </label>
                            <input type="text" id="address" name="address" value="<?= htmlspecialchars($user['address'] ?? '') ?>">
                        </div>                     
                    </div>

                    <div class="form-section">
                        <h4 class="section-title">ABOUT ME</h4>
                        
                        <div class="form-group full-width">
                            <label for="about">About me</label>
                            <textarea id="about" rows="3">A beautiful Dashboard for Bootstrap 5. It is Free and Open Source.</textarea>
                        </div>
                    </div>
                </div>
            </div>
<!-- phần hiện thị thông tin bên trái -->
            <div class="user-profile">
                <div class="profile-background">
                    <img src="https://images2.thanhnien.vn/zoom/700_438/528068263637045248/2024/1/26/e093e9cfc9027d6a142358d24d2ee350-65a11ac2af785880-17061562929701875684912-37-0-587-880-crop-1706239860681642023140.jpg" alt="University campus">
                </div>
                <div class="profile-details">
                    <div class="profile-picture">
                        <img src="<?= htmlspecialchars($user['profile_image']) ?>" alt="User picture">
                    </div>
                    <div class="action-buttons">
                        <button class="btn-connect">Connect</button>
                        <button class="btn-message">Message</button>
                    </div>
                    <div class="profile-stats">
                        <div class="stat-item">
                            <div class="stat-number">22</div>
                            <div class="stat-label">Friends</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">10</div>
                            <div class="stat-label">Photos</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">89</div>
                            <div class="stat-label">Comments</div>
                        </div>
                    </div>
                    <div class="profile-bio">
                        <h3 class="profile-name">Mark Davis <span class="profile-age">, 35</span></h3>
                        <p class="profile-location">Bucharest, Romania</p>
                        <p class="profile-job">Solution Manager - Creative Tim Officer</p>
                        <p class="profile-university">University of Computer Science</p>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</body>
</html>