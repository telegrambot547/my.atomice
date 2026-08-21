<?php
require_once 'functions.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$error = '';
$success = '';
$categories = getCategories();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $url = trim($_POST['url'] ?? '');
    $category_id = $_POST['category_id'] ?? '';
    $description = trim($_POST['description'] ?? '');

    if (empty($title) || empty($url) || empty($category_id)) {
        $error = 'العنوان والرابط والتصنيف مطلوبة.';
    } elseif (!filter_var($url, FILTER_VALIDATE_URL)) {
        $error = 'الرابط غير صالح.';
    } else {
        $stmt = $pdo->prepare("INSERT INTO links (user_id, category_id, title, url, description) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $category_id, $title, $url, $description]);
        $success = 'تمت إضافة الرابط بنجاح.';
    }
}
?>
<?php include 'header.php'; ?>

<h1>إضافة رابط جديد</h1>

<?php if ($error): ?>
    <div class="alert alert-error"><?= escape($error) ?></div>
<?php endif; ?>
<?php if ($success): ?>
    <div class="alert alert-success"><?= escape($success) ?></div>
<?php endif; ?>

<form method="POST">
    <div class="form-group">
        <label>عنوان الرابط</label>
        <input type="text" name="title" required>
    </div>
    <div class="form-group">
        <label>الرابط (URL)</label>
        <input type="url" name="url" placeholder="https://example.com" required>
    </div>
    <div class="form-group">
        <label>التصنيف</label>
        <select name="category_id" required>
            <option value="">اختر تصنيفًا</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>"><?= escape($cat['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label>الوصف (اختياري)</label>
        <textarea name="description" rows="4"></textarea>
    </div>
    <button type="submit">إضافة</button>
</form>

<?php include 'footer.php'; ?>