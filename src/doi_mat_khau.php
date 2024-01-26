<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Đổi mật khẩu</title>
	<!-- Begin bootstrap cdn -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<!-- End bootstrap cdn -->
</head>
<body>
    <?php 
        include 'navbar.php';
        include '../connectdb.php';
        $tenTK = "";
        if (isset($_GET['tai_khoan'])) {
            $tenTK = $_GET['tai_khoan'];
        }

        // kiểm tra đăng nhập chưa
		if (!isset($_SESSION['name'])) {
			header("Location: dang_nhap.php");
			exit;
		}

        // =================================

        if ($tenTK != $_SESSION['name']) {
            header("Location: khoa_hoc.php");
			exit;
        }

        // nếu url sai thì không cho truy cập vào trang biên tập
        $query = "SELECT * FROM `user` WHERE `tai_khoan` = '$tenTK'";
        $result = $conn->query($query);
        if ($result->num_rows <= 0) {
            header("location: khoa_hoc.php");
            exit;
        }

        // =================================
    ?>
    <?php 
        // khong cho truy cap vao trang

        if (isset($_SESSION['chinh_sua_khoa_hoc_php'])) {
            unset($_SESSION['chinh_sua_khoa_hoc_php']);
        }

        if (isset($_SESSION['chinh_sua_tai_khoan_php'])) {
            unset($_SESSION['chinh_sua_tai_khoan_php']);
        }

        if (isset($_SESSION['diem_thi_php'])) {
            unset($_SESSION['diem_thi_php']);
        }

        if (isset($_SESSION['ket_qua_php'])) {
            unset($_SESSION['ket_qua_php']);
        }

        if (isset($_SESSION['luyen_tap_php'])) {
            unset($_SESSION['luyen_tap_php']);
        }

        if (isset($_SESSION['them_cau_hoi_php'])) {
            unset($_SESSION['them_cau_hoi_php']);
        }

        if (isset($_SESSION['them_tai_khoan_php'])) {
            unset($_SESSION['them_tai_khoan_php']);
        }

        if (isset($_SESSION['xem_truoc_php'])) {
            unset($_SESSION['xem_truoc_php']);
        }

        if (isset($_SESSION['xoa_cau_hoi_php'])) {
            unset($_SESSION['xoa_cau_hoi_php']);
        }

        if (isset($_SESSION['xoa_diem_php'])) {
            unset($_SESSION['xoa_diem_php']);
        }

        if (isset($_SESSION['xoa_khoa_hoc_php'])) {
            unset($_SESSION['xoa_khoa_hoc_php']);
        }

        if (isset($_SESSION['xoa_tai_khoan_php'])) {
            unset($_SESSION['xoa_tai_khoan_php']);
        }
    ?>
	<main style="min-height: 100vh; max-width: 100%;">
		<div id="action" style="margin: 20px 0 0 13%;">
			<a href="khoa_hoc.php" class="btn btn-primary">Trở lại</a>
            <form action="" method="POST" enctype="multipart/form-data">
		</div>
        <div style="margin: 20px 13%;">
            <div class="form-group">
                <label for="name_quiz"><span style="color: red;"></span>Nhập mật khẩu cũ</label>
                <input class="form-control"  type="password" name="mkcu" id="">
            </div>
            <div class="form-group">
                <label for="name_quiz"><span style="color: red;"></span>Nhập mật khẩu mới</label>
                <input class="form-control"  type="password" name="mkm" id="">
            </div>
            <div class="form-group">
                <label for="name_quiz"><span style="color: red;"></span>Nhập lại mật khẩu mới</label>
                <input class="form-control"  type="password" name="mknl" id="">
            </div>
            <div style="margin: 20px 0 20px 0;" class="d-grid">
                <input class="btn btn-primary btn-block" name="btn" type="submit" value="Xác nhận">
            </div>
            <?php
                if (isset($_POST['btn'])) {
                    if (empty($_POST['mkcu']) || empty(trim($_POST['mkm'])) || empty(trim($_POST['mknl']))) {
                        echo '<div class="alert alert-warning text-center" role="alert">Vui lòng điền đầy đủ thông tin</div>';
                    }
                    else {
                        $sql = "SELECT * FROM `user`";
                        $result = mysqli_query($conn, $sql);
                        $mkm = md5($_POST['mkm']);
                        $mkcu = md5($_POST['mkcu']);
                        while ($row = mysqli_fetch_array($result)) {
                            $maUser = $row['id_user'];
                            $tkUser = $row['tai_khoan'];
                            $mkUser = $row['password'];
                                
                            if ($tenTK == $tkUser){
                                if ($mkcu != $mkUser) {
                                    echo '<div class="alert alert-warning text-center" role="alert">Nhập sai mật khẩu cũ</div>';
                                }
                                else {
                                    if ($_POST['mkm'] != $_POST['mknl']) {
                                        echo '<div class="alert alert-warning text-center" role="alert">Mật khẩu nhập lại không khớp</div>';
                                    }
                                    else {
                                        $doi_query = "UPDATE `user` SET `password` = '$mkm' WHERE `tai_khoan` = '$tenTK'";
                                        if (mysqli_query($conn, $doi_query)) {
                                            echo '<div class="alert alert-success text-center" role="alert">Đổi mật khẩu thành công</div>';
                                        } else {
                                            echo 'Error: ' . mysqli_error($conn);
                                        }
                                    }
                                }
                                break;
                            }    
                        }
                    }
                }      
            ?>
        </div>
        </form>
	</main>
    <?php include 'footer.php'; ?>
</body>
</html>