<?php

session_start();

header("Content-Type: application/json");

require_once __DIR__ . "/../../includes/database.php";

if (
    !isset($_SESSION['admin_logged_in']) ||
    $_SESSION['admin_logged_in'] !== true
) {

    echo json_encode([
        "success" => false,
        "message" => "Unauthorized"
    ]);
    exit;

}

$stmt = $pdo->query("
SELECT
    p.id,
    p.title,
    p.post_type,
    p.status,
    p.created_at,
    c.name AS category
FROM posts p
LEFT JOIN categories c
ON c.id = p.category_id
ORDER BY p.id DESC
LIMIT 10
");

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "success" => true,
    "data" => $data
]);?>