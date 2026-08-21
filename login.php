<?php
require_once 'functions.php';

if (isLoggedIn()) {
    redirect('index.php');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'جميع الحقول مطلوبة.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            redirect('index.php');
        } else {
            $error = 'بيانات الدخول غير صحيحة.';
        }
    }
}
?>
<?php include 'header.php'; ?>

<h1>تسجيل الدخول</h1>

<?php if ($error): ?>
    <div class="alert alert-error"><?= escape($error) ?></div>
<?php endif; ?>

<form method="POST">
    <div class="form-group">
        <label>اسم المستخدم أو البريد الإلكتروني</label>
        <input type="text" name="username" required>
    </div>
    <div class="form-group">
        <label>كلمة المرور</label>
        <input type="password" name="password" required>
    </div>
    <button type="submit">دخول</button>
</form>

<p style="text-align:center; margin-top:15px;">ليس لديك حساب؟ <a href="register.php">إنشاء حساب</a></p>

<?php include 'footer.php'; ?>