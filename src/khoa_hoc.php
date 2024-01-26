<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Khóa học</title>
	<!-- Begin bootstrap cdn -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<!-- End bootstrap cdn -->
	<style>
		.bg {
			background-color: #2A71B8;
			border-color: #2A71B8;
		}
		.bg:hover {
			background-color: #395F85;
			border-color: #395F85;
		}
	</style>
</head>
<body>
	<?php 
		include '../role.php';
		include 'navbar.php';
		// include '../connectdb.php';
		// thư mục chứa ảnh
		$dir = "../images/"; 

		// kiểm tra đăng nhập chưa
		if (!isset($_SESSION['name'])) {
			header("Location: dang_nhap.php");
			exit;
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

        if (isset($_SESSION['xoa_khoa_hoc_php'])) {
            unset($_SESSION['xoa_khoa_hoc_php']);
        }

        if (isset($_SESSION['xoa_tai_khoan_php'])) {
            unset($_SESSION['xoa_tai_khoan_php']);
        }
    ?>
	<main style="min-height: 100vh; width: 100%;">
		<div class="" style="text-align: center;"><h2>Khóa học</h2></div>
		<div class="row row-cols-1 row-cols-md-3 g-4" style="margin: 0 auto; width: 80%;">
		<!-- begin khóa học -->
		<?php 
			$sqlKH = "SELECT * FROM `khoa_hoc`";
			$resultKH = mysqli_query($conn, $sqlKH);
			while ($row = mysqli_fetch_array($resultKH)) {
				$idKH = $row['id_khoa_hoc'];
				$tenKH = $row['ten_kh'];
				$anhKH = $row['anh'];

				echo '<div class="col">
					<div class="card">
						<img src="'.$dir.$anhKH.'" class="card-img-top" style="height: 226px;" alt="Course Image">
						<div class="card-body">
						<h5 class="card-title">'.$tenKH.'</h5>
						<a class="btn btn-primary" href="bien_tap.php?id_khoa_hoc='.$idKH.'">Truy cập</a>
						</div>
					</div></div>';
			}
		?>
		<!-- end khóa học -->
		</div>
	</main>
	<?php include 'footer.php'; ?>
</body>
</html>