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
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// 基本驗證
if (empty($username) || empty($email) || empty($password)) {
    echo json_encode([
        'success' => false,
        'message' => '請填寫所有必需的字段'
    ]);
    exit;
}

// 驗證電子郵件格式
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'success' => false,
        'message' => '無效的電子郵件地址'
    ]);
    exit;
}

// 檢查用戶名是否已存在
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
if ($stmt->get_result()->num_rows > 0) {
    echo json_encode([
        'success' => false,
        'message' => '用戶名已被使用'
    ]);
    exit;
}
$stmt->close();

// 檢查電子郵件是否已存在
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
if ($stmt->get_result()->num_rows > 0) {
    echo json_encode([
        'success' => false,
        'message' => '電子郵件已被使用'
    ]);
    exit;
}
$stmt->close();

// 對密碼進行加密
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// 插入新用戶
$stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $hashed_password);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => '註冊成功'
    ]);
    header('Location: register_success.php'); // 重定向到成功頁面
    exit;
} else {
    echo json_encode([
        'success' => false,
        'message' => '註冊失敗：' . $conn->error
    ]);
}

echo json_encode(['success' => true, 'message' => '測試成功']);

$stmt->close();
$conn->close();
?>