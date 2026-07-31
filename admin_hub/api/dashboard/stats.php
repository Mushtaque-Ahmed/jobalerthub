<?php

session_start();

header("Content-Type: application/json");

require_once __DIR__ . "/../../includes/database.php";

if (
    !isset($_SESSION['admin_logged_in']) ||
    $_SESSION['admin_logged_in'] !== true
) {

    echo json_encode([
        "success"=>false
    ]);

    exit;

}

$data=[];

$data['categories']=$pdo->query("
SELECT COUNT(*) FROM categories
")->fetchColumn();

$data['posts']=$pdo->query("
SELECT COUNT(*) FROM posts
")->fetchColumn();

$data['published']=$pdo->query("
SELECT COUNT(*)
FROM posts
WHERE status='published'
")->fetchColumn();

$data['draft']=$pdo->query("
SELECT COUNT(*)
FROM posts
WHERE status='draft'
")->fetchColumn();

$data['today']=$pdo->query("
SELECT COUNT(*)
FROM posts
WHERE DATE(created_at)=CURDATE()
")->fetchColumn();

$data['month']=$pdo->query("
SELECT COUNT(*)
FROM posts
WHERE MONTH(created_at)=MONTH(CURDATE())
AND YEAR(created_at)=YEAR(CURDATE())
")->fetchColumn();

$data['views']=$pdo->query("
SELECT IFNULL(SUM(views),0)
FROM posts
")->fetchColumn();

$data['jobs']=$pdo->query("
SELECT COUNT(*)
FROM posts
WHERE post_type='job'
")->fetchColumn();

echo json_encode([
    "success"=>true,
    "data"=>$data
]);?>