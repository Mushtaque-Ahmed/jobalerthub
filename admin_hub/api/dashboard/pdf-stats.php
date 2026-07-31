<?php

session_start();

header("Content-Type: application/json");

require_once "../../includes/database.php";

if (
    !isset($_SESSION['admin_logged_in']) ||
    $_SESSION['admin_logged_in'] !== true
) {

    exit(json_encode([
        "success"=>false
    ]));

}

try{

$total = $pdo->query("
SELECT COUNT(*) FROM pdf_products
")->fetchColumn();

$published = $pdo->query("
SELECT COUNT(*)
FROM pdf_products
WHERE status=1
")->fetchColumn();

$draft = $pdo->query("
SELECT COUNT(*)
FROM pdf_products
WHERE status=0
")->fetchColumn();

$downloads = $pdo->query("
SELECT IFNULL(SUM(downloads),0)
FROM pdf_products
")->fetchColumn();

echo json_encode([

    "success"=>true,

    "data"=>[

        "total"=>$total,

        "published"=>$published,

        "draft"=>$draft,

        "downloads"=>$downloads

    ]

]);

}catch(PDOException $e){

echo json_encode([

"success"=>false,

"message"=>$e->getMessage()

]);

}?>