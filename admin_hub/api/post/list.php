<?php

session_start();

header('Content-Type: application/json');

require_once __DIR__ . '/../../includes/database.php';

/*
|--------------------------------------------------------------------------
| Login Check
|--------------------------------------------------------------------------
*/

if (
    !isset($_SESSION['admin_logged_in']) ||
    $_SESSION['admin_logged_in'] !== true
) {

    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized'
    ]);

    exit;
}

/*
|--------------------------------------------------------------------------
| Pagination
|--------------------------------------------------------------------------
*/

$page = max(1, (int)($_GET['page'] ?? 1));
$limit = 10;
$offset = ($page - 1) * $limit;

$search = trim($_GET['search'] ?? '');

/*
|--------------------------------------------------------------------------
| Total Records
|--------------------------------------------------------------------------
*/

if ($search != '') {

    $count = $pdo->prepare("
        SELECT COUNT(*)
        FROM posts
        WHERE title LIKE ?
    ");

    $count->execute(["%{$search}%"]);

} else {

    $count = $pdo->query("
        SELECT COUNT(*)
        FROM posts
    ");

}

$total = $count->fetchColumn();

/*
|--------------------------------------------------------------------------
| Fetch Posts
|--------------------------------------------------------------------------
*/

if ($search != '') {

    $stmt = $pdo->prepare("

        SELECT

            p.*,

            c.name AS category_name

        FROM posts p

        LEFT JOIN categories c
        ON c.id = p.category_id

        WHERE p.title LIKE ?

        ORDER BY p.id DESC

        LIMIT $offset,$limit

    ");

    $stmt->execute(["%{$search}%"]);

} else {

    $stmt = $pdo->query("

        SELECT

            p.*,

            c.name AS category_name

        FROM posts p

        LEFT JOIN categories c
        ON c.id = p.category_id

        ORDER BY p.id DESC

        LIMIT $offset,$limit

    ");

}

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Response
|--------------------------------------------------------------------------
*/

echo json_encode([

    'success' => true,

    'data' => $data,

    'total' => (int)$total,

    'limit' => $limit

]);?>