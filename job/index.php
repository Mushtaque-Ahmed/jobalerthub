<?php
require_once "../includes/config.php";
$activePage = "job";
$type = "job";



$page = max(1, (int)($_GET['page'] ?? 1));

$search = trim($_GET['search'] ?? '');

$category = (int)($_GET['category'] ?? 0);

$url = BASE_URL . "api/post/listing.php?type={$type}";
$url .= "&page={$page}";

if($search!=""){
    $url .= "&search=".urlencode($search);
}

if($category>0){
    $url .= "&category=".$category;
}

$response = file_get_contents($url);

if($response===false){
    die("Unable to load jobs.");
}

$response = json_decode($response,true);

if(!$response["success"]){
    die("Unable to load jobs.");
}

$posts = $response["posts"] ?? [];
$categories = $response["categories"] ?? [];
$pagination = $response["pagination"] ?? [];

$page_title = "Latest Government Jobs | JobAdAssam";

$meta_description =
"Apply online for the latest Government Jobs in Assam and India. Find eligibility, salary, exam dates and official notifications.";

$meta_keywords =
"Government Jobs, Assam Jobs, Latest Jobs, Sarkari Naukri, Assam Recruitment";

$canonical = BASE_URL."job";

$og_image = BASE_URL."assets/image/jobs-banner.webp";

include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/post-list-template.php"; ?>

<?php include "../includes/footer.php";

?>