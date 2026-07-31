<?php

require_once "../includes/config.php";

$slug = trim($_GET["slug"] ?? "");

$page = max(1, (int)($_GET["page"] ?? 1));

$url = BASE_URL . "api/category/posts.php?slug=" . urlencode($slug);

$response = file_get_contents($url);

$response = json_decode($response, true);

if (!$response["success"]) {

    die("Category Not Found.");

}

$posts = $response["posts"] ?? [];

$categories = $response["categories"] ?? [];

$pagination = $response["pagination"] ?? [];

/*----------------------------------
ADD HERE
----------------------------------*/

$type = "category";

$pageTitle = $response["category"]["name"] ?? "Category";

$search = "";

$category = 0;

$page_title = $pageTitle;

/*----------------------------------*/

include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/post-list-template.php";
include "../includes/footer.php";?>