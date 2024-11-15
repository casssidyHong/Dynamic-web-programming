<?php
session_start();

// 清除所有會話變量
$_SESSION = array();

// 銷毀會話
session_destroy();

// 重定向到登入頁面
header('Location: index.html');
exit;
?>