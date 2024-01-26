<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Xem trước</title>
	<!-- Begin bootstrap cdn -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<!-- End bootstrap cdn -->
</head>
<body>
    <?php 
        include 'navbar.php';
        include '../role.php';
        $idKH = "";
        $idCH = "";
        if (isset($_GET['id_khoa_hoc']) && isset($_GET['id_cau_hoi'])) {
            $idKH = $_GET['id_khoa_hoc'];
            $idCH = $_GET['id_cau_hoi'];
        }
        $tenName = $_SESSION['name'];
        $dir = "../images/"; 

        // kiểm tra đăng nhập chưa
		if (!isset($_SESSION['name'])) {
			header("Location: dang_nhap.php");
			exit;
		}

        // =========================================
        if (!isset($_SESSION['xem_truoc_php'])) {
            unset($_SESSION['xem_truoc_php']);
			header("Location: khoa_hoc.php");
			exit;
		}

        // lay id user
        $layIdUser = "SELECT `id_user` FROM `user` WHERE `tai_khoan` = '$tenName'";
        $resultIU = mysqli_query($conn, $layIdUser);
        while ($row = mysqli_fetch_array($resultIU)) {
            $idND = $row[0];
        }

        // neu ko la admin chi cho xem cau hoi chinh minh
        if (!checkRole($conn, $tenName)) {
            $query = "SELECT * FROM `cau_hoi` WHERE `id_khoa_hoc` = '$idKH' AND `id_cau_hoi` = '$idCH' AND `id_user` = '$idND'";
            $result = $conn->query($query);
            if ($result->num_rows <= 0) {
                unset($_SESSION['xem_truoc_php']);
                header("location: khoa_hoc.php");
                exit;
            }
        }
        else {
            $query = "SELECT * FROM `cau_hoi` WHERE `id_khoa_hoc` = '$idKH' AND `id_cau_hoi` = '$idCH'";
            $result = $conn->query($query);
            if ($result->num_rows <= 0) {
                unset($_SESSION['xem_truoc_php']);
                header("location: khoa_hoc.php");
                exit;
            }
        }
        // ==========================================
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
            <p class="h3">Khóa học 
                <!--Tên khóa học  -->
                <?php 
                    // lấy tên khóa học
                    $tenkhSql = "SELECT `ten_kh` FROM `khoa_hoc` WHERE `id_khoa_hoc` = '$idKH'";
                    $resultKH = mysqli_query($conn, $tenkhSql);
                    while ($row = mysqli_fetch_array($resultKH)) {
                        echo $row[0];
                    }
                ?>
            </p>
            <a href="bien_tap.php?id_khoa_hoc=<?php echo $idKH; ?>" class="btn btn-primary">Trở lại</a>
        </div>
        <?php 
            $cauHoiSql = "SELECT * FROM `cau_hoi` WHERE `id_cau_hoi` = '$idCH'";
            $resultCH = mysqli_query($conn, $cauHoiSql);
            while ($row = mysqli_fetch_array($resultCH)) {
                $idCauHoi = $row['id_cau_hoi'];
                $ten = $row['ten_cau_hoi'];
                $tenAnh = $row['anh_cau_hoi'];
                $loai = $row['loai_cau_hoi'];
                $diaChiAnh = $dir.$tenAnh;

                // lấy đáp án
                $dapAnSql = "SELECT * FROM `dap_an`";
                $resultDapAn = mysqli_query($conn, $dapAnSql);
            }
        ?>
        <div style="margin: 20px 30%;">
            <div class="form-group">
                <label for="name_quiz"><h4><font color="blue">Câu hỏi:</font> <?php echo $ten; ?></h4></label>
            </div>
            <?php 
            if ($tenAnh != "" ) {
                echo '<div class="form-group">
                    <img src="'.$diaChiAnh.'" height="200px">
                </div>';
            } 

            if ($loai == "Điền") {
                echo '<div style="margin: 20px 0 0 0;" class="input-group mb-3">
                    <input type="text" class="form-control" value="';
                while ($r = mysqli_fetch_array($resultDapAn)) {
                    if ($r['id_cau_hoi'] == $idCauHoi && $r['kiem_tra'] == 1) {
                        echo $r['ten_dap_an'];
                    }
                }
                echo '" readonly></div>';
            }

            if ($loai == "Một đáp án") {
                while ($r = mysqli_fetch_array($resultDapAn)) {
                    if ($r['id_cau_hoi'] == $idCauHoi && $r['kiem_tra'] == 1) {
                        echo '<div style="margin: 20px 0 0 0;" class="input-group mb-3">
                            <div class="input-group-text">
                                <input type="radio" checked disabled>
                            </div>
                            <input type="text" class="form-control" value="';
                        echo $r['ten_dap_an'];
                        echo '" readonly></div>';
                    }
                    if ($r['id_cau_hoi'] == $idCauHoi && $r['kiem_tra'] == 0) {
                        echo '<div style="margin: 20px 0 0 0;" class="input-group mb-3">
                            <div class="input-group-text">
                                <input type="radio" disabled>
                            </div>
                            <input type="text" class="form-control" value="';
                        echo $r['ten_dap_an'];
                        echo '" readonly></div>';
                    }
                }
            }
            
            if ($loai == "Nhiều đáp án") {
                while ($r = mysqli_fetch_array($resultDapAn)) {
                    if ($r['id_cau_hoi'] == $idCauHoi && $r['kiem_tra'] == 1) {
                        echo '<div style="margin: 20px 0 0 0;" class="input-group mb-3">
                            <div class="input-group-text">
                                <input type="checkbox" checked disabled>
                            </div>
                            <input type="text" class="form-control" value="';
                        echo $r['ten_dap_an'];
                        echo '" readonly></div>';
                    }
                    if ($r['id_cau_hoi'] == $idCauHoi && $r['kiem_tra'] == 0) {
                        echo '<div style="margin: 20px 0 0 0;" class="input-group mb-3">
                            <div class="input-group-text">
                                <input type="checkbox" disabled>
                            </div>
                            <input type="text" class="form-control" value="';
                        echo $r['ten_dap_an'];
                        echo '" readonly></div>';
                    }
                }
            }
            ?>
        </div>
	</main>
    <?php include 'footer.php';?>
</body>
</html>