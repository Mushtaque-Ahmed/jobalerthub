<?php

require_once "../includes/config.php";
$activePage = "category";
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

/*-------------------------------------
 seo
 -------------------------------------------*/
 $categoryName = $response["category_name"] ?? "Jobs";

$page_title = $categoryName . " Government Jobs | JobAdAssam";

$meta_description = "Apply for the latest {$categoryName} Government Jobs. Check eligibility, salary, age limit, selection process, important dates and official notifications on JobAdAssam.";

$meta_keywords = "{$categoryName} Jobs, {$categoryName} Recruitment, {$categoryName} Vacancy, Government Jobs, Assam Jobs";

$canonical = BASE_URL . "category/" . ($_GET["slug"] ?? "");

$og_image = BASE_URL . "admin_hub/uploads/settings/" . ($settings["site_logo"] ?? "logo.webp"); 

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