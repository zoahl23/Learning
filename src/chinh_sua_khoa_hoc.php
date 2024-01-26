<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Chỉnh sửa khóa học</title>
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
        $khoaHoc = "";
        if (isset($_GET['id_khoa_hoc'])) {
            $khoaHoc = $_GET['id_khoa_hoc'];
        }

        // kiểm tra đăng nhập chưa
		if (!isset($_SESSION['name'])) {
			header("Location: dang_nhap.php");
			exit;
		}

        if (!checkRole($conn, $_SESSION['name'])) {
			header("Location: khoa_hoc.php");
			exit;
		}

        // kiểm tra tên khóa học đã tồn tại hay chưa
        function checkTenKh($conn, $ten) {
            $sql = "SELECT * FROM `khoa_hoc`";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($result)) {
                $tkUser = $row['ten_kh'];
                
                if ($ten == $tkUser) {
                    return true;
                }
            }
            return false;
        }

        // ==========================

        if (!isset($_SESSION['chinh_sua_khoa_hoc_php'])) {
			header("Location: khoa_hoc.php");
			exit;
		}
        
        // cấp quyền cho sang trang xóa khóa học
        $_SESSION['xoa_khoa_hoc_php'] = 1;

        $query = "SELECT * FROM `khoa_hoc` WHERE `id_khoa_hoc` = '$khoaHoc'";
        $result = $conn->query($query);
        if ($result->num_rows <= 0) {
            unset($_SESSION['xoa_khoa_hoc_php']);
            header("location: khoa_hoc.php");
            exit;
        }
        else {
            $tenkhSql = "SELECT `ten_kh` FROM `khoa_hoc` WHERE `id_khoa_hoc` = '$khoaHoc'";
            $resultKH = mysqli_query($conn, $tenkhSql);
            while ($row = mysqli_fetch_array($resultKH)) {
                $tenKH = $row[0];
            }
        }

        // ========================================
    ?>
    <?php 
        // khong cho truy cap vao trang

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
		<div id="action" style="margin: 20px 0 0 13%;">
			<a href="bien_tap.php?id_khoa_hoc=<?php echo $khoaHoc; ?>" class="btn btn-primary">Trở lại</a>
            <form action="" method="POST" enctype="multipart/form-data">
		</div>
        <div style="margin: 20px 13%;">
            <div class="form-group">
                <label for="name_quiz"><span style="color: red;"></span>Sửa tên khóa học</label>
                <input class="form-control" type="text" name="ten_khoa_hoc" id="" value="<?php if (isset($_POST['ten_khoa_hoc'])) { echo $_POST['ten_khoa_hoc'];} else {echo $tenKH;} ?>">
            </div>
            <div class="form-group">
                <label for="name_quiz">Đổi ảnh nền mới</label>
                <input class="form-control" type="file" name="file_tai_len" id="">
            </div>
            <div style="margin: 20px 0 0 0;" class="d-grid">
                <input class="btn btn-primary btn-block" name="btn" type="submit" value="Chỉnh sửa">
            </div>
            <div style="margin: 20px 0 0 0;" class="d-grid">
                <a class="btn btn-danger" href="xoa_khoa_hoc.php?id_khoa_hoc=<?php echo $khoaHoc; ?>">Xóa khóa học</a>
            </div>
            <?php
                // đuôi file được phép lưu
                $arr = ['png', 'jpg', 'jpeg', 'svg'];
                // thư mục lưu file ảnh
                $dir = '../images/';
                // quét toàn bộ thư mục
                $arrFile = scandir($dir);

                if (isset($_POST['btn'])) {
                    // lưu file ảnh
                    $duoiFile = strtolower(pathinfo($_FILES['file_tai_len']['name'], PATHINFO_EXTENSION));
                    $tmp = $_FILES['file_tai_len']['tmp_name'];
                    if (in_array($duoiFile, $arr)) {
                        // lấy địa chỉ ảnh cũ
                        $anhKhoaHoc = "SELECT * FROM `khoa_hoc` WHERE `id_khoa_hoc` = '$khoaHoc'";
                        $resultKH = mysqli_query($conn, $anhKhoaHoc);
                        while ($row = mysqli_fetch_array($resultKH)) {
                            $tenAnh = $row['anh'];
                            $diaChiAnh = $dir.$tenAnh;
                        }
                        // xóa ảnh cũ
                        foreach ($arrFile as $key => $value) {
                            if ($tenAnh == $value) {
                                unlink($diaChiAnh);
                            }
                        }

                        $i = 0;
                        // nơi lưu file ảnh
                        $dirAnh = $dir.$_FILES['file_tai_len']['name'];
                        $anhNew = $_FILES['file_tai_len']['name'];

                        // kiểm tra file ảnh đã tồn tại trong thư mục chưa
                        while (file_exists($dirAnh)) {
                            $i++;
                            $dauFile = pathinfo($_FILES['file_tai_len']['name'], PATHINFO_FILENAME);
                            $anhNew = $dauFile."($i).".$duoiFile;
                            $dirAnh = $dir.$anhNew;
                        }

                        $flag = move_uploaded_file($tmp, $dirAnh);

                        // lưu vào csdl

                        $suaAnh = "UPDATE `khoa_hoc` SET `anh` = '$anhNew' WHERE `id_khoa_hoc` = '$khoaHoc'";
                        if (mysqli_query($conn, $suaAnh)) {
                            echo '<div class="alert alert-success text-center" style="margin-top: 20px; role="alert">Cập nhật ảnh thành công</div>';
                        } else {
                            echo 'Error: ' . mysqli_error($conn);
                        }

                    }
                        // else {
                        //     echo '<div class="alert alert-warning text-center" style="margin-top: 20px; role="alert">Hệ thống không hỗ trợ tệp không phải ảnh</div>';
                        // }

                    if (!empty(trim($_POST['ten_khoa_hoc']))) {
                        $tkh = trim($_POST['ten_khoa_hoc']);
                        if (checkTenKh($conn, $tkh)) {
                            echo '<div class="alert alert-warning text-center" role="alert">Tên khóa học đã tồn tại</div>';
                        }
                        else {
                            $suaTen = "UPDATE `khoa_hoc` SET `ten_kh` = '$tkh' WHERE `id_khoa_hoc` = '$khoaHoc'";
                            if (mysqli_query($conn, $suaTen)) {
                                echo '<div class="alert alert-success text-center" style="margin-top: 20px; role="alert">Cập nhật tên thành công</div>';
                            } else {
                                echo 'Error: ' . mysqli_error($conn);
                            }
                        }            
                    }
                    else {
                        echo '<div class="alert alert-warning text-center" role="alert">Vui lòng nhập tên khóa học</div>';
                    }
                }    
            ?>
        </div>
        </form>
	</main>
    <?php include 'footer.php';?>
</body>
</html>