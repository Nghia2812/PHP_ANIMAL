<?php
include ("process_login.php");

include ("process_register.php");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập/Đăng ký - Quản lý thú cưng</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="../css/sign_in.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="inner-box" id="card">
                <div class="card-front">
                    <div class="logo">
                        <i class="fas fa-paw"></i>
                        <h2>PetCare</h2>
                    </div>
                    <h3>ĐĂNG NHẬP</h3>
   <!-- XỬ LÝ CODE NHẬP TỪ KHÁCH HÀNG -->               
                    <form method="POST">
                        <div class="input-group">
                            <div class="input-box">
                                <input type="text" name ="username" class="input-field" required><label>Tên đăng nhập</label>
                                <i class="fas fa-user"></i> 
                            </div>
                        </div>
                        <div class="input-group">
                            <div class="input-box">
                                <input type="password" name="password" class="input-field" required>
                                <label>Mật khẩu</label>
                                <i class="fas fa-lock"></i>
                            </div>
                        </div>
                        <div class="remember-forgot">
                            <div class="remember-me">
                                <input type="checkbox" id="remember">
                                <label for="remember">Nhớ đăng nhập</label>
                            </div>
                            <a href="#">Quên mật khẩu?</a>
                        </div>
                        <button type="submit" class="submit-btn">Đăng nhập</button>
                        <div class="social-login">
                            <p>Hoặc đăng nhập với</p>
                            <div class="social-icons">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-google"></i></a>
                            </div>
                        </div>
                    </form>
                    <button type="button" class="btn" onclick="openRegister()">Tôi chưa có tài khoản</button>
                </div>
                
                <div class="card-back">
                    <div class="logo">
                        <i class="fas fa-dog"></i>
                        <h2>PetCare</h2>
                    </div>
                    <h3>ĐĂNG KÝ</h3>
     <!-- XỬ LÝ CODE NHẬP TỪ KHÁCH HÀNG -->  
     <form action="process_register.php" method="POST">
    <div class="input-group">
        <div class="input-box">
            <input type="text" class="input-field" name="username" required>
            <label>Tên đăng nhập</label>
            <i class="fas fa-user"></i>
        </div>
    </div>
    <div class="input-group">
        <div class="input-box">
            <input type="email" class="input-field" name="email" required>
            <label>Email</label>
            <i class="fas fa-envelope"></i>
        </div>
    </div>
    <div class="input-group">
        <div class="input-box">
            <input type="password" class="input-field" name="password" required>
            <label>Mật khẩu</label>
            <i class="fas fa-lock"></i>
        </div>
    </div>
    <div class="input-group">
        <div class="input-box">
            <input type="password" class="input-field" name="confirm_password" required>
            <label>Xác nhận mật khẩu</label>
            <i class="fas fa-lock"></i>
        </div>
    </div>
    <button type="submit" class="submit-btn">Đăng ký</button>
    <div class="social-login">
        <p>Hoặc đăng ký với</p>
        <div class="social-icons">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-google"></i></a>
        </div>
    </div>
</form>

                    <button type="button" class="btn" onclick="openLogin()">Tôi đã có tài khoản</button>
                </div>
            </div>
        </div>
        
        <div class="pet-images">
            <img src="https://bestcargo.vn/wp-content/uploads/2022/07/Hinh-anh-van-chuyen-thu-cung-bang-may-bay.jpg" class="pet-img pet1" alt="dog">
            <img src="https://bestcargo.vn/wp-content/uploads/2022/07/Hinh-anh-van-chuyen-thu-cung-bang-may-bay.jpg" class="pet-img pet2" alt="cat">
            <img src="https://bestcargo.vn/wp-content/uploads/2022/07/Hinh-anh-van-chuyen-thu-cung-bang-may-bay.jpg" class="pet-img pet3" alt="rabbit">
        </div>
    </div>

    <script>
        const card = document.getElementById('card');
        
        function openRegister() {
            card.style.transform = 'rotateY(-180deg)';
        }
        
        function openLogin() {
            card.style.transform = 'rotateY(0deg)';
        }
    </script>
</body>
</html>