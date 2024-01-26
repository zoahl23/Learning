<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="khoa_hoc.php">ProjectPHP K71</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php 
              include "../function.php";
              isLogin(); // kiểm tra đã đăng nhập chưa
              echo $_SESSION['name']; // hiện tên tài khoản
              $ten_tai_khoan = $_SESSION['name'];
              function check($conn, $taiKhoan) {
                $tenND = "SELECT * FROM `user` WHERE `tai_khoan` = '$taiKhoan'";
                $resultND = mysqli_query($conn, $tenND);
                while ($row = mysqli_fetch_array($resultND)) {
                    if ($row['role'] == 1) {
                        return true;
                    }
                }
                return false;
            }
            ?>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="dang_xuat.php">Đăng xuất</a></li>
            <li><a class="dropdown-item" style="margin-top: 8px;" href="doi_mat_khau.php?tai_khoan=<?php echo $ten_tai_khoan; ?>">Đổi mật khẩu</a></li>
            <?php 
              if (check($conn, $_SESSION['name'])) {
                echo '
                <li><a class="dropdown-item" style="margin-top: 8px;" href="them_khoa_hoc.php">Thêm khóa học</a></li>
                <li><a class="dropdown-item" style="margin-top: 8px;" href="tai_khoan.php">Quản lý tài khoản</a></li>
                <li><a class="dropdown-item" style="margin-top: 8px;" href="dashboard.php">Doasboard</a></li>';
              }
            ?>
            
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>