<?php

session_start();

header('Content-Type: application/json');

require_once __DIR__ . '/../../includes/database.php';

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

if (
    !isset($_SESSION['admin_logged_in']) ||
    $_SESSION['admin_logged_in'] !== true
) {
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized access.'
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| Request Method
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    echo json_encode([
        'success' => false,
        'message' => 'Invalid request.'
    ]);

    exit;
}

/*
|--------------------------------------------------------------------------
| Collect Data
|--------------------------------------------------------------------------
*/

$category_id = (int)($_POST['category_id'] ?? 0);
$post_type = trim($_POST['post_type'] ?? '');
$title = trim($_POST['title'] ?? '');
$slug = trim($_POST['slug'] ?? '');
$short_description = trim($_POST['short_description'] ?? '');
$description = $_POST['description'] ?? '';

$organization = trim($_POST['organization'] ?? '');
$qualification = trim($_POST['qualification'] ?? '');
$total_posts = trim($_POST['total_posts'] ?? '');
$age_limit = trim($_POST['age_limit'] ?? '');
$salary = trim($_POST['salary'] ?? '');
$application_fee = trim($_POST['application_fee'] ?? '');

$apply_start = !empty($_POST['apply_start']) ? $_POST['apply_start'] : null;
$apply_last = !empty($_POST['apply_last']) ? $_POST['apply_last'] : null;
$exam_date = !empty($_POST['exam_date']) ? $_POST['exam_date'] : null;
$result_date = !empty($_POST['result_date']) ? $_POST['result_date'] : null;

$official_website = trim($_POST['official_website'] ?? '');
$apply_link = trim($_POST['apply_link'] ?? '');

$seo_title = trim($_POST['seo_title'] ?? '');
$seo_description = trim($_POST['seo_description'] ?? '');
$seo_keywords = trim($_POST['seo_keywords'] ?? '');

$status = trim($_POST['status'] ?? 'draft');

/*
|--------------------------------------------------------------------------
| Validation
|--------------------------------------------------------------------------
*/

if ($category_id <= 0) {
    exit(json_encode([
        'success' => false,
        'message' => 'Select category.'
    ]));
}

if ($title == '') {
    exit(json_encode([
        'success' => false,
        'message' => 'Title is required.'
    ]));
}

if ($slug == '') {
    exit(json_encode([
        'success' => false,
        'message' => 'Slug is required.'
    ]));
}

if ($short_description == '') {
    exit(json_encode([
        'success' => false,
        'message' => 'Short description required.'
    ]));
}

if ($description == '') {
    exit(json_encode([
        'success' => false,
        'message' => 'Description required.'
    ]));
}

/*
|--------------------------------------------------------------------------
| URL Validation
|--------------------------------------------------------------------------
*/

if ($official_website != '' && !filter_var($official_website, FILTER_VALIDATE_URL)) {

    exit(json_encode([
        'success' => false,
        'message' => 'Official website URL invalid.'
    ]));

}

if ($apply_link != '' && !filter_var($apply_link, FILTER_VALIDATE_URL)) {

    exit(json_encode([
        'success' => false,
        'message' => 'Apply link invalid.'
    ]));

}

/*
|--------------------------------------------------------------------------
| Duplicate Slug
|--------------------------------------------------------------------------
*/

$check = $pdo->prepare("SELECT id FROM posts WHERE slug=? LIMIT 1");

$check->execute([$slug]);

if ($check->fetch()) {

    exit(json_encode([
        'success' => false,
        'message' => 'Slug already exists.'
    ]));

}

/*
|--------------------------------------------------------------------------
| Image Upload
|--------------------------------------------------------------------------
*/

if (!isset($_FILES['featured_image'])) {

    exit(json_encode([
        'success' => false,
        'message' => 'Featured image required.'
    ]));

}

$image = $_FILES['featured_image'];

if ($image['error'] != 0) {

    exit(json_encode([
        'success' => false,
        'message' => 'Image upload failed.'
    ]));

}

$finfo = finfo_open(FILEINFO_MIME_TYPE);

$mime = finfo_file($finfo, $image['tmp_name']);

finfo_close($finfo);

if ($mime != "image/webp") {

    exit(json_encode([
        'success' => false,
        'message' => 'Only WEBP image allowed.'
    ]));

}

if ($image['size'] > 102400) {

    exit(json_encode([
        'success' => false,
        'message' => 'Image size must be below 100 KB.'
    ]));

}

/*
|--------------------------------------------------------------------------
| Upload Folder
|--------------------------------------------------------------------------
*/

$uploadDir = __DIR__ . '/../../uploads/posts/';

if (!is_dir($uploadDir)) {

    mkdir($uploadDir, 0777, true);

}

$imageName = uniqid() . ".webp";

move_uploaded_file(
    $image['tmp_name'],
    $uploadDir . $imageName
);

/*
|--------------------------------------------------------------------------
| Insert
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("

INSERT INTO posts(

category_id,
post_type,
title,
slug,
short_description,
description,
featured_image,
organization,
qualification,
total_posts,
age_limit,
salary,
application_fee,
apply_start,
apply_last,
exam_date,
result_date,
official_website,
apply_link,
seo_title,
seo_description,
seo_keywords,
status

)

VALUES(

?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?

)

");

$stmt->execute([

$category_id,
$post_type,
$title,
$slug,
$short_description,
$description,
$imageName,
$organization,
$qualification,
$total_posts,
$age_limit,
$salary,
$application_fee,
$apply_start,
$apply_last,
$exam_date,
$result_date,
$official_website,
$apply_link,
$seo_title,
$seo_description,
$seo_keywords,
$status

]);

echo json_encode([

'success' => true,

'message' => 'Post published successfully.'

]);?>