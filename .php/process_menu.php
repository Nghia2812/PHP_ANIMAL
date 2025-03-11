<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


include './config.php';

// Lấy danh sách menu từ database
$sql = "SELECT * FROM menu_items ORDER BY order_index ASC";
$result = $conn->query($sql);
?>

<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light shadow-sm py-3 py-lg-0 px-3 px-lg-0">
    <a href="index.php" class="navbar-brand ms-lg-5">
    <h1 class="pet-brand m-0 text-uppercase">
    <i class="fa-solid fa-paw paw-icon"></i>
    <i class="fs-1 text-primary me-3"></i>
    PNT PET
</h1>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto py-0">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<a href="' . $row["url"] . '" class="nav-item nav-link" style="color: #1a8954;">' . $row["title"] . '</a>';
                }
            } else {
                echo '<a class="nav-item nav-link">No Menu</a>';
            }
            ?>
            
            <div class="nav-auth">
            <?php if (isset($_SESSION["user_id"])) : ?>
            <a href="profile.php" class="nav-item nav-link p-2 rounded">
             <i class="bi bi-person-circle"></i> <?= isset($_SESSION["username"]) ? $_SESSION["username"] : "Người dùng"; ?> </a>
             <div class="user-menu-container">
    <a href="profile.php" class="nav-item nav-link nav-profile rounded d-flex align-items-center">
        <i class="bi bi-person-circle me-2"></i> Profile
    </a>
    <div class="user-dropdown">
        <a href="profile.php" class="dropdown-item">
            <i class="bi bi-person me-2"></i> Xem hồ sơ cá nhân
          </a>
          <a href="process_logout.php" class="dropdown-item text-danger">
                       <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
               </a>
            </div>
            </div>
            <?php else : ?>
            <a href="sign_in.php" class="nav-item nav-link nav-sign-in">Sign In</a>
            <?php endif; ?>

            </div>
        </div>
    </div>
</nav>
<!-- Navbar End -->
