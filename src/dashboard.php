<?php 
    //include '../function.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dashboard</title>
	<!-- Begin bootstrap cdn -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            flex: 1;
            display: flex;
            flex-wrap: wrap;
            justify-content: center; 
            align-items: center; 
            flex-direction: column;
            margin-bottom: 20px;
            margin:auto;
        }

        canvas {
            max-width: 48%;
            margin-bottom: 20px;
        }

        footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            margin-top: auto; /* Đẩy footer xuống cuối trang */
        }
    </style>
</head>
<body>
    <?php 
        include 'navbar.php';
        include '../role.php';

        // kiểm tra đăng nhập chưa
		if (!isset($_SESSION['name'])) {
			header("Location: dang_nhap.php");
			exit;
		}

        if (!checkRole($conn, $_SESSION['name'])) {
			header("Location: khoa_hoc.php");
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
    <?php

            $DB_HOST = 'localhost';
            $DB_USER = 'root';
            $DB_PASS = '';
            $DB_NAME = '17_project_k71'; 
            $conn=mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die("Không thể kết nối tới cơ sở dữ liệu");
            if($conn){
                mysqli_query($conn,"SET NAMES 'utf8'");
            }else{
                echo "Bạn đã kết nối thất bại";
            }
            $userCountQuery = "SELECT COUNT(*) as totalUsers FROM user";
            $courseCountQuery = "SELECT COUNT(*) as totalCourses FROM khoa_hoc";
            $questionCountQuery = "SELECT COUNT(*) as totalQuestions FROM cau_hoi";

            $userCountResult = mysqli_query($conn, $userCountQuery);
            $courseCountResult = mysqli_query($conn, $courseCountQuery);
            $questionCountResult = mysqli_query($conn, $questionCountQuery);

            $userCount = mysqli_fetch_assoc($userCountResult)['totalUsers'];
            $courseCount = mysqli_fetch_assoc($courseCountResult)['totalCourses'];
            $questionCount = mysqli_fetch_assoc($questionCountResult)['totalQuestions'];

            $averageScoreQuery = "SELECT AVG(diem) as averageScore FROM diem";
            $averageScoreResult = mysqli_query($conn, $averageScoreQuery);
            $averageScore = mysqli_fetch_assoc($averageScoreResult)['averageScore'];
     ?>
    <div class="container">
    <canvas id="myChart"></canvas>
    <canvas id="averageScoreChart"></canvas>
    <canvas id="donutChart"></canvas>
    </div>
    <script>
    let myChart = document.getElementById('myChart').getContext('2d');
            Chart.defaults.global.defaultFontFamily = 'Lato';
            Chart.defaults.global.defaultFontSize = 18;
            Chart.defaults.global.defaultFontColor = '#777';

            let massPopChart = new Chart(myChart, {
            type: 'bar',
            data: {
                labels: ['Người dùng', 'Khoá học', 'Câu hỏi'],
                datasets: [{
                label: 'Số lượng',
                data: [
                    <?php echo $userCount; ?>,
                    <?php echo $courseCount; ?>,
                    <?php echo $questionCount; ?>
                ],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                ],
                borderWidth: 1,
                borderColor: '#777',
                hoverBorderWidth: 3,
                hoverBorderColor: '#000'
                }]
            },
            options: {
                title: {
                display: true,
                text: 'Thống kê số lượng Người dùng, Khoá học và Câu hỏi',
                fontSize: 25
                },
                legend: {
                display: true,
                position: 'right',
                labels: {
                    fontColor: '#000'
                }
                },
                layout: {
                padding: {
                    left: 50,
                    right: 0,
                    bottom: 0,
                    top: 0
                }
                },
                tooltips: {
                enabled: true
                }
            }
            });
            let averageScoreChart = document.getElementById('averageScoreChart').getContext('2d');
    let averageScoreData = {
        labels: ['Average Score'],
        datasets: [{
            label: 'Average Score',
            data: [<?php echo $averageScore; ?>],
            backgroundColor: ['rgba(75, 192, 192, 0.6)'],
            borderWidth: 1,
            borderColor: '#777',
            hoverBorderWidth: 3,
            hoverBorderColor: '#000'
        }]
    };

    let averageScoreOptions = {
        title: {
            display: true,
            text: 'Trung Bình Điểm',
            fontSize: 25
        },
        legend: {
            display: false
        },
        layout: {
            padding: {
                left: 50,
                right: 0,
                bottom: 0,
                top: 0
            }
        },
        tooltips: {
            enabled: true
        }
    };

    let averageScoreChartInstance = new Chart(averageScoreChart, {
        type: 'bar',
        data: averageScoreData,
        options: averageScoreOptions
    });
  </script>
    <div></div>
    <footer>
    <?php include 'footer.php'; ?>
    </footer>
</body>
</html>