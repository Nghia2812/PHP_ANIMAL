<?php
include 'config.php';

$total_comments = 0;
$comments = [];
// 🔹 Kiểm tra tham số ID hợp lệ
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    die("<p>ID không hợp lệ.</p>");
}

$animal_id = (int)$_GET['id'];

// 🔹 Truy vấn lấy thông tin động vật hiện tại
$sql = "SELECT animals.*, animal_categories.category_name
        FROM animals
        JOIN animal_categories ON animals.category_id = animal_categories.category_id
        WHERE animal_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $animal_id);
$stmt->execute();
$result = $stmt->get_result();
$animalData = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// 🔹 Kiểm tra dữ liệu có tồn tại không
if (empty($animalData)) {
    die("<p>Không tìm thấy động vật này.</p>");
}

$categoryId = $animalData[0]['category_id'];

// 🔹 Lấy danh sách động vật cùng loại (trừ con hiện tại)
$sql = "SELECT * FROM animals WHERE category_id = ? AND animal_id != ? LIMIT 4";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $categoryId, $animal_id);
$stmt->execute();
$relatedAnimals = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// ✅ Kiểm tra bảng `reviews` có tồn tại không trước khi truy vấn
$table_check = $conn->query("SHOW TABLES LIKE 'reviews'");
if ($table_check->num_rows == 0) {
    die("Lỗi: Bảng 'reviews' không tồn tại!");
}

// 🔹 Truy vấn lấy bình luận
$sql = "SELECT name, email, comment, created_at FROM reviews WHERE animal_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $animal_id);
$stmt->execute();
$result = $stmt->get_result();

// Gán dữ liệu vào biến
$comments = $result->fetch_all(MYSQLI_ASSOC);
$total_comments = count($comments);
// 🔹 Gọi file xử lý bình luận mà không cần `include`
include "animal_comment.php";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>PET SHOP - Pet Shop Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="../img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Roboto:wght@700&display=swap" rel="stylesheet">  

    <!-- Icon Font Stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../lib/flaticon/font/flaticon.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">



    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

     <!-- PHẦN KHỞI TẠO MENU  Start -->
     <?php
           include("process_menu.php");
           ?>
    <!-- MENU End -->



    <!-- Blog Start -->
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-8">
                <!-- Blog Detail Start -->
                <div class="mb-5">
                    <img class="img-fluid w-100 rounded mb-5" src="<?= htmlspecialchars($animalData[0]['image']) ?>" alt="">
                    <h1 class="text-uppercase mb-4"><?= htmlspecialchars($animalData[0]['name']) ?></h1>
                    <?php echo "<p>" . $animalData[0]['detail'] . "</p>"; ?>
                </div>
                <!-- Blog Detail End -->



                <!-- Comment List Start -->
                <div class="mb-5">
                    <h3 class="text-uppercase border-start border-5 border-primary ps-3 mb-4"><?= $total_comments ?> Bình luân!</h3>
                   
                   
    <?php foreach ($comments as $row): ?>
        <div class="d-flex ms-5 mb-4 comment-item">
            <img src="/img/Gallery/anh12.webp" class="img-fluid rounded-circle" style="width: 45px; height: 45px;">
            <div class="ps-3">
                <h6>
                     <?= isset($row['user_name']) ? htmlspecialchars($row['user_name']) : htmlspecialchars($row['name']) . " (Bạnh chưa đăng nhập!)" ?>
                    <small><i><?= date("d M Y", strtotime($row['created_at'])) ?></i></small>
                </h6>
                <p><?= nl2br(htmlspecialchars($row['comment'])) ?></p>
            </div>
        </div>
    <?php endforeach; ?>


                </div>
                <!-- Comment List End -->

                <!-- Comment Form Start -->
               <div class="bg-light rounded p-5">
    <h3 class="text-uppercase border-start border-5 border-primary ps-3 mb-4">BÌNH LUẬN </h3>

    <!-- Form Bình luận -->
<form action="animal_comment.php" method="POST">
    <input type="hidden" name="animal_id" value="<?= isset($_GET['id']) ? htmlspecialchars($_GET['id']) : 0 ?>">

    <div class="row g-3">
        <?php if (!isset($_SESSION['user_id'])): ?>
            <!-- Nếu chưa đăng nhập, yêu cầu nhập tên & email -->
            <div class="col-12 col-sm-6">
                <input type="text" name="guest_name" class="form-control bg-white border-0" placeholder="Nhập Tên:" required>
            </div>
            <div class="col-12 col-sm-6">
                <input type="email" name="guest_email" class="form-control bg-white border-0" placeholder="Nhập Email:" required>
            </div>
        <?php else: ?>
            <!-- Nếu đã đăng nhập, hiển thị tên -->
            <p>Bình luận với tư cách: <strong><?= $_SESSION['username'] ?></strong></p>
        <?php endif; ?>

        <!-- Ô nhập bình luận -->
        <div class="col-12">
            <textarea name="comment" class="form-control bg-white border-0" rows="5" placeholder="Chia sẻ suy nghĩ của bạn:" required></textarea>
        </div>

        <!-- Nút gửi -->
        <div class="col-12">
            <button class="btn btn-primary w-100 py-3" type="submit">GỬI NGAY</button>
        </div>
    </div>
</form>

</div>

                <!-- Comment Form End -->
            </div>

            <!-- Sidebar Start -->
            <div class="col-lg-4">
                <!-- Search Form Start -->
                <div class="mb-5">
                    <div class="input-group">
                        <input type="text" class="form-control p-3" placeholder="Keyword">
                        <button class="btn btn-primary px-4"><i class="bi bi-search"></i></button>
                    </div>
                </div>
                <!-- Search Form End -->

                <!-- DANH MỤC THÚ CƯNG Category Start -->
                <div class="mb-5">
    <h3 class="text-uppercase border-start border-5 border-primary ps-3 mb-4">DANH MỤC</h3>
    <div class="d-flex flex-column justify-content-start">
        <!-- Mục danh mục đang active -->
        <a href="#" class="d-flex align-items-center py-2 px-3 bg-light mb-1 active">
            <i class="bi bi-arrow-right text-primary me-2"></i>
            <span class="fw-bold fs-5 text-black category-highlight"><?= htmlspecialchars($animalData[0]['category_name']) ?></span>
        </a>
        
        <!-- Các mục danh mục khác -->
        <a href="#" class="d-flex align-items-center py-2 px-3 bg-light mb-1">
            <i class="bi bi-arrow-right text-primary me-2"></i>
            <span class="fw-bold fs-5 text-black category-highlight">Chó cảnh</span>
        </a>
        
        <a href="#" class="d-flex align-items-center py-2 px-3 bg-light mb-1">
            <i class="bi bi-arrow-right text-primary me-2"></i>
            <span class="fw-bold fs-5 text-black category-highlight">Mèo cảnh</span>
        </a>
        
        <a href="#" class="d-flex align-items-center py-2 px-3 bg-light mb-1">
            <i class="bi bi-arrow-right text-primary me-2"></i>
            <span class="fw-bold fs-5 text-black category-highlight">Thú cưng nhỏ</span>
        </a>
        
        <a href="#" class="d-flex align-items-center py-2 px-3 bg-light mb-1">
            <i class="bi bi-arrow-right text-primary me-2"></i>
            <span class="fw-bold fs-5 text-black category-highlight">Cá cảnh</span>
        </a>
    </div>
</div>
 <!-- Category End -->

 
                <!-- Recent Post Start -->
              <div class="mb-5">
    <h3 class="text-uppercase border-start border-5 border-primary ps-3 mb-4">Động vật liên quan</h3>  

    <?php foreach ($relatedAnimals as $animal) : ?>
        <div class="d-flex overflow-hidden mb-3 align-items-start">
            <img class="img-fluid" src="<?= htmlspecialchars($animal['image']) ?>" style="width: 100px; height: 100px; object-fit: cover;" alt="">
            <div class="ms-2">
                <a href="detail_animal.php?id=<?= $animal['animal_id'] ?>" class="animal-name"><?= htmlspecialchars($animal['name']) ?></a>
                <p class="animal-desc"><?= htmlspecialchars($animal['description']) ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>
                <!-- Recent Post End -->

                          
                <!-- Tags Start -->
                <div class="mb-5">
    <h3 class="text-uppercase border-start border-5 border-primary ps-3 mb-4">Đám Mây Thẻ</h3>
    <div class="d-flex flex-wrap m-n1">
        <a href="" class="tag-cloud-item tag-color-1 m-1">Thiết kế <span class="tag-count">8</span></a>
        <a href="" class="tag-cloud-item tag-color-2 tag-lg m-1">Phát triển <span class="tag-count">12</span></a>
        <a href="" class="tag-cloud-item tag-color-3 m-1">Marketing <span class="tag-count">6</span></a>
        <a href="" class="tag-cloud-item tag-color-4 tag-sm m-1">SEO <span class="tag-count">4</span></a>
        <a href="" class="tag-cloud-item tag-color-5 m-1">Viết lách <span class="tag-count">9</span></a>
        <a href="" class="tag-cloud-item tag-color-1 m-1">Tư vấn <span class="tag-count">5</span></a>
        <a href="" class="tag-cloud-item tag-color-2 tag-sm m-1">Đồ họa <span class="tag-count">3</span></a>
        <a href="" class="tag-cloud-item tag-color-3 tag-lg m-1">Lập trình <span class="tag-count">15</span></a>
        <a href="" class="tag-cloud-item tag-color-4 m-1">Quảng cáo <span class="tag-count">7</span></a>
        <a href="" class="tag-cloud-item tag-color-5 tag-sm m-1">Phân tích <span class="tag-count">4</span></a>
        <a href="" class="tag-cloud-item tag-color-1 m-1">Nội dung <span class="tag-count">8</span></a>
        <a href="" class="tag-cloud-item tag-color-2 m-1">Tối ưu hóa <span class="tag-count">6</span></a>
    </div>
</div>
                <!-- Tags End -->

                <!-- Plain Text Start -->
                <div>
                    <h3 class="text-uppercase border-start border-5 border-primary ps-3 mb-4">Plain Text</h3>
                    <div class="bg-light text-center" style="padding: 30px;">
                        <p>Vero sea et accusam justo dolor accusam lorem consetetur, dolores sit amet sit dolor clita kasd justo, diam accusam no sea ut tempor magna takimata, amet sit et diam dolor ipsum amet diam</p>
                        <a href="" class="btn btn-primary py-2 px-4">Read More</a>
                    </div>
                </div>
                <!-- Plain Text End -->
            </div>
            <!-- Sidebar End -->
        </div>
    </div>
    <!-- Blog End -->


    <!-- Footer Start -->
    <div class="container-fluid bg-light mt-5 py-5">
        <div class="container pt-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-uppercase border-start border-5 border-primary ps-3 mb-4">Get In Touch</h5>
                    <p class="mb-4">No dolore ipsum accusam no lorem. Invidunt sed clita kasd clita et et dolor sed dolor</p>
                    <p class="mb-2"><i class="bi bi-geo-alt text-primary me-2"></i>123 Street, New York, USA</p>
                    <p class="mb-2"><i class="bi bi-envelope-open text-primary me-2"></i>info@example.com</p>
                    <p class="mb-0"><i class="bi bi-telephone text-primary me-2"></i>+012 345 67890</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-uppercase border-start border-5 border-primary ps-3 mb-4">Quick Links</h5>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-body mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Home</a>
                        <a class="text-body mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>About Us</a>
                        <a class="text-body mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Our Services</a>
                        <a class="text-body mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Meet The Team</a>
                        <a class="text-body mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Latest Blog</a>
                        <a class="text-body" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Contact Us</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-uppercase border-start border-5 border-primary ps-3 mb-4">Popular Links</h5>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-body mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Home</a>
                        <a class="text-body mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>About Us</a>
                        <a class="text-body mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Our Services</a>
                        <a class="text-body mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Meet The Team</a>
                        <a class="text-body mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Latest Blog</a>
                        <a class="text-body" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Contact Us</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-uppercase border-start border-5 border-primary ps-3 mb-4">Newsletter</h5>
                    <form action="">
                        <div class="input-group">
                            <input type="text" class="form-control p-3" placeholder="Your Email">
                            <button class="btn btn-primary">Sign Up</button>
                        </div>
                    </form>
                    <h6 class="text-uppercase mt-4 mb-3">Follow Us</h6>
                    <div class="d-flex">
                        <a class="btn btn-outline-primary btn-square me-2" href="#"><i class="bi bi-twitter"></i></a>
                        <a class="btn btn-outline-primary btn-square me-2" href="#"><i class="bi bi-facebook"></i></a>
                        <a class="btn btn-outline-primary btn-square me-2" href="#"><i class="bi bi-linkedin"></i></a>
                        <a class="btn btn-outline-primary btn-square" href="#"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
                <div class="col-12 text-center text-body">
                    <a class="text-body" href="">Terms & Conditions</a>
                    <span class="mx-1">|</span>
                    <a class="text-body" href="">Privacy Policy</a>
                    <span class="mx-1">|</span>
                    <a class="text-body" href="">Customer Support</a>
                    <span class="mx-1">|</span>
                    <a class="text-body" href="">Payments</a>
                    <span class="mx-1">|</span>
                    <a class="text-body" href="">Help</a>
                    <span class="mx-1">|</span>
                    <a class="text-body" href="">FAQs</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-dark text-white-50 py-4">
        <div class="container">
            <div class="row g-5">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-md-0">&copy; <a class="text-white" href="#">Your Site Name</a>. All Rights Reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0">Designed by <a class="text-white" href="https://htmlcodex.com">HTML Codex</a></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary py-3 fs-4 back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
</body>

</html>