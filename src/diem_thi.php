<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Lịch sử bài làm</title>
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
        th, td {
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
        $idKH = "";
        if (isset($_GET['id_khoa_hoc'])) {
            $idKH = $_GET['id_khoa_hoc'];
        }
        $tenOnl = $_SESSION['name'];

        // kiểm tra đăng nhập chưa
		if (!isset($_SESSION['name'])) {
			header("Location: dang_nhap.php");
			exit;
		}

        if (checkRole($conn, $_SESSION['name'])) {
			// cấp quyền cho sang trang xóa khóa học
            $_SESSION['xoa_dt'] = 1;
		}

        $idus = "SELECT `id_user` FROM `user` WHERE `tai_khoan` = '$tenOnl'";
        $resultT = mysqli_query($conn, $idus);
        while ($rr = mysqli_fetch_array($resultT)) {
            $id = $rr[0];
        }

        // ========================================
        if (!isset($_SESSION['diem_thi_php'])) {
			header("Location: khoa_hoc.php");
			exit;
		}

        $_SESSION['xoa_diem_php'] = 1;

        $query = "SELECT * FROM `khoa_hoc` WHERE `id_khoa_hoc` = '$idKH'";
        $result = $conn->query($query);
        if ($result->num_rows <= 0) {
            unset($_SESSION['xoa_diem_php']);
            header("location: khoa_hoc.php");
            exit;
        }
        // ========================================
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
        <div id="action" style="margin: 20px 0 0 13%;">
            <a href="bien_tap.php?id_khoa_hoc=<?php echo $idKH;  ?>" class="btn btn-primary">Trở lại</a>
            <a href="#" class="btn btn-success" id="exportExcelBtn">Xuất Excel</a>
        </div>
        <div class="d-flex flex-wrap flex-column align-items-center" style="padding: 1%;margin: 5% 15% 0; ">
            <?php 
                if (checkRole($conn, $_SESSION['name'])) {
                    echo '<p class="h3">Danh sách điểm thi</p>';
                }
                else {
                    echo '<p class="h3">Lịch sử bài làm</p>';
                }
            ?>
            <table  class="table table-striped table-bordered">
                <?php 
                    if (checkRole($conn, $_SESSION['name'])) {
                        echo '<tr>
                            <th style="width: 10%;">STT</th>
                            <th style="width: 30%;">Tên tài khoản</th>
                            <th style="width: 40%;">Lịch sử</th>
                            <th style="width: 20%;">Thao tác</th>
                        </tr>';
                        
                        $layUser = "SELECT * FROM `user` WHERE `role` = 0";
                        $resultLU = mysqli_query($conn, $layUser);
                        $stt = 1;
                        while ($rlu = mysqli_fetch_array($resultLU)) {
                            $tenU = $rlu['tai_khoan'];
                            $idU = $rlu['id_user'];
                            $flag = true;

                            // tìm điểm cao nhất
                            $diemMax = "SELECT MAX(`diem`) AS `max` FROM `diem`
                            WHERE `id_user` = '$idU' AND `id_khoa_hoc` = '$idKH'";
                            $resultDM = mysqli_query($conn, $diemMax);
                            while ($rdm = mysqli_fetch_array($resultDM)) {
                                $max = $rdm['max'];
                            }

                            echo '<tr><td>'.$stt.'</td><td>'.$tenU.'</td><td>';
                            echo '<ol type="1">';
                            $diemSo = "SELECT * FROM `diem` WHERE `id_user` = '$idU' AND `id_khoa_hoc` = '$idKH'";
                            $resultDS = mysqli_query($conn, $diemSo);
                            // hiển thị
                            while ($row = mysqli_fetch_array($resultDS)) {
                                $diem = $row['diem'];
                                $gio = $row['thoi_gian_lam_bai'];
                                $flag = false;
                                if ($diem == $max) {
                                    echo '<li>'.$diem.'%<font color="red"> ('.$gio.')</font> <font color="green"> (Điểm cao nhất)</font></li>';
                                }
                                else {
                                    echo '<li>'.$diem.'%<font color="red"> ('.$gio.')</font></li>';
                                }
                            }
                            echo '</ol>';
                            if ($flag) {
                                echo 'Chưa có điểm';
                            }
                            echo '</td>
                            <td><button type="button" class="btn btn-danger">
                                <a href="xoa_diem.php?id_khoa_hoc='.$idKH.'&id_user='.$idU.'">Xóa điểm</a>
                            </button></td></tr>';

                            $stt++;
                        }
                    }
                    else {
                        $flag = true;
                        // tìm điểm cao nhất
                        $diemMax = "SELECT MAX(`diem`) AS `max` FROM `diem`
                        WHERE `id_user` = '$id' AND `id_khoa_hoc` = '$idKH'";
                        $resultDM = mysqli_query($conn, $diemMax);
                        while ($rdm = mysqli_fetch_array($resultDM)) {
                            $max = $rdm['max'];
                        }

                        echo '<tr>
                            <th style="width: 40%;">Tên tài khoản</th>
                            <th style="width: 60%;">Lịch sử</th>
                        </tr>';
                        echo '<tr><td>'.$tenOnl.'</td><td>';
                        echo '<ol type="1">';
                        $diemSo = "SELECT * FROM `diem` WHERE `id_user` = '$id' AND `id_khoa_hoc` = '$idKH'";
                        $resultDS = mysqli_query($conn, $diemSo);
                        while ($row = mysqli_fetch_array($resultDS)) {
                            $diem = $row['diem'];
                            $gio = $row['thoi_gian_lam_bai'];
                            $flag = false;
                            if ($diem == $max) {
                                echo '<li>'.$diem.'%<font color="red"> ('.$gio.')</font> <font color="green"> (Điểm cao nhất)</font></li>';
                            }
                            else {
                                echo '<li>'.$diem.'%<font color="red"> ('.$gio.')</font></li>';
                            }
                        }
                        echo '</ol>';
                        if ($flag) {
                            echo 'Chưa có điểm';
                        }
                        echo '</td></tr>';
                    }
                ?>
            </table>
        </div>
	</main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
        <script>
            document.getElementById('exportExcelBtn').addEventListener('click', function () {
               
                var wb = XLSX.utils.book_new();

                <?php
                if (checkRole($conn, $_SESSION['name'])) {
                    echo "var ws = XLSX.utils.table_to_sheet(document.querySelector('.table'));\n";
                    echo "XLSX.utils.book_append_sheet(wb, ws, 'Danh_sach_diem_thi');\n";
                } else {
                    echo "var ws = XLSX.utils.table_to_sheet(document.querySelector('.table'));\n";
                    echo "XLSX.utils.book_append_sheet(wb, ws, 'Lich_su_bai_lam');\n";
                }
                ?>

                XLSX.writeFile(wb, 'exported_data.xlsx');
            });
        </script>

    <?php include 'footer.php';?>
</body>
</html>