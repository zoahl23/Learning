<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Luyện tập</title>
	<!-- Begin bootstrap cdn -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<!-- End bootstrap cdn -->
    <style>
        .baiLam {
            padding: 50px; 
            min-height: 100px; 
            width: 100%; 
            border-radius: 5px; 
            border: 1px solid #adb5bd; 
        }
        .time {
            width: 200px;
            height: 40px;
            line-height: 40px;
            position: fixed;
            top: 100px;
            left: 50px;
        }
    </style>
</head>
<body>
    <?php 
        include 'navbar.php';
        include '../role.php';
        $dir = "../images/";
        $khoaHoc = "";
        if (isset($_GET['id_khoa_hoc'])) {
            $khoaHoc = $_GET['id_khoa_hoc'];
        }
        $ten = $_SESSION['name'];

        // kiểm tra đăng nhập chưa
		if (!isset($_SESSION['name'])) {
			header("Location: dang_nhap.php");
			exit;
		}

        if (checkRole($conn, $_SESSION['name'])) {
			header("Location: khoa_hoc.php");
			exit;
		}

        // =======================================
        if (!isset($_SESSION['luyen_tap_php'])) {
            header("Location: khoa_hoc.php");
			exit;
        }

        // nếu url sai thì không cho truy cập vào trang biên tập
        $query = "SELECT * FROM `khoa_hoc` WHERE `id_khoa_hoc` = '$khoaHoc'";
        $result = $conn->query($query);
        if ($result->num_rows <= 0) {
            header("location: khoa_hoc.php");
            exit;
        }

        $_SESSION['ket_qua_php'] = 1;

        // =======================================

        $layIdUser = "SELECT `id_user` FROM `user` WHERE `tai_khoan` = '$ten'";
        $resultIU = mysqli_query($conn, $layIdUser);
        while ($riu = mysqli_fetch_array($resultIU)) {
            $idUser = $riu[0];
        }

        if (!isset($_SESSION['luyenTap'][$khoaHoc])) {
            $_SESSION['luyenTap'][$khoaHoc] = array();
        }
        
        /*
        Array ( 
            [idch] => 90 
            [tench] => bfg 
            [loaich] => Nhiều đáp án 
            [anhch] => 
            [da] => Array ( 
                [0] => Array ( 
                    [idda] => 64 
                    [tenda] => jj 
                    [kiemtra] => 0 
                ) 
                [1] => Array ( 
                    [idda] => 60 
                    [tenda] => gg 
                    [kiemtra] => 1 
                ) 
                [2] => Array ( 
                    [idda] => 62 
                    [tenda] => tt 
                    [kiemtra] => 0 
                ) 
                [3] => Array ( 
                    [idda] => 61 
                    [tenda] => rr 
                    [kiemtra] => 1 
                ) 
                [4] => Array ( 
                    [idda] => 63 
                    [tenda] => yy 
                    [kiemtra] => 1 
                ) 
            ) 
        )
        */


        // lấy câu hỏi
        if (empty($_SESSION['luyenTap'][$khoaHoc])) {
            
            $layCauHoi = "SELECT * FROM `cau_hoi` WHERE `id_khoa_hoc` = '$khoaHoc' AND `trang_thai` = 1 ORDER BY RAND() LIMIT 10";
            $resultCauHoi = mysqli_query($conn, $layCauHoi);
            $demSoCauHoi = 0;
            while ($rch = mysqli_fetch_array($resultCauHoi)) {
                $idch = $rch['id_cau_hoi'];
                $tench = $rch['ten_cau_hoi'];
                $loaich = $rch['loai_cau_hoi'];
                $anhch = $rch['anh_cau_hoi'];

                // lấy đáp án
                $layDapAn = "SELECT * FROM `dap_an` WHERE `id_cau_hoi` = '$idch' ORDER BY RAND()";
                $resultDapAn = mysqli_query($conn, $layDapAn);

                $da = array();
                while ($rda = mysqli_fetch_array($resultDapAn)) {
                    $idda = $rda['id_dap_an'];
                    $tenda = $rda['ten_dap_an'];
                    $kiemtra = $rda['kiem_tra'];

                    
                    $da[] = [
                        'idda' => $idda,
                        'tenda' => $tenda,
                        'kiemtra' => $kiemtra
                    ];

                }

                $ch = [
                    'idch' => $idch,
                    'tench' => $tench,
                    'loaich' => $loaich,
                    'anhch' => $anhch,
                    'da' => $da
                ];

                $_SESSION["luyenTap"][$khoaHoc][] = $ch;
                $demSoCauHoi ++;
            }
        }

        if (empty($_SESSION["luyenTap"][$khoaHoc])) {
            header('location: ket_qua.php?id_khoa_hoc='.$khoaHoc);
        }
        else {
            $_SESSION['ket_qua'] = 1;
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
    <form action="" method="post">
    <div style="min-height: 100vh; max-width: 100%; margin: 40px 20%; ">
        <div class="baiLam">
            <div class="time">Thời gian làm bài: 05m 00s</div>
            <h1 style="text-align: center; color: red;">BÀI LÀM</h1>
            <div style="width: 100%; min-height: 50px; margin: 20px 0px;">
                <?php 
                    $stt = 0;
                    $arrDapAn = array();
                    foreach ($_SESSION["luyenTap"][$khoaHoc] as $k => $v) {
                        $id = $_SESSION["luyenTap"][$khoaHoc][$k]['idch'];
                        $ten = $_SESSION["luyenTap"][$khoaHoc][$k]['tench'];
                        $loai = $_SESSION["luyenTap"][$khoaHoc][$k]['loaich'];
                        $anh = $_SESSION["luyenTap"][$khoaHoc][$k]['anhch'];
                        $diachianh = $dir.$anh;
                        $stt++;

                        echo '<h5 style="margin: 20px 0;"><font color="blue">Câu hỏi '.$stt.': </font>'.$ten.'</h5>';
                        if ($anh != "") {
                            echo '<div style="width: 100%; text-align: center;"><img src="'.$diachianh.'" style="height: 300px; text-align: center;" class="img-thumbnail" alt=""></div>';
                        }

                        $dem = 0;
                        foreach ($_SESSION["luyenTap"][$khoaHoc][$k]['da'] as $key => $value) {
                            $idda = $value['idda'];
                            $tenda = $value['tenda'];
                            $ktra = $value['kiemtra'];

                            // lấy số lượng các đáp án đúng của câu hỏi nhiều đáp án
                            
                            if ($ktra == 1 && $loai == "Nhiều đáp án") {
                                $dem++;
                            }


                            if ($loai == "Một đáp án") {
                                echo '<div style="margin: 20px 0 0 0;" class="input-group mb-3">
                                    <div class="input-group-text">
                                        <input type="radio" name="dapAn'.$stt.'" value="'.$idda.'">
                                    </div>
                                <input type="text" class="form-control" value="';
                                echo $tenda;
                                echo '" readonly></div>';
                            }
                            if ($loai == "Nhiều đáp án") {
                                echo '<div style="margin: 20px 0 0 0;" class="input-group mb-3">
                                    <div class="input-group-text">
                                        <input type="checkbox" name="dapAn['.$stt.'][]" value="'.$idda.'">
                                    </div>
                                    <input type="text" class="form-control" value="';
                                echo $tenda;
                                echo '" readonly></div>';
                            }
                            if ($loai == "Điền") {
                                echo '<input style="margin: 20px 0;" name="textDapAn'.$stt.'" type="text" class="form-control" 
                                placeholder="Nhập đáp án">';
                            }
                        }
                        if ($dem != 0) {
                            $arrDapAn[$id] = $dem;
                        }
                    }
                    
                    if (isset($_POST['nopBai'])) {
                        $stt2 = 0;
                        $diem = 0;
                        $dem2 = array();
                        foreach ($_SESSION["luyenTap"][$khoaHoc] as $k => $v) {
                            $id = $_SESSION["luyenTap"][$khoaHoc][$k]['idch'];
                            $loai = $_SESSION["luyenTap"][$khoaHoc][$k]['loaich'];
                            $stt2++;
                            if ($loai == "Nhiều đáp án") {
                                $dem2[$id] = 0;
                            }
                            
    
                            foreach ($_SESSION["luyenTap"][$khoaHoc][$k]['da'] as $key => $value) {
                                $idda = $value['idda'];
                                $tenda = $value['tenda'];
                                $ktra = $value['kiemtra'];

                                if (isset($_POST['dapAn'.$stt2]) && ($_POST['dapAn'.$stt2] == $idda) && ($ktra == 1)) {
                                    $diem++;
                                }
                                // if (isset($_POST['dapAn'.$stt2]) && ($_POST['dapAn'.$stt2] == $idda) && ($ktra == 0)) {
                                //     echo "câu hỏi $stt2 sai<br>";
                                // }
    
                                if (isset($_POST['textDapAn'.$stt2]) && (trim($_POST['textDapAn'.$stt2]) == $value['tenda'])) {
                                    $diem++;
                                }
                                // if (isset($_POST['textDapAn'.$stt2]) && (trim($_POST['textDapAn'.$stt2]) != $value['tenda'])) {
                                //     echo "câu hỏi $stt2 sai<br>";
                                // }
    

                                if (isset($_POST['dapAn'][$stt2]) && $loai == "Nhiều đáp án") {
                                    $arrCb = $_POST['dapAn'][$stt2];
                                    // $flag = false;
                                
                                    if ($ktra == 1) {
                                        foreach ($arrCb as $cb) {
                                            if ($cb == $idda) {
                                                // echo $cb;
                                                $dem2[$id]++;
                                            }
                                        }
                                    }
                                    if ($ktra == 0) {
                                        foreach ($arrCb as $cb) {
                                            if ($cb == $idda) {
                                                $dem2[$id]--;
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        $stt3 = 0;
                        foreach ($_SESSION["luyenTap"][$khoaHoc] as $k => $v) {
                            $id = $_SESSION["luyenTap"][$khoaHoc][$k]['idch'];
                            $loai = $_SESSION["luyenTap"][$khoaHoc][$k]['loaich'];
                            $stt3++;
                            if ($loai == "Nhiều đáp án") {
                                if ($arrDapAn[$id] == $dem2[$id]) {
                                    $diem++;
                                }
                                // else {
                                //     echo "câu hỏi $stt3 sai<br>";
                                // }
                            }
                        }
                        $diemChuan = ($diem/$stt) * 100;
                        $dc = round($diemChuan * 100) / 100 ;
                        $_SESSION['diem'] = $dc;
                        date_default_timezone_set('Asia/Ho_Chi_Minh');
                        $date = date('d-m-Y H:i:s');
                        $giolambai=strtotime($date);
                        $giolambaiquydoi = date('H:i:s', $giolambai);
                        $start_time = strtotime($date);
                        $formatted_start_date = date('d/m/Y', $start_time);

                        $laygio = $giolambaiquydoi.' '.$formatted_start_date;
                        $_SESSION['gio'] = $laygio;
                
                        $nhapDiem = "INSERT INTO `diem`(`id_diem`, `id_khoa_hoc`, `id_user`, `diem`, `thoi_gian_lam_bai`) 
                        VALUES (NULL,'$khoaHoc','$idUser','$dc', '$laygio')";

                        if(mysqli_query($conn, $nhapDiem)) {
                            echo "Nhập điểm thành công";
                            unset($_SESSION['luyen_tap_php']);
                            echo '<script type="text/javascript">
                            window.location.href = "ket_qua.php?id_khoa_hoc='.$khoaHoc.'"</script>';
                        }
                        else {
                            echo 'Error: ' . mysqli_error($conn);
                        }

                        // echo "<pre>";
                        // print_r($dem2);
                        // echo "</pre>";
                        

                        // echo "<pre>";
                        // print_r($arrDapAn);
                        // echo "</pre>";
                        // // =============================
                        // echo "=========";
                        // for ($i = 1; $i <= $stt; $i++) {
                        //     if (isset($_POST['dapAn'.$i])) {
                        //         echo $_POST['dapAn'.$i];
                        //         echo '<br>';
                        //     }

                        //     if (isset($_POST['textDapAn'.$i])) {
                        //         echo $_POST['textDapAn'.$i];
                        //         echo '<br>';
                        //     }

                        //     if (isset($_POST['dapAn'][$i])) {
                        //         $arrCb = $_POST['dapAn'][$i];
                    
                        //         foreach ($arrCb as $value) {
                        //             echo $value . '<br>';
                        //         }
                        //     }
                        // }
                        
                    }
                ?>
            </div>
            <div style="width: 100%; margin: 50px 0 0;">
                <!-- <a href="ket_qua.php?id_khoa_hoc="  class="btn btn-success">Nộp bài</a> -->
                <input type="submit" value="Nộp bài" style="width: 100%;" name="nopBai" class="btn btn-success" id="submitForm">
            </div>
        </div>
    </div>
    </form>
    <script>
            document.addEventListener("DOMContentLoaded", function() {
                let minutes = 05;
                let seconds = 00;

                function updateTimer() {
                saveTimeToLocalStorage(minutes,seconds);
                let timerElement = document.querySelector('.time');
                timerElement.innerHTML = 'Thời gian làm bài: ' + minutes + 'm ' + seconds + 's';

                if (minutes === 0 && seconds === 0) {
                    document.getElementById('submitForm').click();
                } else {
                    setTimeout(updateTimer, 1000);
                    if (seconds === 0) {
                    minutes--;
                    seconds = 59;
                    } else {
                    seconds--;
                    }
                }
                }
            
                
                updateTimer();
            });
            function saveTimeToLocalStorage(minutes, seconds) {
                localStorage.setItem('savedMinutes', minutes);
                localStorage.setItem('savedSeconds', seconds);
            }               
    
    </script>
    <?php include 'footer.php'; unset($_SESSION['luyenTap'][$khoaHoc]);?>
</body>
</html>