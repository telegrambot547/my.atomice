<?php
require_once 'functions.php';

if (isLoggedIn()) {
    redirect('index.php');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    if (empty($username) || empty($email) || empty($password)) {
        $error = 'جميع الحقول مطلوبة.';
    } elseif ($password !== $confirm) {
        $error = 'كلمة المرور غير متطابقة.';
    } elseif (strlen($password) < 6) {
        $error = 'كلمة المرور يجب أن تكون 6 أحرف على الأقل.';
    } else {
        // التحقق من عدم وجود مستخدم بنفس الاسم أو البريد
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            $error = 'اسم المستخدم أو البريد الإلكتروني مستخدم بالفعل.';
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hashed]);
            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['username'] = $username;
            redirect('index.php');
        }
    }
}
?>
<?php include 'header.php'; ?>

<h1>إنشاء حساب جديد</h1>

<?php if ($error): ?>
    <div class="alert alert-error"><?= escape($error) ?></div>
<?php endif; ?>

<form method="POST">
    <div class="form-group">
        <label>اسم المستخدم</label>
        <input type="text" name="username" required>
    </div>
    <div class="form-group">
        <label>البريد الإلكتروني</label>
        <input type="email" name="email" required>
    </div>
    <div class="form-group">
        <label>كلمة المرور</label>
        <input type="password" name="password" required>
    </div>
    <div class="form-group">
        <label>تأكيد كلمة المرور</label>
        <input type="password" name="confirm" required>
    </div>
    <button type="submit">إنشاء الحساب</button>
</form>

<p style="text-align:center; margin-top:15px;">لديك حساب بالفعل؟ <a href="login.php">تسجيل الدخول</a></p>

<?php include 'footer.php'; ?>