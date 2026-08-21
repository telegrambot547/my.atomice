<?php require_once 'functions.php'; ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مدير الروابط</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container nav-container">
            <a href="index.php" class="logo">🌐 مدير الروابط</a>
            <ul class="nav-menu">
                <li><a href="index.php">الرئيسية</a></li>
                <?php if (isLoggedIn()): ?>
                    <li><a href="add_link.php">إضافة رابط</a></li>
                    <li><a href="logout.php">تسجيل خروج (<?= escape($_SESSION['username']) ?>)</a></li>
                <?php else: ?>
                    <li><a href="login.php">تسجيل الدخول</a></li>
                    <li><a href="register.php">إنشاء حساب</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <div class="container main-content">