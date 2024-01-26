<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Xóa khóa học</title>
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
        $idKH = "";
        if (isset($_GET['id_khoa_hoc'])) {
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
        if (!isset($_SESSION['xoa_khoa_hoc_php'])) {
			header("Location: khoa_hoc.php");
            exit;
		}
        // =================================
        
        // xóa ảnh đã lưu
        $anhKhoaHoc = "SELECT * FROM `khoa_hoc` WHERE `id_khoa_hoc` = '$idKH'";
        $resultKH = mysqli_query($conn, $anhKhoaHoc);
        while ($row = mysqli_fetch_array($resultKH)) {
            $tenAnh = $row['anh'];
            $diaChiAnh = $dir.$tenAnh;
        }
        foreach ($arrFile as $key => $value) {
            if ($tenAnh == $value) {
                unlink($dir.$value);
            }
        }
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

        if (isset($_SESSION['xoa_tai_khoan_php'])) {
            unset($_SESSION['xoa_tai_khoan_php']);
        }
    ?>
	<main style="min-height: 100vh; max-width: 100%;">
        <?php 
            $cauHoi = "SELECT * FROM `cau_hoi` WHERE `id_khoa_hoc` = '$idKH'";
            $resultCH = mysqli_query($conn, $cauHoi);
            while ($r = mysqli_fetch_array($resultCH)) {
                $idCH = $r['id_cau_hoi'];

                // xóa ảnh đã lưu
                $anhCH = $r['anh_cau_hoi'];
                $diaChiAnh = $dir.$anhCH;
                foreach ($arrFile as $key => $value) {
                    if ($anhCH == $value) {
                        unlink($dir.$value);
                    }
                }

                // Xóa đáp án
                $xoaDapAn = "DELETE FROM `dap_an` WHERE `id_cau_hoi` = '$idCH'";
                mysqli_query($conn, $xoaDapAn);
            }

            // Xóa câu hỏi
            $xoaCauHoi = "DELETE FROM `cau_hoi` WHERE `id_khoa_hoc` = '$idKH'";
            mysqli_query($conn, $xoaCauHoi);

            // xóa điểm 
            $xoaDiem = "DELETE FROM `diem` WHERE `id_khoa_hoc` = '$idKH'";
            mysqli_query($conn, $xoaDiem);

            $xoaKhoaHoc = "DELETE FROM `khoa_hoc` WHERE `id_khoa_hoc` = '$idKH'";
            if (mysqli_query($conn, $xoaKhoaHoc)) {
                echo '<div class="alert alert-success text-center" role="alert">Xóa khóa học thành công</div>';
                unset($_SESSION['xoa_khoa_hoc_php']);
            } else {
                echo 'Error: ' . mysqli_error($conn);
            } 
                      
        ?>
        <a href="khoa_hoc.php" class="btn btn-outline-success">Trở lại</a>
	</main>
    <?php include 'footer.php';?>
</body>
</html>