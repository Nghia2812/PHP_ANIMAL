<?php
// Kết nối database
include 'config.php';
include 'blog_comments.php';

// Kiểm tra xem có ID bài viết được truyền vào không
if (isset($_GET['id'])) {
    $blog_id = intval($_GET['id']);
    
    // Lấy thông tin bài viết từ database
    $sql = "SELECT * FROM blog_posts WHERE post_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $blog_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Khởi tạo biến để tránh lỗi undefined
    $animalData = [];

    // Kiểm tra bài viết có tồn tại không
    if ($result->num_rows > 0) {
        $animalData = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        echo "Bài viết không tồn tại!";
        exit();
    }
} else {
    echo "Không có bài viết nào được chọn!";
    exit();
}
// Lấy ID bài viết từ URL
$post_id = $_GET['id'] ?? 0;

// Lấy số lượng bình luận
$sql_count = "SELECT COUNT(*) AS total FROM blog_comments WHERE post_id = ?";
$stmt_count = $conn->prepare($sql_count);
$stmt_count->bind_param("i", $post_id); // Bind tham số
$stmt_count->execute();
$stmt_count->bind_result($total_comments);
$stmt_count->fetch();
$stmt_count->close(); // Đóng statement


// Lấy danh sách bình luận
$sql = "SELECT c.*, u.username 
        FROM blog_comments c 
        LEFT JOIN users u ON c.user_id = u.user_id
        WHERE c.post_id = ? 
        ORDER BY c.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();
$comments = $result->fetch_all(MYSQLI_ASSOC);


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
    <!-- Navbar End -->
    <main class="py-4">
        <div class="container">
            <div class="row">
                <!-- Pet Details Section -->
                <div class="col-lg-8">
                    <!-- Pet Image -->
                    <div class="pet-image mb-4">
                        <img src="<?= htmlspecialchars($animalData[0]['image']) ?>" alt="Lola - Mèo Maine Coon" class="img-fluid w-100">
                    </div>
                    
                    <!-- Pet Info -->
                    <div class="pet-details mb-4">
                        <h1 class="pet-name"><?= htmlspecialchars($animalData[0]['title']) ?></h1>
                        <div class="pet-info text-muted mb-3">
                            <small><i class="fas fa-calendar-alt me-2"></i>Đăng ngày: <?= htmlspecialchars($animalData[0]['created_at']) ?></small>
                        </div>
                        
                        <div class="mb-3">
                            <span class="pet-tag"><i class="fas fa-tag me-1"></i>Mèo Maine Coon</span>
                            <span class="pet-tag"><i class="fas fa-venus-mars me-1"></i>Cái</span>
                            <span class="pet-tag"><i class="fas fa-birthday-cake me-1"></i>2 tuổi</span>
                        </div>
                        <!-- PHẦN NỘI DUNG -->
                        
                        <div class="pet-description">
                            <p>LOLA là một chú mèo Maine Coon xinh xắn với bộ lông dài mượt. Chúng tôi nhận nuôi cô ấy từ một trại mèo chuyên nghiệp cách đây giờ 1 năm.</p>
                            
                            <ul>
                                <li><strong>Tính cách:</strong> Lola có tính cách thân thiện và cực kỳ thông minh. Cô ấy Thích ngồi trên ghế sofa nhìn ra ngoài cửa sổ và quan sát mọi thứ xung quanh. Lola cũng rất thích chơi với các món đồ chơi.</li>
                                
                                <li><strong>Sở thích:</strong> Lola rất thích chơi đùa với đồ chơi chuột và bóng nhỏ. Cô ấy cũng có sở thích đặc biệt là leo trèo lên các kệ sách và nằm ở nơi cao để quan sát.</li>
                                
                                <li><strong>Sức khỏe:</strong> Lola đã được tiêm phòng đầy đủ và kiểm tra sức khỏe định kỳ. Cô nàng không có vấn đề gì về sức khỏe và luôn duy trì chế độ ăn uống lành mạnh.</li>
                                
                                <li><strong>Thói quen ăn uống:</strong> Lola ăn hầu hết các loại thức ăn dành cho mèo, đặc biệt là thức ăn khô và ướt cao cấp. Cô ấy không kén ăn và luôn hoàn thành bữa ăn của mình.</li>
                                
                                <li><strong>Lưu ý:</strong> Lola cần được chải lông thường xuyên do lông dài. Cô nàng thích không gian yên tĩnh và sạch sẽ nên cần được chăm sóc thùng cát hàng ngày. Lola hòa đồng với động vật khác và rất thân thiện với trẻ em.</li>
                            </ul>
                            

                             <!-- PCÂU NÓI HAY -->
                            <div class="alert alert-success mt-4">
                                <i class="fas fa-info-circle me-2"></i> Chúng tôi muốn tìm một gia đình yêu thương cho Lola, nơi cô ấy có thể được chăm sóc và yêu thương trọn vẹn.
                            </div>
                        </div>
                           <!-- PHẦN NỘI DUNG -->


                        <!-- Social Share -->
                        <div class="mt-4 d-flex align-items-center">
                            <span class="me-3">Chia sẻ:</span>
                            <a href="#" class="btn btn-sm btn-outline-primary me-2"><i class="fab fa-facebook-f me-1"></i>Facebook</a>
                            <a href="#" class="btn btn-sm btn-outline-info me-2"><i class="fab fa-twitter me-1"></i>Twitter</a>
                            <a href="#" class="btn btn-sm btn-outline-danger"><i class="fab fa-pinterest me-1"></i>Pinterest</a>
                        </div>
                    </div>
   
                    
     <!-- CODE xử lý đếm số lượng bình luận  -->

                    <!-- Comment Section -->
                    <div class="comment-section">
                        <h3 class="mb-4"><?= $total_comments ?> Bình luận</h3>
                        
                       <!-- Hiển thị danh sách bình luận -->

<?php foreach ($comments as $comment): ?>
    <div class="comment mb-4">
        <div class="d-flex">
            <img src="/img/Gallery/anh1.jpg" alt="<?= htmlspecialchars($comment['author_name'] ?? $comment['username']); ?>" class="comment-avatar me-3">
            <div>
                <div class="d-flex align-items-center mb-2">
                    <h6 class="mb-0 me-2">
                        <?= htmlspecialchars($comment['username'] ?? $comment['author_name']); ?>
                    </h6>
                    <small class="text-muted"><?= date("d/m/Y \\A\\T h:i A", strtotime($comment['created_at'])); ?></small>
                </div>
                <p><?= nl2br(htmlspecialchars($comment['content'])); ?></p>
                <a href="#" class="text-success"><small>REPLY</small></a>
            </div>
        </div>
    </div>
<?php endforeach; ?>

                        
                   
                       
     <!-- Form nhập Comment -->                       
    <!-- Leave a Comment -->
<div class="mt-5">
    <h4 class="mb-4">CHIA SẺ SUY NGHĨA CỦA BẠN!</h4>
    <form action="blog_comments.php" method="POST">

        <input type="hidden" name="post_id" value="<?= $post_id; ?>">

        <?php if (!isset($_SESSION['user_id'])): ?>
      <!-- Người chưa đăng nhập -->
        <div class="mb-3">
            <input type="text" name="name" class="form-control" placeholder="Nhập Tên:" required>
        </div>
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Nhập Email" required>
        </div>
        <!-- Người đã đăng nhập -->
        <?php else: ?>
        <input type="hidden" name="user_id" value="<?= $_SESSION['user_id']; ?>">
        <?php endif; ?>

        <div class="mb-3">
            <textarea name="comment" class="form-control" rows="5" placeholder="Viết bình luận của bạn tại đây..." required></textarea>
        </div>
        <button type="submit" class="btn btn-success">GỬI NGAY!</button>
    </form>
</div>
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Search -->
                    <div class="sidebar-card mb-4">
                        <form class="search-form">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search...">
                                <button class="btn btn-success" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Categories -->
                    <div class="sidebar-card mb-4">
                        <h3 class="sidebar-title">DANH MỤC</h3>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent border-0 ps-0 pe-0">
                                <a class="fs-6 fw-normal text-dark text-decoration-none" href="#">
                                    <i class="bi bi-arrow-right me-1"></i>Chăm sóc thú cưng
                                </a>    
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent border-0 ps-0 pe-0">
                                <a class="fs-6 fw-normal text-dark text-decoration-none" href="#">
                                    <i class="bi bi-arrow-right me-1"></i>Sức khỏe thú cưng
                                </a> 
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent border-0 ps-0 pe-0">
                                <a class="fs-6 fw-normal text-dark text-decoration-none" href="#">
                                    <i class="bi bi-arrow-right me-1"></i>Hành vi & Đào tạo
                                </a> 
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent border-0 ps-0 pe-0">
                                <a class="fs-6 fw-normal text-dark text-decoration-none" href="#">
                                    <i class="bi bi-arrow-right me-1"></i>Giống thú cưng phổ biến
                                </a> 
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent border-0 ps-0 pe-0">
                                <a class="fs-6 fw-normal text-dark text-decoration-none" href="#">
                                    <i class="bi bi-arrow-right me-1"></i>Đồ dùng & Phụ kiện thú cưng
                                </a> 
                            </li>
                        </ul>
                    </div>
 
                    <!-- Related Pets -->
                    <div class="sidebar-card mb-4">
                        <h3 class="sidebar-title">ĐỒNG VẬT LIÊN QUAN</h3>
                        
                        <!-- Related pet 1 -->
                        <div class="related-pet">
                            <img src="/img/Gallery/anh16.jpeg" class="related-pet-img" alt="Luna">
                            <div>
                                <div class="related-pet-name">Luna</div>
                                <div class="related-pet-desc">Mèo Ba Tư thuần chủng</div>
                            </div>
                        </div>
                        
                        <!-- Related pet 2 -->
                        <div class="related-pet">
                            <img src="/img/Gallery/anh10.jpeg" class="related-pet-img" alt="Bella">
                            <div>
                                <div class="related-pet-name">Bella</div>
                                <div class="related-pet-desc">Mèo Anh lông ngắn 3 tuổi</div>
                            </div>
                        </div>
                        
                        <!-- Related pet 3 -->
                        <div class="related-pet">
                            <img src="/img/Gallery/anh13.jpeg" class="related-pet-img" alt="Whiskers">
                            <div>
                                <div class="related-pet-name">Whiskers</div>
                                <div class="related-pet-desc">Mèo Ragdoll 1 tuổi rưỡi</div>
                            </div>
                        </div>


                    </div>
                    
                    <!-- Tag Cloud -->
                    <div class="sidebar-card mb-4">
                        <h3 class="sidebar-title">TAG CLOUD</h3>
                        <div class="tag-cloud">
                            <a href="#" class="tag-item">Chó con</a>
                            <a href="#" class="tag-item">Mèo Maine Coon</a>
                            <a href="#" class="tag-item">Thú cưng</a>
                            <a href="#" class="tag-item">Pet</a>
                            <a href="#" class="tag-item">Mèo lông dài</a>
                            <a href="#" class="tag-item">Chăm sóc</a>
                            <a href="#" class="tag-item">Huấn luyện</a>
                            <a href="#" class="tag-item">Sức khỏe</a>
                            <a href="#" class="tag-item">Thức ăn</a>
                            <a href="#" class="tag-item">Mèo con</a>
                            <a href="#" class="tag-item">Chó Alaska</a>
                            <a href="#" class="tag-item">Vật nuôi</a>
                        </div>
                    </div>
                    
                    <!-- Plain Text -->
                    <div class="sidebar-card">
                        <h3 class="sidebar-title">PLAIN TEXT</h3>
                        <p>Hãy đến với cửa hàng thú cưng của chúng tôi - nơi cung cấp các loại thú cưng, thức ăn và dịch vụ chăm sóc uy tín.</p>
                        <p>Chúng tôi cam kết mang đến những người bạn đồng hành tuyệt vời cho gia đình bạn.</p>
                        <a href="#" class="btn btn-success btn-sm">XEM THÊM</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
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