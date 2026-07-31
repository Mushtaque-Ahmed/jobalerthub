<?php

session_start();

header('Content-Type: application/json');

require_once __DIR__.'/../../includes/database.php';

if($_SERVER['REQUEST_METHOD']!='POST'){

echo json_encode([
"success"=>false,
"message"=>"Invalid Request"
]);

exit;

}

$name=trim($_POST['name']??'');
$slug=trim($_POST['slug']??'');
$icon=trim($_POST['icon']??'');
$status=(int)($_POST['status']??1);

if($name=='' || $slug==''){

echo json_encode([
"success"=>false,
"message"=>"Please fill all required fields."
]);

exit;

}

$stmt=$pdo->prepare("SELECT id FROM categories WHERE slug=? LIMIT 1");

$stmt->execute([$slug]);

if($stmt->fetch()){

echo json_encode([
"success"=>false,
"message"=>"Slug already exists."
]);

exit;

}

$sql="INSERT INTO categories
(name,slug,icon,status)
VALUES(?,?,?,?)";

$stmt=$pdo->prepare($sql);

$stmt->execute([
$name,
$slug,
$icon,
$status
]);

echo json_encode([
"success"=>true,
"message"=>"Category added successfully."
]);
?>