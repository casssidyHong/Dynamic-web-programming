<?php
session_start();

// 檢查用戶是否已登入
if (!isset($_SESSION['user_id'])) {
    header('Location: index.html');
    exit;
}

// 數據庫連接配置
$db_host = 'localhost';
$db_user = 'your_username';
$db_pass = 'your_password';
$db_name = 'user_system';

// 建立數據庫連接
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// 獲取用戶資料
$stmt = $conn->prepare("SELECT username, email, created_at FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>用戶儀表板</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .welcome-banner {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .user-info {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .btn {
            background-color: #dc3545;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn:hover {
            background-color: #c82333;
        }
        .stat-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .stat-box {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 4px;
            text-align: center;
        }
        .last-login {
            font-size: 0.9em;
            color: #666;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="welcome-banner">
            <h2>歡迎回來，<?php echo htmlspecialchars($user['username']); ?>！</h2>
        </div>
        
        <div class="user-info">
            <h3>用戶資料</h3>
            <p><strong>用戶名：</strong> <?php echo htmlspecialchars($user['username']); ?></p>
            <p><strong>電子郵件：</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>註冊日期：</strong> <?php echo date('Y-m-d', strtotime($user['created_at'])); ?></p>
        </div>

        <div class="stat-container">
            <div class="stat-box">
                <h4>登入次數</h4>
                <p>5 次</p>
            </div>
            <div class="stat-box">
                <h4>最後登入</h4>
                <p><?php echo date('Y-m-d H:i'); ?></p>
            </div>
            <div class="stat-box">
                <h4>帳戶狀態</h4>
                <p>活躍</p>
            </div>
        </div>

        <p class="last-login">上次登入時間：<?php echo date('Y-m-d H:i:s'); ?></p>
        
        <a href="logout.php" class="btn">登出</a>
    </div>

    <script>
        // 可以加入一些互動效果
        document.addEventListener('DOMContentLoaded', function() {
            // 添加歡迎訊息動畫
            const welcome = document.querySelector('.welcome-banner');
            welcome.style.opacity = '0';
            welcome.style.transition = 'opacity 1s';
            
            setTimeout(() => {
                welcome.style.opacity = '1';
            }, 100);
        });
    </script>
</body>
</html>