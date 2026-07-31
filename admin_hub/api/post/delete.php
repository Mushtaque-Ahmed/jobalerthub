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
        'message' => 'Unauthorized.'
    ]);

    exit;
}

/*
|--------------------------------------------------------------------------
| Request Method
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    echo json_encode([
        'success' => false,
        'message' => 'Invalid request.'
    ]);

    exit;
}

/*
|--------------------------------------------------------------------------
| Validate ID
|--------------------------------------------------------------------------
*/

$id = (int)($_POST['id'] ?? 0);

if ($id <= 0) {

    echo json_encode([
        'success' => false,
        'message' => 'Invalid post.'
    ]);

    exit;
}

/*
|--------------------------------------------------------------------------
| Get Image
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT featured_image
    FROM posts
    WHERE id=?
    LIMIT 1
");

$stmt->execute([$id]);

$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {

    echo json_encode([
        'success' => false,
        'message' => 'Post not found.'
    ]);

    exit;
}

/*
|--------------------------------------------------------------------------
| Delete Image
|--------------------------------------------------------------------------
*/

if (!empty($post['featured_image'])) {

    $image = __DIR__ .
        '/../../uploads/posts/' .
        $post['featured_image'];

    if (file_exists($image)) {

        unlink($image);

    }

}

/*
|--------------------------------------------------------------------------
| Delete Database
|--------------------------------------------------------------------------
*/

$delete = $pdo->prepare("
    DELETE FROM posts
    WHERE id=?
");

$delete->execute([$id]);

echo json_encode([

    'success' => true,

    'message' => 'Post deleted successfully.'

]);?>