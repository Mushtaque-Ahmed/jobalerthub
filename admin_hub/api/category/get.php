<?php

session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../includes/database.php';

if (!isset($_SESSION['admin_logged_in'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized.'
    ]);
    exit;
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid ID.'
    ]);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM categories WHERE id=? LIMIT 1");
$stmt->execute([$id]);

$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {

    echo json_encode([
        'success' => false,
        'message' => 'Category not found.'
    ]);
    exit;
}

echo json_encode([
    'success' => true,
    'data' => $data
]);?>