<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Đăng nhập</title>
	<!-- Begin bootstrap cdn -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<!-- End bootstrap cdn -->
</head>
<body>
	<?php
		include '../function.php';

		if (isset($_POST['submitLogin'])) {
			if (empty($_POST['username']) || empty($_POST['password'])) {
				echo '<div class="alert alert-danger text-center" role="alert">Vui lòng điền đầy đủ thông tin</div>';
			}
			else {
				$tk = $_POST['username'];
				$mk = md5($_POST['password']);
				if (checkLogin($conn, $tk, $mk)) {
					header('Location: khoa_hoc.php');
				}
				else {
					echo '<div class="alert alert-danger text-center" role="alert">Tài khoản hoặc mật khẩu không chính xác</div>';
				}
			}
		}
	?>
	<main style="min-height: 100vh; margin-top: 10%;">
		<div class="d-flex justify-content-center"><h1>Đăng nhập</h1></div>
		<div class="d-flex justify-content-center">
			<form class="w-25" method="POST">
				<div class="mb-3">
				  	<label for="username" class="form-label">Username</label>
				  	<input type="text" class="form-control" id="username" name="username" placeholder="Nhập username">
				</div>
				<div class="mb-3">
				    <label for="inputPassword" required class="col-sm-2 col-form-label">Password</label>
				    <div class="col">
				      	<input type="password" class="form-control" id="inputPassword" placeholder="Nhập Password" name="password">
				    </div>
				</div>
				<div class="mb-3" style="text-align: center;">
                    <input type="submit" class="btn btn-primary" name="submitLogin" value="Đăng nhập">
                </div>
			</form>
		</div>
	</main>
	<?php include 'footer.php'; ?>	
</body>
</html>