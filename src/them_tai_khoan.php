<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Thêm tài khoản</title>
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
		$array = [1,2,3];
		$loai = "";
        if (isset($_GET['loai'])) {
            $loai = $_GET['loai'];
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

		// ================================

        if (!isset($_SESSION['them_tai_khoan_php'])) {
			header("Location: khoa_hoc.php");
			exit;
		}

        if (!in_array($loai, $array)) {
			header("Location: khoa_hoc.php");
			exit;
		}

        // ================================

		function checkTontai($conn, $username) {
			$sql = "SELECT * FROM `user`";
			$result = mysqli_query($conn, $sql);
			while ($row = mysqli_fetch_array($result)) {
				$maUser = $row['id_user'];
				$tkUser = $row['tai_khoan'];
				$mkUser = $row['password'];
				
				if ($username == $tkUser) {
					return true;
				}
			}
			return false;
		}
	
		function signUp($conn, $username, $password, $quyen) {
			$nhap_query = "INSERT INTO `user`(`id_user`, `tai_khoan`, `password`, `role`) 
			VALUES (NULL,'$username','$password', '$quyen')";
			
			if (mysqli_query($conn, $nhap_query)) {
				echo '<div class="alert alert-success text-center" role="alert">Thêm tài khoản thành công</div>';
				// unset($_SESSION['them_tai_khoan_php']);
			} else {
				echo 'Error: ' . mysqli_error($conn);
			}
		}

        if (isset($_POST['submitSignup']) && ($loai == 1 || $loai == 2)) {
			if (empty(trim($_POST['username'])) || empty(trim($_POST['password'])) || empty(trim($_POST['retypePassword']))) {
				echo '<div class="alert alert-danger text-center" role="alert">Vui lòng nhập đầy đủ thông tin</div>';
			}
			else if (checkTontai($conn, $_POST['username'])) {
				echo '<div class="alert alert-danger text-center" role="alert">Tài khoản đã tồn tại</div>';
			}
			else {
				if ($_POST['password'] != $_POST['retypePassword']) {
					echo '<div class="alert alert-danger text-center" role="alert">Mật khẩu nhập lại không khớp</div>';
				}
				else {
					$pass = md5($_POST['password']);
					if ($loai == 1) {
						signUp($conn, $_POST['username'], $pass, 0);
					}
					if ($loai == 2) {
						signUp($conn, $_POST['username'], $pass, 1);
					}
				}
			}
        }
		if (isset($_POST['submitSignup']) && $loai == 3) {
			if (empty(trim($_POST['numberh'])) || empty(trim($_POST['numberf'])) || empty(trim($_POST['password'])) || empty(trim($_POST['retypePassword']))) {
				echo '<div class="alert alert-danger text-center" role="alert">Vui lòng nhập đầy đủ thông tin</div>';
			}
			else if ($_POST['numberh'] >= $_POST['numberf']) {
				echo '<div class="alert alert-danger text-center" role="alert">Số nhập vào không hợp lệ, số đầu phải nhỏ hơn số sau</div>';
			}
			else {
				$h = (int)$_POST['numberh'];
				$f = (int)$_POST['numberf'];
				$k = $f;
				$co = true;
				while ($k >= $h) {
					if (checkTontai($conn, $k)) {
						echo '<div class="alert alert-danger text-center" role="alert">Một số tài khoản đã tồn tại, vui lòng kiểm tra lại</div>';
						$co = false;
						break;
					}
					$k--;
				}
				
				if ($co) {
					if ($_POST['password'] != $_POST['retypePassword']) {
						echo '<div class="alert alert-danger text-center" role="alert">Mật khẩu nhập lại không khớp</div>';
					}
					else {
						$co2 = true;
						while ($f >= $h) {
							$pass = md5(trim($_POST['password']));
							$nhapHL = "INSERT INTO `user`(`id_user`, `tai_khoan`, `password`, `role`) 
							VALUES (NULL,'$h','$pass', '0')";
							if (!mysqli_query($conn, $nhapHL)) {
								$co2 = false;
								echo 'Error: ' . mysqli_error($conn);
								break;
							}
							$h++;
						}
						if ($co2) {
							echo '<div class="alert alert-success text-center" role="alert">Thêm nhiều tài khoản thành công, mật khẩu mặc định của các tài khoản là '.$_POST['password'].'</div>';
							// unset($_SESSION['them_tai_khoan_php']);
						}
					}
				}
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
			<?php 
			if ($loai == 1 || $loai == 2) {
				echo '<div class="form-group">
					<label for="name_quiz"><span style="color: red;">*</span>Nhập tài khoản: </label>
					<input class="form-control" type="text" name="username" id="username">
				</div>';
			}
			if ($loai == 3) {
				echo '<div class="form-group">
					<label for="name_quiz"><span style="color: red;">*</span>Nhập số đầu: </label>
					<input class="form-control" type="number" name="numberh" id="numberh">
				</div><div class="form-group">
					<label for="name_quiz"><span style="color: red;">*</span>Nhập số cuối: </label>
					<input class="form-control" type="number" name="numberf" id="numberf">
				</div>';
			}
			?>
			<div class="form-group">
				<label for="name_quiz"><span style="color: red;">*</span>Nhập mật khẩu: </label>
                <input type="password" class="form-control" id="inputPassword" name="password">
            </div>
			<div class="form-group">
				<label for="name_quiz"><span style="color: red;">*</span>Nhập lại mật khẩu: </label>
                <input type="password" class="form-control" id="inputPassword" name="retypePassword">
            </div>
            <div style="margin: 20px 0 0 0;" class="d-grid">
                <input class="btn btn-primary btn-block" name="submitSignup" type="submit" value="Thêm tài khoản">
            </div>
		</div>
			</form>
	</main>
	<?php include 'footer.php'; ?>
</body>
</html>