<?php

header("Content-Type: application/json");


require_once __DIR__ . "/../../includes/database.php";



try{


$name = $_POST['name'];
$slug = $_POST['slug'];
$icon = $_POST['icon'];
$status = $_POST['status'];



$stmt=$pdo->prepare("

INSERT INTO pdf_categories

(
name,
slug,
icon,
status
)

VALUES

(?,?,?,?)

");



$stmt->execute([

$name,
$slug,
$icon,
$status

]);



echo json_encode([

"success"=>true,

"message"=>"PDF Category Added Successfully"

]);



}catch(PDOException $e){


echo json_encode([

"success"=>false,

"message"=>$e->getMessage()

]);


}

?>