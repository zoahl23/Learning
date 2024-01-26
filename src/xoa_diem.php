<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Xóa điểm</title>
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
        $idUser = "";
        $idKH = "";
        if (isset($_GET['id_khoa_hoc']) && isset($_GET['id_user'])) {
            $idUser = $_GET['id_user'];
            $idKH = $_GET['id_khoa_hoc'];
        }
        $dir = "../images/"; 
        $arrFile = scandir($dir);

        // kiểm tra đăng nhập chưa
		if (!isset($_SESSION['name'])) {
			header("Location: dang_nhap.php");
			exit;
		}

        if (!checkRole($conn, $_SESSION['name'])) {
			header("Location: khoa_hoc.php");
            exit;
		}

        // =================================
        if (!isset($_SESSION['xoa_diem_php'])) {
			header("Location: khoa_hoc.php");
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

        if (isset($_SESSION['xoa_khoa_hoc_php'])) {
            unset($_SESSION['xoa_khoa_hoc_php']);
        }

        if (isset($_SESSION['xoa_tai_khoan_php'])) {
            unset($_SESSION['xoa_tai_khoan_php']);
        }
    ?>
	<main style="min-height: 100vh; max-width: 100%;">
        <?php 
            // kiểm tra id user đó có điểm trong bảng điểm không
            $query = "SELECT * FROM `diem` WHERE `id_user` = '$idUser' AND `id_khoa_hoc` = '$idKH'";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                // xóa điểm 
                $xoaDiem = "DELETE FROM `diem` WHERE `id_user` = '$idUser'";
                if (mysqli_query($conn, $xoaDiem)) {
                    echo '<div class="alert alert-success text-center" role="alert">Xóa điểm thành công</div>';
                    unset($_SESSION['xoa_diem_php']);
                }
                else {
                    echo 'Error: ' . mysqli_error($conn);
                }
            }
            else {
                echo '<div class="alert alert-warning text-center" role="alert">Chưa có điểm thi</div>';
                unset($_SESSION['xoa_diem_php']);
            }
                      
        ?>
        <a href="diem_thi.php?id_khoa_hoc=<?php echo $idKH; ?>" class="btn btn-outline-success">Trở lại</a>
	</main>
    <?php include 'footer.php';?>
</body>
</html>