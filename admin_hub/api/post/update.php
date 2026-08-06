<?php

session_start();

header('Content-Type: application/json');

require_once __DIR__ . '/../../includes/database.php';

/*
|--------------------------------------------------------------------------
| Login Check
|--------------------------------------------------------------------------
*/

if (
    !isset($_SESSION['admin_logged_in']) ||
    $_SESSION['admin_logged_in'] !== true
) {

    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized.'
    ]);

    exit;

}

/*
|--------------------------------------------------------------------------
| Request Check
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    echo json_encode([
        'success' => false,
        'message' => 'Invalid Request.'
    ]);

    exit;

}

/*
|--------------------------------------------------------------------------
| Collect Data
|--------------------------------------------------------------------------
*/

$id = (int)($_POST['id'] ?? 0);

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

$apply_start = $_POST['apply_start'] ?: null;

$apply_last = $_POST['apply_last'] ?: null;

$exam_date = $_POST['exam_date'] ?: null;

$result_date = $_POST['result_date'] ?: null;

$official_website = trim($_POST['official_website'] ?? '');

$apply_link = trim($_POST['apply_link'] ?? '');

$seo_title = trim($_POST['seo_title'] ?? '');

$seo_description = trim($_POST['seo_description'] ?? '');

$seo_keywords = trim($_POST['seo_keywords'] ?? '');

$status = $_POST['status'];
$is_breaking = isset($_POST['is_breaking']) ? 1 : 0;

$old_image = $_POST['old_image'] ?? '';

/*
|--------------------------------------------------------------------------
| Validation
|--------------------------------------------------------------------------
*/

if ($id <= 0) {

    exit(json_encode([
        'success'=>false,
        'message'=>'Invalid Post.'
    ]));

}

if ($title == '' || $slug == '') {

    exit(json_encode([
        'success'=>false,
        'message'=>'Title and Slug are required.'
    ]));

}

/*
|--------------------------------------------------------------------------
| Duplicate Slug
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
SELECT id
FROM posts
WHERE slug=?
AND id<>?
LIMIT 1
");

$stmt->execute([$slug,$id]);

if($stmt->fetch()){

    exit(json_encode([
        'success'=>false,
        'message'=>'Slug already exists.'
    ]));

}

/*
|--------------------------------------------------------------------------
| URL Validation
|--------------------------------------------------------------------------
*/

if(
    $official_website!='' &&
    !filter_var($official_website,FILTER_VALIDATE_URL)
){

    exit(json_encode([
        'success'=>false,
        'message'=>'Official Website URL invalid.'
    ]));

}

if(
    $apply_link!='' &&
    !filter_var($apply_link,FILTER_VALIDATE_URL)
){

    exit(json_encode([
        'success'=>false,
        'message'=>'Apply Link URL invalid.'
    ]));

}

/*
|--------------------------------------------------------------------------
| Image Upload
|--------------------------------------------------------------------------
*/

$imageName = $old_image;

if(
    isset($_FILES['featured_image']) &&
    $_FILES['featured_image']['error']==0
){

    $file=$_FILES['featured_image'];

    if($file['type']!='image/webp'){

        exit(json_encode([
            'success'=>false,
            'message'=>'Only WEBP image allowed.'
        ]));

    }

    if($file['size']>102400){

        exit(json_encode([
            'success'=>false,
            'message'=>'Image must be below 100 KB.'
        ]));

    }

    $uploadDir=__DIR__."/../../uploads/posts/";

    if(
        $old_image!='' &&
        file_exists($uploadDir.$old_image)
    ){

        unlink($uploadDir.$old_image);

    }

    $imageName=time()."_".uniqid().".webp";

    move_uploaded_file(
        $file['tmp_name'],
        $uploadDir.$imageName
    );

}

/*
|--------------------------------------------------------------------------
| Update
|--------------------------------------------------------------------------
*/

$sql="

UPDATE posts SET

category_id=?,
post_type=?,
title=?,
slug=?,
short_description=?,
description=?,
featured_image=?,

organization=?,
qualification=?,
total_posts=?,
age_limit=?,
salary=?,
application_fee=?,

apply_start=?,
apply_last=?,
exam_date=?,
result_date=?,

official_website=?,
apply_link=?,

seo_title=?,
seo_description=?,
seo_keywords=?,

status=?,
is_breaking=?
WHERE id=?

";

$stmt=$pdo->prepare($sql);

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

$status,
$is_breaking,
$id

]);

echo json_encode([

    'success'=>true,

    'message'=>'Post updated successfully.'

]);?>