<?php
require_once 'config.php';

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function redirect($url) {
    header("Location: $url");
    exit;
}

function escape($html) {
    return htmlspecialchars($html, ENT_QUOTES, 'UTF-8');
}

function getCategories() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM categories ORDER BY name");
    return $stmt->fetchAll();
}

function getCategoryName($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT name FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    $cat = $stmt->fetch();
    return $cat ? $cat['name'] : 'غير مصنف';
}

function getLinks($search = '', $category_id = null) {
    global $pdo;
    $sql = "SELECT links.*, users.username, categories.name as category_name 
            FROM links 
            JOIN users ON links.user_id = users.id 
            JOIN categories ON links.category_id = categories.id 
            WHERE 1=1";
    $params = [];
    if ($search) {
        $sql .= " AND (links.title LIKE ? OR links.url LIKE ? OR links.description LIKE ?)";
        $like = "%$search%";
        $params = array_merge($params, [$like, $like, $like]);
    }
    if ($category_id) {
        $sql .= " AND links.category_id = ?";
        $params[] = $category_id;
    }
    $sql .= " ORDER BY links.created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function getUserLinks($user_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM links WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll();
}
?>