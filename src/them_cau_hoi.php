<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Thêm câu hỏi</title>
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
        $id = "";
        $loai = "";
        $array = [1, 2, 3];
        if (isset($_GET['id_khoa_hoc']) && isset($_GET['loai_cau_hoi'])) {
            $id = $_GET['id_khoa_hoc'];
            $loai = $_GET['loai_cau_hoi'];
        }

        // kiểm tra đăng nhập chưa
		if (!isset($_SESSION['name'])) {
			header("Location: dang_nhap.php");
			exit;
		}

        // ========================================
        if (!isset($_SESSION['them_cau_hoi_php'])) {
			header("Location: khoa_hoc.php");
			exit;
		}

        $query = "SELECT * FROM `khoa_hoc` WHERE `id_khoa_hoc` = '$id'";
        $result = $conn->query($query);
        if ($result->num_rows <= 0 || !in_array($loai, $array)) {
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

        if (isset($_SESSION['diem_thi_php'])) {
            unset($_SESSION['diem_thi_php']);
        }

        if (isset($_SESSION['ket_qua_php'])) {
            unset($_SESSION['ket_qua_php']);
        }

        if (isset($_SESSION['luyen_tap_php'])) {
            unset($_SESSION['luyen_tap_php']);
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
		<div id="action" style="margin: 20px 0 0 13%;"><p class="h3">Khóa học 
            <!-- tên khóa học -->
            <?php 
                $sql = "SELECT `ten_kh` FROM `khoa_hoc` WHERE `id_khoa_hoc` = '$id'";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_array($result)) {
                    echo $row[0];
                }
            ?></p>
			<a href="<?php echo "bien_tap.php?id_khoa_hoc=$id" ?>" class="btn btn-primary">Trở lại</a>
            <form action="" method="POST" enctype="multipart/form-data">
		</div>
        <div style="margin: 20px 13%;">
            <div class="form-group">
                <label for="name_quiz"><span style="color: red;">*</span>Nhập tên câu hỏi</label>
                <input class="form-control"  type="text" name="ten_cau_hoi" id="" value='<?php if(isset($_POST['ten_cau_hoi']) && !empty($_POST['ten_cau_hoi'])) echo $_POST['ten_cau_hoi']; ?>'>
            </div>
            <div class="form-group">
                <label for="name_quiz">Ảnh cho câu hỏi</label>
                <input class="form-control" type="file" name="file_tai_len" id="">
            </div>
            <?php 
                if ($loai == 1) {
                    echo '<div class="form-group">
                        <label for="name_quiz">Dạng câu hỏi</label>
                        <input class="form-control" value="Điền" readonly  type="text" name="dang_cau_hoi" id="">
                    </div>
                    <div style="margin: 20px 0 0 0;" class="input-group mb-3">   
                        <input name="da" type="text" class="form-control" placeholder="Nhập đáp án" value="';
                    if (isset($_POST["da"]) && !empty($_POST["da"])) echo $_POST["da"];
                    echo '"></div>';
                }
                if ($loai == 2) {
                    echo '<div class="form-group">
                        <label for="name_quiz">Dạng câu hỏi</label>
                        <input class="form-control" value="Một đáp án" readonly  type="text" name="dang_cau_hoi" id="">
                    </div>
                    <div class="form-group">
                        <label for="name_quiz"><span style="color: red;">*</span>Nhập số lượng đáp án</label>
                        <input class="form-control"  type="number" name="so_dap_an" id="" value="';
                    if (isset($_POST['so_dap_an']) && !empty($_POST['so_dap_an'])) echo $_POST['so_dap_an']; 
                    echo '"></div>';

                    if (!empty($_POST['so_dap_an'])) {
                        for ($i = 0; $i < $_POST['so_dap_an']; $i++) {
                            echo '<div style="margin: 20px 0 0 0;" class="input-group mb-3">
                                <div class="input-group-text">
                                    <input type="radio" name="dapAn" value="'.$i.'" ';
                                if (isset($_POST['dapAn']) && ($_POST['dapAn'] === $i)) { echo "checked";} 
                            echo '></div><input type="text" class="form-control" name="textDapAn'.$i.'" value="';
                                if (isset($_POST['textDapAn'.$i]) && !empty($_POST['textDapAn'.$i])) { echo $_POST['textDapAn'.$i]; }
                            echo '"></div>';
                        }
                    }
                }
                if ($loai == 3) {
                    echo '<div class="form-group">
                        <label for="name_quiz">Dạng câu hỏi</label>
                        <input class="form-control" value="Nhiều đáp án" readonly  type="text" name="dang_cau_hoi" id="">
                    </div>
                    <div class="form-group">
                        <label for="name_quiz"><span style="color: red;">*</span>Nhập số lượng đáp án</label>
                        <input class="form-control"  type="number" name="so_dap_an" id="" value="';
                        if (isset($_POST['so_dap_an']) && !empty($_POST['so_dap_an'])) echo $_POST['so_dap_an']; 
                    echo '"></div>';
                    if (!empty($_POST['so_dap_an'])) {
                        for ($i = 0; $i < $_POST['so_dap_an']; $i++) {
                            echo '<div style="margin: 20px 0 0 0;" class="input-group mb-3">
                                <div class="input-group-text">
                                    <input type="checkbox" name="'.$i.'" value=""';
                                if (isset($_POST[$i])) { echo "checked";}
                            echo '></div><input type="text" class="form-control" name="textDapAn'.$i.'" value="';
                                if (isset($_POST['textDapAn'.$i]) && !empty($_POST['textDapAn'.$i])) { echo $_POST['textDapAn'.$i]; }
                            echo '"></div>';
                        }
                    }
                }
            ?>
            <?php
                // đuôi file được phép lưu
                $arr = ['png', 'jpg', 'jpeg', 'svg'];

                // thư mục lưu file ảnh
                $dir = '../images/';

                // lấy id user 
                $name = $_SESSION['name'];
                $sql = "SELECT `id_user` FROM `user` WHERE `tai_khoan` = '$name'";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_array($result)) {
                    $idUser = $row[0];
                }

                // chỉnh trạng thái nếu là admin thêm thì duyệt luôn
                $tt = 0;
                if (checkRole($conn, $_SESSION['name'])) {
                    $tt = 1;
                }

                // thêm câu hỏi điền
                if (isset($_POST['btn']) && $loai == 1) {
                    if (empty(trim($_POST['ten_cau_hoi']))) {
                        echo '<div class="alert alert-warning text-center" role="alert">Vui lòng nhập tên câu hỏi</div>';
                    }
                    else if (empty(trim($_POST['da']))) {
                        echo '<div class="alert alert-warning text-center" role="alert">Vui lòng nhập đáp án</div>';
                    }
                    else {
                        $tch = $_POST['ten_cau_hoi'];
                        $lch = $_POST['dang_cau_hoi'];
                        $da = $_POST['da'];
                        $kh = $_GET['id_khoa_hoc'];
                        // lưu file ảnh
                        $duoiFile = strtolower(pathinfo($_FILES['file_tai_len']['name'], PATHINFO_EXTENSION));
                        $tmp = $_FILES['file_tai_len']['tmp_name'];
                        if (in_array($duoiFile, $arr)) {
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

                            // lưu vào csdl nếu có ảnh

                            $nhapCauHoi = "INSERT INTO `cau_hoi`(`id_cau_hoi`, `ten_cau_hoi`, `loai_cau_hoi`, `anh_cau_hoi`, `trang_thai`, `id_user`, `id_khoa_hoc`) 
                            VALUES (NULL,'$tch','$lch', '$anhNew', '$tt','$idUser','$kh')";
                                
                            if (mysqli_query($conn, $nhapCauHoi)) {

                            // lấy id cuối cùng được chèn
                                $idch = mysqli_insert_id($conn);

                                $nhapDapAn = "INSERT INTO `dap_an`(`id_dap_an`, `ten_dap_an`, `kiem_tra`, `id_cau_hoi`) 
                                VALUES (NULL,'$da','1','$idch')";

                                if (mysqli_query($conn, $nhapDapAn)) {
                                    echo '<div class="alert alert-success text-center" role="alert">Thêm câu hỏi thành công</div>';
                                    unset($_SESSION['them_cau_hoi_php']);
                                }
                                else {
                                    echo 'Error: ' . mysqli_error($conn);
                                }
                            }
                            else {
                                echo 'Error: ' . mysqli_error($conn);
                            }
                        }
                        else if (!empty($tmp)) {
                            echo '<div class="alert alert-warning text-center" role="alert">Hệ thống không hỗ trợ tệp không phải ảnh</div>';
                        }
                        else {                        
                            
                            // lưu vào csdl nếu không có ảnh

                            $nhapCauHoi = "INSERT INTO `cau_hoi`(`id_cau_hoi`, `ten_cau_hoi`, `loai_cau_hoi`, `anh_cau_hoi`, `trang_thai`, `id_user`, `id_khoa_hoc`) 
                            VALUES (NULL,'$tch','$lch', '', '$tt','$idUser','$kh')";
                            
                            if (mysqli_query($conn, $nhapCauHoi)) {

                                // lấy id cuối cùng được chèn
                                $idch = mysqli_insert_id($conn);

                                $nhapDapAn = "INSERT INTO `dap_an`(`id_dap_an`, `ten_dap_an`, `kiem_tra`, `id_cau_hoi`) 
                                VALUES (NULL,'$da','1','$idch')";

                                if (mysqli_query($conn, $nhapDapAn)) {
                                    echo '<div class="alert alert-success text-center" role="alert">Thêm câu hỏi thành công</div>';
                                    unset($_SESSION['them_cau_hoi_php']);
                                }
                                else {
                                    echo 'Error: ' . mysqli_error($conn);
                                }
                            }
                            else {
                                echo 'Error: ' . mysqli_error($conn);
                            }
                        }
                    }
                }
                // thêm câu hỏi 1 hoặc nhiều đáp án
                if (isset($_POST['btn']) && ($loai == 2 || $loai == 3)) {        
                    if (empty(trim($_POST['ten_cau_hoi']))) {
                        echo '<div class="alert alert-warning text-center" role="alert">Vui lòng nhập tên câu hỏi</div>';
                    }
                    else if (empty(trim($_POST['so_dap_an']))) {
                        echo '<div class="alert alert-warning text-center" role="alert">Vui lòng nhập số lượng đáp án</div>';
                    }
                    else {
                        // lưu file ảnh
                        $ktrAnh = false;
                        $duoiFile = strtolower(pathinfo($_FILES['file_tai_len']['name'], PATHINFO_EXTENSION));
                        $tmp = $_FILES['file_tai_len']['tmp_name'];
                        if (in_array($duoiFile, $arr)) {
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

                            $ktrAnh = true;
                        }
                        else if (!empty($tmp)) {
                            echo '<div class="alert alert-warning text-center" role="alert">Hệ thống không hỗ trợ tệp không phải ảnh</div>';
                        }
                        else {
                            $ktrAnh = false;                            
                        }
                        // thêm câu hỏi 1 đáp án
                        if ($loai == 2) {
                            $check = true;
                            for ($j = 0; $j < $_POST['so_dap_an']; $j++) {
                                if (empty($_POST['textDapAn'.$j])) {
                                    echo '<div class="alert alert-warning text-center" role="alert">Vui lòng nhập đầy đủ đáp án</div>';
                                    $check = false;
                                    break;
                                }
                            }
                            if ($check) {
                                if (!isset($_POST['dapAn'])) {
                                    echo '<div class="alert alert-warning text-center" role="alert">Vui lòng chọn đáp án đúng</div>';
                                }
                                else {
                                    $tch = $_POST['ten_cau_hoi'];
                                    $lch = $_POST['dang_cau_hoi'];
                                    $kh = $_GET['id_khoa_hoc'];
                                    $soDapAn = $_POST['so_dap_an'];

                                    // vị trí đáp án đúng
                                    $viTri = $_POST['dapAn'];
        
                                    if ($ktrAnh) {
                                            
                                        $flag = move_uploaded_file($tmp, $dirAnh);

                                        // lưu vào csdl nếu có ảnh

                                        $nhapCauHoi = "INSERT INTO `cau_hoi`(`id_cau_hoi`, `ten_cau_hoi`, `loai_cau_hoi`, `anh_cau_hoi`, `trang_thai`, `id_user`, `id_khoa_hoc`) 
                                        VALUES (NULL,'$tch','$lch', '$anhNew', '$tt','$idUser','$kh')";
                                            
                                        if (mysqli_query($conn, $nhapCauHoi)) {

                                            // lấy id cuối cùng được chèn
                                            $idch = mysqli_insert_id($conn);

                                            $co = false;
                                            for ($j = 0; $j < $soDapAn; $j++) {
                                                $da = $_POST['textDapAn'.$j];
                                                if ($viTri == $j) {
                                                    $nhapDapAn = "INSERT INTO `dap_an`(`id_dap_an`, `ten_dap_an`, `kiem_tra`, `id_cau_hoi`) 
                                                    VALUES (NULL,'$da','1','$idch')";
                                                }
                                                else {
                                                    $nhapDapAn = "INSERT INTO `dap_an`(`id_dap_an`, `ten_dap_an`, `kiem_tra`, `id_cau_hoi`) 
                                                    VALUES (NULL,'$da','0','$idch')";
                                                }

                                                if (mysqli_query($conn, $nhapDapAn)) {
                                                    $co = true;
                                                }
                                                else {
                                                    echo 'Error: ' . mysqli_error($conn);
                                                    break;
                                                }
                                            }
                                            if ($co) {
                                                echo '<div class="alert alert-success text-center" role="alert">Thêm câu hỏi thành công</div>';
                                                unset($_SESSION['them_cau_hoi_php']);
                                            }
                                        }
                                        else {
                                            echo 'Error: ' . mysqli_error($conn);
                                        }
                                    }
                                    else {
                                
                                        // lưu vào csdl nếu không có ảnh

                                        $nhapCauHoi = "INSERT INTO `cau_hoi`(`id_cau_hoi`, `ten_cau_hoi`, `loai_cau_hoi`, `anh_cau_hoi`, `trang_thai`, `id_user`, `id_khoa_hoc`) 
                                        VALUES (NULL,'$tch','$lch', '', '$tt','$idUser','$kh')";

                                        if (mysqli_query($conn, $nhapCauHoi)) {

                                            // lấy id cuối cùng được chèn
                                            $idch = mysqli_insert_id($conn);

                                            $co = false;
                                            for ($j = 0; $j < $soDapAn; $j++) {
                                                $da = $_POST['textDapAn'.$j];
                                                if ($viTri == $j) {
                                                    $nhapDapAn = "INSERT INTO `dap_an`(`id_dap_an`, `ten_dap_an`, `kiem_tra`, `id_cau_hoi`) 
                                                    VALUES (NULL,'$da','1','$idch')";
                                                }
                                                else {
                                                    $nhapDapAn = "INSERT INTO `dap_an`(`id_dap_an`, `ten_dap_an`, `kiem_tra`, `id_cau_hoi`) 
                                                    VALUES (NULL,'$da','0','$idch')";
                                                }

                                                if (mysqli_query($conn, $nhapDapAn)) {
                                                    $co = true;
                                                }
                                                else {
                                                    echo 'Error: ' . mysqli_error($conn);
                                                    break;
                                                }
                                            }
                                            if ($co) {
                                                echo '<div class="alert alert-success text-center" role="alert">Thêm câu hỏi thành công</div>';
                                                unset($_SESSION['them_cau_hoi_php']);
                                            }
                                        }
                                        else {
                                            echo 'Error: ' . mysqli_error($conn);
                                        }
                                    }
                                        
                                }
                            }
                        }

                        // Câu hỏi nhiều đáp án
                        if ($loai == 3) {
                            $check = true;
                            for ($j = 0; $j < $_POST['so_dap_an']; $j++) {
                                if (empty($_POST['textDapAn'.$j])) {
                                    echo '<div class="alert alert-warning text-center" role="alert">Vui lòng nhập đầy đủ đáp án</div>';
                                    $check = false;
                                    break;
                                }
                            }
                            if ($check) {
                                // vị trí đáp án đúng
                                $array=array();
                                foreach ($_POST as $key => $value) {
                                    for ($i = 0; $i < $_POST['so_dap_an']; $i++) {
                                        if ($key == $i) {
                                            array_push($array,$key);
                                        }
                                    }
                                }
                                if (empty($array)) {
                                    echo '<div class="alert alert-warning text-center" role="alert">Vui lòng chọn đáp án đúng</div>';
                                }
                                else {
                                    $tch = $_POST['ten_cau_hoi'];
                                    $lch = $_POST['dang_cau_hoi'];
                                    $kh = $_GET['id_khoa_hoc'];
                                    $soDapAn = $_POST['so_dap_an'];
                                        
                                    if ($ktrAnh) {
                                        
                                        $flag = move_uploaded_file($tmp, $dirAnh);

                                        // lưu vào csdl nếu có ảnh

                                        $nhapCauHoi = "INSERT INTO `cau_hoi`(`id_cau_hoi`, `ten_cau_hoi`, `loai_cau_hoi`, `anh_cau_hoi`, `trang_thai`, `id_user`, `id_khoa_hoc`) 
                                        VALUES (NULL,'$tch','$lch', '$anhNew', '$tt','$idUser','$kh')";
                                            
                                        if (mysqli_query($conn, $nhapCauHoi)) {

                                            // lấy id cuối cùng được chèn
                                            $idch = mysqli_insert_id($conn);

                                            $co = false;
                                            for ($j = 0; $j < $soDapAn; $j++) {
                                                $da = $_POST['textDapAn'.$j];
                                                if (in_array($j, $array)) {
                                                    $nhapDapAn = "INSERT INTO `dap_an`(`id_dap_an`, `ten_dap_an`, `kiem_tra`, `id_cau_hoi`) 
                                                    VALUES (NULL,'$da','1','$idch')";
                                                }
                                                else {
                                                    $nhapDapAn = "INSERT INTO `dap_an`(`id_dap_an`, `ten_dap_an`, `kiem_tra`, `id_cau_hoi`) 
                                                    VALUES (NULL,'$da','0','$idch')";
                                                }

                                                if (mysqli_query($conn, $nhapDapAn)) {
                                                    $co = true;
                                                }
                                                else {
                                                    echo 'Error: ' . mysqli_error($conn);
                                                    break;
                                                }
                                            }
                                            if ($co) {
                                                echo '<div class="alert alert-success text-center" role="alert">Thêm câu hỏi thành công</div>';
                                                unset($_SESSION['them_cau_hoi_php']);
                                            }
                                        }
                                        else {
                                            echo 'Error: ' . mysqli_error($conn);
                                        }
                                    }
                                    else {
                                            
                                        // lưu vào csdl nếu không có ảnh

                                        $nhapCauHoi = "INSERT INTO `cau_hoi`(`id_cau_hoi`, `ten_cau_hoi`, `loai_cau_hoi`, `anh_cau_hoi`, `trang_thai`, `id_user`, `id_khoa_hoc`) 
                                        VALUES (NULL,'$tch','$lch', '', '$tt','$idUser','$kh')";

                                        if (mysqli_query($conn, $nhapCauHoi)) {

                                            // lấy id cuối cùng được chèn
                                            $idch = mysqli_insert_id($conn);

                                            $co = false;
                                            for ($j = 0; $j < $soDapAn; $j++) {
                                                $da = $_POST['textDapAn'.$j];
                                                if (in_array($j, $array)) {
                                                    $nhapDapAn = "INSERT INTO `dap_an`(`id_dap_an`, `ten_dap_an`, `kiem_tra`, `id_cau_hoi`) 
                                                    VALUES (NULL,'$da','1','$idch')";
                                                }
                                                else {
                                                    $nhapDapAn = "INSERT INTO `dap_an`(`id_dap_an`, `ten_dap_an`, `kiem_tra`, `id_cau_hoi`) 
                                                    VALUES (NULL,'$da','0','$idch')";
                                                }

                                                if (mysqli_query($conn, $nhapDapAn)) {
                                                    $co = true;
                                                }
                                                else {
                                                    echo 'Error: ' . mysqli_error($conn);
                                                    break;
                                                }
                                            }
                                            if ($co) {
                                                echo '<div class="alert alert-success text-center" role="alert">Thêm câu hỏi thành công</div>';
                                                unset($_SESSION['them_cau_hoi_php']);
                                            }
                                        }
                                        else {
                                            echo 'Error: ' . mysqli_error($conn);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            ?> 
            <div style="margin: 20px 0 0 0;" class="d-grid">
                <input class="btn btn-primary btn-block" name="btn" type="submit" value="Thêm câu hỏi">
            </div>   
        </div>
        </form>
	</main>
    <?php include 'footer.php'; ?>
</body>
</html>