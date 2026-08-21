<?php
require_once 'functions.php';

$id = $_GET['id'] ?? null;
if (!$id) redirect('index.php');

$stmt = $pdo->prepare("SELECT * FROM links WHERE id = ?");
$stmt->execute([$id]);
$link = $stmt->fetch();

if (!$link) redirect('index.php');
?>
<?php include 'header.php'; ?>

<h1><?= escape($link['title']) ?></h1>
<p>التصنيف: <?= escape(getCategoryName($link['category_id'])) ?> | أُضيف بواسطة: <?= escape($link['username'] ?? 'مستخدم') ?></p>

<div class="iframe-container">
    <div class="iframe-wrapper">
        <iframe src="<?= escape($link['url']) ?>" sandbox="allow-scripts allow-same-origin allow-forms allow-popups"></iframe>
    </div>
    <a href="<?= escape($link['url']) ?>" target="_blank" class="btn">فتح في نافذة جديدة</a>
    <a href="index.php" class="btn" style="background:#888;">عودة</a>
</div>

<?php include 'footer.php'; ?>