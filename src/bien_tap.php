<?php 
    //include '../function.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Biên tập</title>
	<!-- Begin bootstrap cdn -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<!-- End bootstrap cdn -->
    <style>
        img{
            max-width: 400px;
        }
        a{
            text-decoration: none;
            color: white;
        }
        a:hover {
            color: white;
        }
        .tach {
            margin: 8px 0px;
        }
        th {
            text-align: center;
        }
        td {
            overflow: hidden;
        }
    </style>
</head>
<body>
    <?php 
        include 'navbar.php';
        include '../connectdb.php';
        include '../role.php';
        $dir = "../images/";
        $khoaHoc = "";
        if (isset($_GET['id_khoa_hoc'])) {
            $khoaHoc = $_GET['id_khoa_hoc'];
        }

        // kiểm tra đăng nhập chưa
		if (!isset($_SESSION['name'])) {
			header("Location: dang_nhap.php");
			exit;
		}

        // =======================

        // nếu url sai thì không cho truy cập vào trang biên tập
        $query = "SELECT * FROM `khoa_hoc` WHERE `id_khoa_hoc` = '$khoaHoc'";
        $result = $conn->query($query);
        if ($result->num_rows <= 0) {
            header("location: khoa_hoc.php");
            exit;
        }

        $_SESSION['xem_truoc_php'] = 1;
        $_SESSION['xoa_cau_hoi_php'] = 1;
        $_SESSION['chinh_sua_khoa_hoc_php'] = 1;
        $_SESSION['diem_thi_php'] = 1;
        $_SESSION['them_cau_hoi_php'] = 1;
        $_SESSION['luyen_tap_php'] = 1;
    ?>
    <?php 
        // khong cho truy cap vao trang

        if (isset($_SESSION['chinh_sua_tai_khoan_php'])) {
            unset($_SESSION['chinh_sua_tai_khoan_php']);
        }

        if (isset($_SESSION['ket_qua_php'])) {
            unset($_SESSION['ket_qua_php']);
        }

        if (isset($_SESSION['them_tai_khoan_php'])) {
            unset($_SESSION['them_tai_khoan_php']);
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
                    $tenkhSql = "SELECT `ten_kh` FROM `khoa_hoc` WHERE `id_khoa_hoc` = '$khoaHoc'";
                    $resultKH = mysqli_query($conn, $tenkhSql);
                    while ($row = mysqli_fetch_array($resultKH)) {
                        echo $row[0];
                    }
                ?>
            </p>
            <a href="khoa_hoc.php" class="btn btn-primary">Trở lại</a>
                <?php
                    // phân quyền
                    if (checkRole($conn, $_SESSION['name'])) {
                        echo '<a href="chinh_sua_khoa_hoc.php?id_khoa_hoc='.$khoaHoc.'" class="btn btn-primary">Chỉnh sửa khóa học</a>';
                        echo '<a href="diem_thi.php?id_khoa_hoc='.$khoaHoc.'" class="btn btn-primary" style="margin-left: 4px;">Điểm thi</a>';
                    }
                    else {
                        echo '<a href="luyen_tap.php?id_khoa_hoc='.$khoaHoc.'" class="btn btn-primary">Luyện tập</a>';
                        echo '<a href="diem_thi.php?id_khoa_hoc='.$khoaHoc.'" class="btn btn-primary" style="margin-left: 4px;">Lịch sử bài làm</a>';
                    }
                ?>
            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">Thêm câu hỏi</button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="<?php echo "them_cau_hoi.php?id_khoa_hoc=$khoaHoc&loai_cau_hoi=1" ?>" >Câu hỏi điền</a></li>
                <li><a class="dropdown-item tach" href="<?php echo "them_cau_hoi.php?id_khoa_hoc=$khoaHoc&loai_cau_hoi=2" ?>" >Câu hỏi một đáp án</a></li>
                <li><a class="dropdown-item" href="<?php echo "them_cau_hoi.php?id_khoa_hoc=$khoaHoc&loai_cau_hoi=3" ?>" >Câu hỏi nhiều đáp án</a></li>
            </ul>
        </div>
        <div class="d-flex flex-wrap flex-column align-items-center" style="padding: 1%;margin: 5% 0 0 0; ">
            <p class="h3">Danh sách câu hỏi</p>
            <table  class="table table-striped table-bordered">
                <tr>
                    <th style="width: 3%;">STT</th>
                    <th style="width: 20%;">Tên câu hỏi</th>
                    <th style="width: 9%;">Loại câu hỏi</th>
                    <th style="width: 20%;">Đáp án</th>
                    <th style="width: 8%;">Tác giả</th>
                    <th style="width: 8%;">Trạng thái</th>
                    <th style="width: 22%;">Thao tác</th> 
                </tr>
                <?php 
                    $cauHoiSql = "SELECT * FROM `cau_hoi`";
                    $resultCauHoi = mysqli_query($conn, $cauHoiSql);

                    $stt = 0;
                    $stt2 = 1;
                    $flag = false;
                    while ($row = mysqli_fetch_array($resultCauHoi)) {
                        if ($row['id_khoa_hoc'] == $khoaHoc) {
                            $stt++;
                            $ten = $row['ten_cau_hoi'];
                            $loai = $row['loai_cau_hoi'];
                            $idCauHoi = $row['id_cau_hoi'];
                            $tenAnh = $row['anh_cau_hoi'];
                            $diaChiAnh = $dir.$tenAnh;

                            // lấy đáp án
                            $dapAnSql = "SELECT * FROM `dap_an`";
                            $resultDapAn = mysqli_query($conn, $dapAnSql);

                            // trạng thái câu hỏi
                            if ($row['trang_thai'] == 1) {
                                $trangThai = "Đã duyệt";
                            }
                            else {
                                $trangThai = "Chưa duyệt";
                            }   

                            // lấy tên tác giả
                            $idAuthor = $row['id_user'];
                            $tenUserSql = "SELECT `tai_khoan` FROM `user` WHERE `id_user` = '$idAuthor'";
                            $resultUser = mysqli_query($conn, $tenUserSql);
                            while ($r = mysqli_fetch_array($resultUser)) {
                                $author = $r[0];
                            }

                            // nếu là admin thì hiển thị hết câu hỏi
                            if (checkRole($conn, $_SESSION['name'])) {
                                $flag = true;
                                // hiển thị hàng
                                echo '<tr><td style="text-align: center;">'.$stt.'</td>
                                    <td>'.$ten.'<br>';
                                    // trả về kèm theo ảnh nếu có
                                    if ($tenAnh != "" ) {
                                        echo '<div style="margin: 10px 0 0" class="form-group"><img src="'.$diaChiAnh.'" height="200px"></div>';
                                    }
                                echo '</td><td style="text-align: center;">'.$loai.'</td><td>';
                                    // các đáp án
                                    if ($loai != "Điền") {
                                        echo '<ol type="A">';
                                        while ($r = mysqli_fetch_array($resultDapAn)) {
                                            if ($r['id_cau_hoi'] == $idCauHoi && $r['kiem_tra'] == 1) {
                                                echo '<li>'.$r['ten_dap_an'].' <font color="green">( đáp án đúng )</font></li>';
                                            }
                                            if ($r['id_cau_hoi'] == $idCauHoi && $r['kiem_tra'] == 0) {
                                                echo '<li>'.$r['ten_dap_an'].'</li>';
                                            }
                                        }
                                        echo '</ol>';
                                    }
                                    else {
                                        while ($r = mysqli_fetch_array($resultDapAn)) {
                                            if ($r['id_cau_hoi'] == $idCauHoi && $r['kiem_tra'] == 1) {
                                                echo '<div style="padding-left: 16px;">'.$r['ten_dap_an'].'</div>';
                                            }
                                        }
                                    }
                                    
                                echo '</td><td style="text-align: center;">'.$author.'</td>
                                    <td style="text-align: center;">'.$trangThai.'</td>';
                                    if ($row['trang_thai'] == 0) {
                                        echo '<td style="text-align: center;"><form method="post">
                                        <button type="button" class="btn btn-info">
                                            <a href="xem_truoc.php?id_khoa_hoc='.$khoaHoc.'&id_cau_hoi='.$idCauHoi.'">Xem trước</a>
                                        </button>
                                        <button type="submit" class="btn btn-success" name="duyet" value="'.$idCauHoi.'">Duyệt</button>
                                        <button type="button" class="btn btn-danger">
                                            <a href="xoa_cau_hoi.php?id_khoa_hoc='.$khoaHoc.'&id_cau_hoi='.$idCauHoi.'">Xóa</a>
                                        </button></td></form></tr>';
                                    }
                                    else {
                                        echo '<td style="text-align: center;">
                                        <button type="button" class="btn btn-info">
                                            <a href="xem_truoc.php?id_khoa_hoc='.$khoaHoc.'&id_cau_hoi='.$idCauHoi.'">Xem trước</a>
                                        </button>
                                        <button type="button" class="btn btn-danger">
                                            <a href="xoa_cau_hoi.php?id_khoa_hoc='.$khoaHoc.'&id_cau_hoi='.$idCauHoi.'">Xóa</a>
                                        </button></td></tr>';
                                    }
                            }
                            // nếu ko là admin thì chỉ hiển thị đúng câu hỏi của mình
                            else if ( $_SESSION['name'] == $author) {
                                $flag = true;
                                echo '<tr><td style="text-align: center;">'.$stt2.'</td>
                                    <td>'.$ten.'<br>';
                                    if ($tenAnh != "" ) {
                                        echo '<div class="form-group"><img src="'.$diaChiAnh.'" height="200px"></div>';
                                    }
                                echo '</td><td style="text-align: center;">'.$loai.'</td><td>';
                                    // các đáp án
                                    if ($loai != "Điền") {
                                        echo '<ol type="A">';
                                        while ($r = mysqli_fetch_array($resultDapAn)) {
                                            if ($r['id_cau_hoi'] == $idCauHoi && $r['kiem_tra'] == 1) {
                                                echo '<li>'.$r['ten_dap_an'].' <font color="green">( đáp án đúng )</font></li>';
                                            }
                                            if ($r['id_cau_hoi'] == $idCauHoi && $r['kiem_tra'] == 0) {
                                                echo '<li>'.$r['ten_dap_an'].'</li>';
                                            }
                                        }
                                        echo '</ol>';
                                    }
                                    else {
                                        while ($r = mysqli_fetch_array($resultDapAn)) {
                                            if ($r['id_cau_hoi'] == $idCauHoi && $r['kiem_tra'] == 1) {
                                                echo '<div style="padding-left: 16px;">'.$r['ten_dap_an'].'</div>';
                                            }
                                        }
                                    }
                                echo '</td><td style="text-align: center;">'.$author.'</td>
                                    <td style="text-align: center;">'.$trangThai.'</td>
                                    <td style="text-align: center;">
                                        <button type="button" class="btn btn-info">
                                            <a href="xem_truoc.php?id_khoa_hoc='.$khoaHoc.'&id_cau_hoi='.$idCauHoi.'">Xem trước</a>
                                        </button>
                                    </td></tr>';
                                $stt2++;
                            }
                        }
                    }
                    if (!$flag) {
                        echo '<tr><td align="center" colspan="7">Không có câu hỏi nào</td></tr>';
                    }

                    // Khi nhấn vào bất cứ nút duyệt nào
                    if (isset($_POST['duyet'])) {
                        // lấy id câu hỏi
                        $idDuyet = $_POST['duyet'];
                        // cập nhật
                        $trangThaiSql = "UPDATE `cau_hoi` SET `trang_thai` = '1' WHERE `id_cau_hoi` = '$idDuyet'";
                        if (mysqli_query($conn, $trangThaiSql)) {
                            echo '<script type="text/javascript">
                                window.location.href = "bien_tap.php?id_khoa_hoc='.$khoaHoc.'";
                            </script>';
                        } else {
                            echo 'Error: ' . mysqli_error($conn);
                        }
                    }
                ?>
            </table>
        </div>
	</main>
    <?php include 'footer.php'; ?>
</body>
</html>