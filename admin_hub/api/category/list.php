<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../includes/database.php';

$page = max(1, (int)($_GET['page'] ?? 1));
$limit = 10;
$offset = ($page - 1) * $limit;

$search = trim($_GET['search'] ?? '');

$where = "";
$params = [];

if ($search != "") {
    $where = " WHERE name LIKE :search OR slug LIKE :search ";
    $params[':search'] = "%{$search}%";
}

$countSql = "SELECT COUNT(*) FROM categories $where";
$stmt = $pdo->prepare($countSql);
$stmt->execute($params);
$total = $stmt->fetchColumn();

$sql = "SELECT * FROM categories
        $where
        ORDER BY id DESC
        LIMIT $limit OFFSET $offset";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

echo json_encode([
    "success" => true,
    "data" => $stmt->fetchAll(PDO::FETCH_ASSOC),
    "total" => $total,
    "page" => $page,
    "limit" => $limit
]);?>