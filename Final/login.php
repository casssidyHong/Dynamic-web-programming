<?php
header('Content-Type: application/json');

// 在 register.php 和 login.php 的頂部確認資料庫連接部分如下：
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die(json_encode([
        'success' => false,
        'message' => '數據庫連接失敗：' . $conn->connect_error
    ]));
}


session_start();

// 數據庫連接配置
$db_host = 'localhost';
$db_user = 'your_username';
$db_pass = 'your_password';
$db_name = 'user_system';

// 建立數據庫連接
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// 檢查連接
if ($conn->connect_error) {
    die(json_encode([
        'success' => false,
        'message' => '數據庫連接失敗'
    ]));
}

// 設置編碼
$conn->set_charset("utf8mb4");

// 獲取POST數據
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// 基本驗證
if (empty($username) || empty($password)) {
    echo json_encode([
        'success' => false,
        'message' => '請填寫所有必需的字段'
    ]);
    exit;
}

// 準備SQL語句
$stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        // 登入成功
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        
        echo json_encode([
            'success' => true,
            'message' => '登入成功'
        ]);
        header('Location: dashboard.php'); 
        exit;
    } else {
        echo json_encode([
            'success' => false,
            'message' => '用戶名或密碼錯誤'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => '用戶名或密碼錯誤'
    ]);
}

$stmt->close();
$conn->close();
?>