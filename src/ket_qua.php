<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Kết quả</title>
	<!-- Begin bootstrap cdn -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script src="calculate_completion_time.js"></script>
    <style>
        th, td {
            text-align: center;
        }
    </style>
</head>
<script>
        function calculateCompletionTime() {
            let minutes = localStorage.getItem('savedMinutes');
            let seconds = localStorage.getItem('savedSeconds');

            if (minutes !== null && seconds !== null) {
                let totalSecondsLapsed = (5 * 60) - (parseInt(minutes, 10) * 60 + parseInt(seconds, 10));
                let minutesLapsed = Math.floor(totalSecondsLapsed / 60);
                let secondsLapsed = totalSecondsLapsed % 60;

                return minutesLapsed + ' phút ' + secondsLapsed + ' giây';
            } else {
                return 'N/A'; // or any default value
            }
        }
    </script>
<body>
    <?php 
        include 'navbar.php';
        include '../role.php';
        $idKH = "";
        if (isset($_GET['id_khoa_hoc'])) {
            $idKH = $_GET['id_khoa_hoc'];
        }

        // kiểm tra đăng nhập chưa
		if (!isset($_SESSION['name'])) {
			header("Location: dang_nhap.php");
			exit;
		}

        if (checkRole($conn, $_SESSION['name'])) {
			header("Location: khoa_hoc.php");
			exit;
		}

        if (!isset($_SESSION['ket_qua_php'])) {
			header("Location: khoa_hoc.php");
			exit;
		}

        // ==================================
        unset($_SESSION['luyen_tap_php']);

        // nếu url sai thì không cho truy cập vào trang biên tập
        $query = "SELECT * FROM `khoa_hoc` WHERE `id_khoa_hoc` = '$idKH'";
        $result = $conn->query($query);
        if ($result->num_rows <= 0) {
            header("location: khoa_hoc.php");
            exit;
        }

        // ==================================
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
        <?php 
            if (!isset($_SESSION['ket_qua'])) {
                echo '<div class="alert alert-warning text-center" role="alert">Hệ thống chưa cập nhật đủ câu hỏi</div>';  
                echo '<a href="bien_tap.php?id_khoa_hoc='.$idKH.'" class="btn btn-outline-success">Trở lại</a>';
            }
            else {
                echo '<div id="action" style="margin: 20px 0 0 13%;">
                    <a href="bien_tap.php?id_khoa_hoc='.$idKH.'" class="btn btn-primary">Trở lại</a>
                </div>
                <div class="d-flex flex-wrap flex-column align-items-center" style="padding: 1%;margin: 5% 15% 0; ">
                    <p class="h3" style="margin-bottom: 30px;">KẾT QUẢ BÀI LÀM</p>
                    <table  class="table table-striped table-bordered">
                        <tr>
                                <th style="width: 25%;">Tên tài khoản</th>
                                <th style="width: 25%;">Thời điểm nộp bài</th>
                                <th style="width: 25%;">Thời gian hoàn thành</th> 
                                <th style="width: 25%;">Điểm của bạn</th>
                        </tr>
                        <tr>
                            <td>'.$_SESSION['name'].'</td>
                            <td>'.$_SESSION['gio'].'</td>
                            <td><script>document.write(calculateCompletionTime());</script></td>
                            <td>'.$_SESSION['diem'].'%</td>
                        </tr>
                    </table>
                </div>';
            }
        ?>
        
	</main>
    <?php include 'footer.php'; ?>
</body>
</html>