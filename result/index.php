<?php

require_once "../includes/config.php";

$type = "result";

$pageTitle = "Latest Result";

$page = max(1, (int)($_GET['page'] ?? 1));

$search = trim($_GET['search'] ?? '');

$category = (int)($_GET['category'] ?? 0);

$url = BASE_URL . "api/post/listing.php?type={$type}";
$url .= "&page={$page}";

if ($search != "") {
    $url .= "&search=" . urlencode($search);
}

if ($category > 0) {
    $url .= "&category=" . $category;
}

$response = file_get_contents($url);

if ($response === false) {
    die("Unable to load result.");
}

$response = json_decode($response, true);

if (!$response["success"]) {
    die("Unable to load admit cards.");
}

$posts = $response["posts"] ?? [];
$categories = $response["categories"] ?? [];
$pagination = $response["pagination"] ?? [];

$page_title = $pageTitle;

include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/post-list-template.php";
include "../includes/footer.php";?>