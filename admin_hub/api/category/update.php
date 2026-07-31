<?php

session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../includes/database.php';

if (!isset($_SESSION['admin_logged_in'])) {
    echo json_encode([
        'success'=>false,
        'message'=>'Unauthorized.'
    ]);
    exit;
}

$id = filter_input(INPUT_POST,'id',FILTER_VALIDATE_INT);
$name = trim($_POST['name'] ?? '');
$slug = trim($_POST['slug'] ?? '');
$icon = trim($_POST['icon'] ?? '');
$status = (int)($_POST['status'] ?? 1);

if(!$id || $name=='' || $slug==''){

    echo json_encode([
        'success'=>false,
        'message'=>'Please fill all required fields.'
    ]);
    exit;
}

$check = $pdo->prepare("SELECT id FROM categories WHERE slug=? AND id!=?");
$check->execute([$slug,$id]);

if($check->fetch()){

    echo json_encode([
        'success'=>false,
        'message'=>'Slug already exists.'
    ]);
    exit;
}

$stmt = $pdo->prepare("
UPDATE categories
SET
name=?,
slug=?,
icon=?,
status=?
WHERE id=?
");

$stmt->execute([
$name,
$slug,
$icon,
$status,
$id
]);

echo json_encode([
'success'=>true,
'message'=>'Category updated successfully.'
]);?>