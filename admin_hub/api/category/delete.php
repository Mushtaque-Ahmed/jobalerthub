<?php

session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../includes/database.php';

// Check login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized access.'
    ]);
    exit;
}

// Allow POST only
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request.'
    ]);
    exit;
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid category ID.'
    ]);
    exit;
}

try {

    // Check category exists
    $check = $pdo->prepare("SELECT id FROM categories WHERE id = ?");
    $check->execute([$id]);

    if (!$check->fetch()) {
        echo json_encode([
            'success' => false,
            'message' => 'Category not found.'
        ]);
        exit;
    }

    /*
    // Uncomment later when you create posts table

    $postCheck = $pdo->prepare("SELECT COUNT(*) FROM posts WHERE category_id = ?");
    $postCheck->execute([$id]);

    if ($postCheck->fetchColumn() > 0) {
        echo json_encode([
            'success' => false,
            'message' => 'This category is being used by posts and cannot be deleted.'
        ]);
        exit;
    }
    */

    $delete = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    $delete->execute([$id]);

    echo json_encode([
        'success' => true,
        'message' => 'Category deleted successfully.'
    ]);

} catch (PDOException $e) {

    echo json_encode([
        'success' => false,
        'message' => 'Database error.'
        // For development only:
        // 'error' => $e->getMessage()
    ]);
}?>