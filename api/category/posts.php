<?php

header("Content-Type: application/json");

require_once __DIR__."/../../admin_hub/includes/database.php";

$slug = trim($_GET["slug"] ?? "");

$page = max(1,(int)($_GET["page"] ?? 1));

$limit = 12;

$offset = ($page-1)*$limit;

/*
==================================
GET CATEGORY
==================================
*/

$stmt = $pdo->prepare("

SELECT *

FROM categories

WHERE slug=?

LIMIT 1

");

$stmt->execute([$slug]);

$category = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$category){

    echo json_encode([

        "success"=>false

    ]);

    exit;

}

/*
==================================
TOTAL POSTS
==================================
*/

$stmt = $pdo->prepare("

SELECT COUNT(*)

FROM posts

WHERE

category_id=?

AND status='published'

");

$stmt->execute([$category["id"]]);

$total = $stmt->fetchColumn();

$totalPages = ceil($total/$limit);

/*
==================================
POSTS
==================================
*/

$stmt = $pdo->prepare("

SELECT

id,
title,
slug,
organization,
featured_image,
qualification,
total_posts,
salary,
apply_last

FROM posts

WHERE

category_id=?

AND status='published'

ORDER BY created_at DESC

LIMIT {$limit}

OFFSET {$offset}

");

$stmt->execute([$category["id"]]);

$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([

    "success"=>true,

    "category"=>$category,

    "posts"=>$posts,

    "pagination"=>[

        "page"=>$page,

        "total_pages"=>$totalPages

    ]

]);?>