<?php require_once 'functions.php'; ?>
<?php include 'header.php'; ?>

<?php
$search = $_GET['search'] ?? '';
$category_id = $_GET['category'] ?? null;
$links = getLinks($search, $category_id);
$categories = getCategories();
?>

<h1>جميع الروابط</h1>

<form method="GET" class="search-bar">
    <input type="text" name="search" placeholder="ابحث عن عنوان أو رابط أو وصف..." value="<?= escape($search) ?>">
    <select name="category">
        <option value="">كل التصنيفات</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>" <?= ($category_id == $cat['id']) ? 'selected' : '' ?>>
                <?= escape($cat['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">بحث</button>
</form>

<?php if (empty($links)): ?>
    <div class="alert alert-error">لا توجد روابط مطابقة.</div>
<?php else: ?>
    <div class="links-list">
        <?php foreach ($links as $link): ?>
            <div class="link-card">
                <h3><?= escape($link['title']) ?></h3>
                <a href="view.php?id=<?= $link['id'] ?>" class="url" target="_blank"><?= escape($link['url']) ?></a>
                <p><?= escape($link['description'] ?? '') ?></p>
                <div class="meta">
                    التصنيف: <?= escape($link['category_name']) ?> | بواسطة: <?= escape($link['username']) ?> | <?= date('Y-m-d', strtotime($link['created_at'])) ?>
                </div>
                <a href="view.php?id=<?= $link['id'] ?>" class="btn" style="margin-top:10px;">عرض داخل الموقع</a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include 'footer.php'; ?>