<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Chỉnh sửa tài khoản</title>
	<!-- Begin bootstrap cdn -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<!-- End bootstrap cdn -->
</head>
<body>
    <?php 
        include 'navbar.php';
        include '../connectdb.php';
        include '../role.php';
        $idND = "";
        if (isset($_GET['id_user'])) {
            $idND = $_GET['id_user'];
        }

        // kiểm tra đăng nhập chưa
		if (!isset($_SESSION['name'])) {
			header("Location: dang_nhap.php");
			exit;
		}

        // nếu không phải admin ko cho vào
        if (!checkRole($conn, $_SESSION['name'])) {
			header("Location: khoa_hoc.php");
			exit;
		}

        // kiểm tra tên người dùng đã tồn tại hay chưa
        function checkTenND($conn, $ten) {
            $sql = "SELECT * FROM `user`";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($result)) {
                $tkUser = $row['tai_khoan'];
                
                if ($ten == $tkUser) {
                    return true;
                }
            }
            return false;
        }
        
        // ================================

        if (!isset($_SESSION['chinh_sua_tai_khoan_php'])) {
			header("Location: khoa_hoc.php");
			exit;
		}

        $query = "SELECT * FROM `user` WHERE `id_user` = '$idND' AND `role` = 0";
        $result = $conn->query($query);
        if ($result->num_rows <= 0) {
            header("location: khoa_hoc.php");
            exit;
        }

        // ================================


        // lấy tên
        $layTenND = "SELECT * FROM `user` WHERE `id_user` = '$idND'";
        $resultTenND = mysqli_query($conn, $layTenND);
        while ($row = mysqli_fetch_array($resultTenND)) {
            $tenND = $row['tai_khoan'];
        }
    ?>
    <?php 
        // khong cho truy cap vao trang

        if (isset($_SESSION['chinh_sua_khoa_hoc_php'])) {
            unset($_SESSION['chinh_sua_khoa_hoc_php']);
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
			<a href="tai_khoan.php" class="btn btn-primary">Trở lại</a>
            <form action="" method="POST" enctype="multipart/form-data">
		</div>
        <div style="margin: 20px 13%;">
            <div class="form-group">
                <label for="name_quiz"><span style="color: red;"></span>Đổi tên người dùng</label>
                <input class="form-control" type="text" name="ten_nguoi_dung" id="" value="<?php if (isset($_POST['ten_nguoi_dung'])) { echo $_POST['ten_nguoi_dung'];} else {echo $tenND;} ?>">
            </div>
            <div style="margin: 20px 0 0 0;" class="d-grid">
                <input class="btn btn-primary btn-block" name="btnCN" type="submit" value="Cập nhật tên tài khoản">
            </div>
            <div style="margin: 20px 0 20px 0;" class="d-grid">
                <input class="btn btn-primary btn-success" name="btnCQ" type="submit" value="Cấp quyền quản trị viên cho tài khoản này">
            </div>
            <?php
                if (isset($_POST['btnCN'])) {
                    if (!empty(trim($_POST['ten_nguoi_dung']))) {
                        $tenTK = trim($_POST['ten_nguoi_dung']);
                        if (checkTenND($conn, $tenTK)) {
                            echo '<div class="alert alert-warning text-center" style="margin: 20px 0; role="alert">Tên người dùng đã tồn tại</div>';
                        }
                        else {
                            
                            $suaTen = "UPDATE `user` SET `tai_khoan` = '$tenTK' WHERE `id_user` = '$idND'";
                            if (mysqli_query($conn, $suaTen)) {
                                echo '<div class="alert alert-success text-center" style="margin: 20px 0; role="alert">Cập nhật tên mới thành công</div>';
                            } else {
                                echo 'Error: ' . mysqli_error($conn);
                            }
                        }            
                    }
                    else {
                        echo '<div class="alert alert-warning text-center" style="margin: 20px 0; role="alert">Vui lòng nhập tên người dùng</div>';
                    }
                }
                
                if (isset($_POST['btnCQ'])) {
                    $tenTK = trim($_POST['ten_nguoi_dung']);
                    if (!checkRole($conn, $tenTK)) {
                        $capQuyen = "UPDATE `user` SET `role` = 1 WHERE `id_user` = '$idND'";
                        if (mysqli_query($conn, $capQuyen)) {
                            echo '<div class="alert alert-success text-center" style="margin: 20px 0; role="alert">Cập nhật quyền thành công</div>';
                            unset($_SESSION['chinh_sua_tai_khoan_php']);
                        } else {
                            echo 'Error: ' . mysqli_error($conn);
                        }
                    }
                    else {
                        echo '<div class="alert alert-warning text-center" style="margin: 20px 0; role="alert">Tài khoản đã được cấp quyền</div>';
                    }
                }
            ?>
        </div>
        </form>
	</main>
    <?php include 'footer.php'; ?>
</body>
</html>