
<?php
include("config.php");
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
    <link href="img/favicon.ico" rel="icon">
    

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
            <!-- Blog list Start -->
            <div class="col-lg-8">  
            <?php
$sql = "SELECT * FROM blog_posts";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        ?>
        <div class="blog-item mb-5">
            <div class="row g-0 bg-light overflow-hidden">
                <div class="col-12 col-sm-5 h-100">
                    <img class="img-fluid h-100" src="<?= htmlspecialchars($row["image"]) ?>" style="object-fit: cover;">
                </div>
                <div class="col-12 col-sm-7 h-100 d-flex flex-column justify-content-center">
                    <div class="p-4">
                        <div class="d-flex mb-3">
                            <small class="me-3">
                                <i class="bi bi-bookmarks me-2"></i> <?= htmlspecialchars($row["category"]) ?>
                            </small>
                            <small>
                                <i class="bi bi-calendar-date me-2"></i> <?= htmlspecialchars($row["created_at"]) ?>
                            </small>
                        </div>
                        <h5 class="text-uppercase mb-3"><?= htmlspecialchars($row["title"]) ?></h5>
                        <p><?= substr($row["content"], 0, 100) ?>...</p>
                        <a class="text-primary text-uppercase" href="detail_blog.php?id=<?= $row['post_id'] ?>"> Read More <i class="bi bi-chevron-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
} else {
    echo '<p>No blog posts available.</p>';
}
?>

             <!--Phần chuyển 1-2-3-4 -->
                <div class="col-12">
                    <nav aria-label="Page navigation">
                      <ul class="pagination pagination-lg m-0">
                        <li class="page-item disabled">
                          <a class="page-link rounded-0" href="#" aria-label="Previous">
                            <span aria-hidden="true"><i class="bi bi-arrow-left"></i></span>
                          </a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                          <a class="page-link rounded-0" href="#" aria-label="Next">
                            <span aria-hidden="true"><i class="bi bi-arrow-right"></i></span>
                          </a>
                        </li>
                      </ul>
                    </nav>
                </div>
             <!--Phần chuyển 1-2-3-4 -->
            </div>
            <!-- Blog list End -->

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

                <!-- Category Start -->
                <div class="category-sidebar mb-5">
  <h3 class="category-heading mb-4">DANH MỤC</h3>
  <div class="d-flex flex-column justify-content-start">
    <a class="category-link" href="#"><i class="bi bi-arrow-right"></i>Chăm sóc thú cưng</a>
    <a class="category-link" href="#"><i class="bi bi-arrow-right"></i>Sức khỏe & Dinh dưỡng</a>
    <a class="category-link" href="#"><i class="bi bi-arrow-right"></i>Làm đẹp & Chăm sóc lông</a>
    <a class="category-link" href="#"><i class="bi bi-arrow-right"></i>Huấn luyện & Kỷ luật</a>
    <a class="category-link" href="#"><i class="bi bi-arrow-right"></i>Dịch vụ y tế & Tiêm phòng</a>
  </div>
</div>
                <!-- Category End -->

                <!-- Recent Post Start -->
                <div class="related-posts-section mb-5">
  <h3 class="section-heading mb-4">BÀI VIẾT LIÊN QUAN</h3>
  
  <div class="post-item">
    <img class="post-image" src="/img/Category/anh1.webp" alt="Làm đẹp và cắt tỉa lông thú cưng">
    <a href="" class="post-title">
      Làm đẹp và cắt tỉa lông thú cưng
    </a>
  </div>
  
  <div class="post-item">
    <img class="post-image" src="/img/Category/anh2.jpg" alt="Cách tạo môi trường sống tốt cho thú cưng">
    <a href="" class="post-title">
      Cách tạo môi trường sống tốt cho thú cưng
    </a>
  </div>
  
  <div class="post-item">
    <img class="post-image" src="/img/Category/anh3.webp" alt="Gợi ý đồ chơi và phụ kiện cần thiết">
    <a href="" class="post-title">
      Gợi ý đồ chơi và phụ kiện cần thiết
    </a>
  </div>
  
  <div class="post-item">
    <img class="post-image" src="/img/Category/anh5.jpg" alt="Dịch vụ y tế và tiêm phòng quan trọng">
    <a href="" class="post-title">
      Dịch vụ y tế và tiêm phòng quan trọng
    </a>
  </div>
</div>
                <!-- Recent Post End -->

                <!-- Image Start -->
                <div class="mb-5">
                    <img src="/img/Gallery/anh18.webp" alt="" class="img-fluid rounded">
                </div>
                <!-- Image End -->

                <!-- Tags Start -->
                <div class="tag-cloud-section mb-5">
  <h3 class="section-heading mb-4">THẺ ĐÁNH DẤU</h3>
  <div class="tag-container">
    <a href="" class="tag tag-lg">Thiết Kế</a>
    <a href="" class="tag">Phát Triển</a>
    <a href="" class="tag tag-xl">Tiếp Thị</a>
    <a href="" class="tag">SEO</a>
    <a href="" class="tag tag-sm">Nội Dung</a>
    <a href="" class="tag">Tư Vấn</a>
    <a href="" class="tag tag-lg">Chăm Sóc Thú Cưng</a>
    <a href="" class="tag">Thức Ăn</a>
    <a href="" class="tag tag-xl">Làm Đẹp</a>
    <a href="" class="tag">Huấn Luyện</a>
    <a href="" class="tag tag-sm">Y Tế</a>
    <a href="" class="tag">Phụ Kiện</a>
  </div>
</div>
                <!-- Tags End -->

                <!-- Plain Text Start -->
                <div>
        <h3 class="text-uppercase border-start border-5 border-primary ps-3 mb-4">Văn Bản Đơn Giản</h3>
        <div class="bg-light text-center" style="padding: 30px;">
            <p>Quả thật biển và lời buộc tội chính đáng gây đau đớn, lời buộc tội chân thành, nỗi đau ngồi đau đớn clita kasd chỉ đúng, lời buộc tội không biển như là thời gian vĩ đại takimata, ngồi và đau buồn, đau đớn ngồi đau</p>
            <a href="" class="btn btn-primary py-2 px-4">Đọc Thêm</a>
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