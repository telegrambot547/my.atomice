<?php
require_once 'functions.php';
$category_id = $_GET['id'] ?? null;
if (!$category_id) redirect('index.php');

$category = null;
$categories = getCategories();
foreach ($categories as $cat) {
    if ($cat['id'] == $category_id) {
        $category = $cat;
        break;
    }
}
if (!$category) redirect('index.php');

$links = getLinks('', $category_id);
?>
<?php include 'header.php'; ?>

<h1>روابط تصنيف: <?= escape($category['name']) ?></h1>

<form method="GET" class="search-bar" action="index.php">
    <input type="hidden" name="category" value="<?= $category_id ?>">
    <input type="text" name="search" placeholder="ابحث داخل هذا التصنيف...">
    <button type="submit">بحث</button>
</form>

<?php if (empty($links)): ?>
    <div class="alert alert-error">لا توجد روابط في هذا التصنيف.</div>
<?php else: ?>
    <div class="links-list">
        <?php foreach ($links as $link): ?>
            <div class="link-card">
                <h3><?= escape($link['title']) ?></h3>
                <a href="view.php?id=<?= $link['id'] ?>" class="url" target="_blank"><?= escape($link['url']) ?></a>
                <p><?= escape($link['description'] ?? '') ?></p>
                <div class="meta">
                    بواسطة: <?= escape($link['username']) ?> | <?= date('Y-m-d', strtotime($link['created_at'])) ?>
                </div>
                <a href="view.php?id=<?= $link['id'] ?>" class="btn" style="margin-top:10px;">عرض داخل الموقع</a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include 'footer.php'; ?>