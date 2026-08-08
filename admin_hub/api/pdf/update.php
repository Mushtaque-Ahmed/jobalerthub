<?php

session_start();

header("Content-Type: application/json");

require_once __DIR__ . "/../../includes/database.php";

if (
    !isset($_SESSION['admin_logged_in']) ||
    $_SESSION['admin_logged_in'] !== true
) {

    exit(json_encode([
        "success" => false,
        "message" => "Unauthorized."
    ]));

}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    exit(json_encode([
        "success" => false,
        "message" => "Invalid Request."
    ]));

}

$id = (int)($_POST["id"] ?? 0);

$pdf_category_id = (int)($_POST["pdf_category_id"] ?? 0);

$title = trim($_POST["title"] ?? "");

$slug = trim($_POST["slug"] ?? "");

$short_description = trim($_POST["short_description"] ?? "");

$description = $_POST["description"] ?? "";

$author = trim($_POST["author"] ?? "");

$language = trim($_POST["language"] ?? "");

$pages = (int)($_POST["pages"] ?? 0);

$price = (float)($_POST["price"] ?? 0);

$is_free = (int)($_POST["is_free"] ?? 1);

$external_download_link = trim($_POST["external_download_link"] ?? "");

$seo_title = trim($_POST["seo_title"] ?? "");

$seo_description = trim($_POST["seo_description"] ?? "");

$seo_keywords = trim($_POST["seo_keywords"] ?? "");

$status = (int)($_POST["status"] ?? 0);

if ($id <= 0) {

    exit(json_encode([
        "success" => false,
        "message" => "Invalid PDF."
    ]));

}

$stmt = $pdo->prepare("
SELECT *
FROM pdf_products
WHERE id=?
LIMIT 1
");

$stmt->execute([$id]);

$old = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$old) {

    exit(json_encode([
        "success" => false,
        "message" => "PDF not found."
    ]));

}

/* Duplicate Slug */

$stmt = $pdo->prepare("
SELECT id
FROM pdf_products
WHERE slug=?
AND id<>?
LIMIT 1
");

$stmt->execute([$slug,$id]);

if($stmt->fetch()){

    exit(json_encode([
        "success"=>false,
        "message"=>"Slug already exists."
    ]));

}

/* Thumbnail */

$imageName = $old["featured_image"];

if(

    isset($_FILES["featured_image"]) &&

    $_FILES["featured_image"]["error"] == UPLOAD_ERR_OK

){

    $img = $_FILES["featured_image"];

    if($img["type"]!="image/webp"){

        exit(json_encode([
            "success"=>false,
            "message"=>"Only WEBP image allowed."
        ]));

    }

    $imageName=time()."_".uniqid().".webp";

    move_uploaded_file(

        $img["tmp_name"],

        __DIR__."/../../uploads/pdf-images/".$imageName

    );

    if(

        $old["featured_image"] &&

        file_exists(

            __DIR__."/../../uploads/pdf-images/".$old["featured_image"]

        )

    ){

        unlink(

            __DIR__."/../../uploads/pdf-images/".$old["featured_image"]

        );

    }

}

/* PDF */

$pdfName = $old["pdf_file"];

$fileSize = $old["file_size"];

if(

    isset($_FILES["pdf_file"]) &&

    $_FILES["pdf_file"]["error"]==UPLOAD_ERR_OK

){

    $pdf=$_FILES["pdf_file"];

    $ext=strtolower(

        pathinfo($pdf["name"],PATHINFO_EXTENSION)

    );

    if($ext!="pdf"){

        exit(json_encode([
            "success"=>false,
            "message"=>"Only PDF allowed."
        ]));

    }

    $pdfName=time()."_".uniqid().".pdf";

    move_uploaded_file(

        $pdf["tmp_name"],

        __DIR__."/../../uploads/pdfs/".$pdfName

    );

    $fileSize=round($pdf["size"]/1024/1024,2)." MB";

    if(

        $old["pdf_file"] &&

        file_exists(

            __DIR__."/../../uploads/pdfs/".$old["pdf_file"]

        )

    ){

        unlink(

            __DIR__."/../../uploads/pdfs/".$old["pdf_file"]

        );

    }

}

/* Update */

$stmt=$pdo->prepare("

UPDATE pdf_products SET

pdf_category_id=?,

title=?,

slug=?,

short_description=?,

description=?,

featured_image=?,

pdf_file=?,

file_size=?,

pages=?,

language=?,

author=?,

price=?,

is_free=?,

external_download_link=?,

seo_title=?,

seo_description=?,

seo_keywords=?,

status=?,

updated_at=NOW()

WHERE id=?

");

$stmt->execute([

    $pdf_category_id,

    $title,

    $slug,

    $short_description,

    $description,

    $imageName,

    $pdfName,

    $fileSize,

    $pages,

    $language,

    $author,

    $price,

    $is_free,

    $external_download_link,

    $seo_title,

    $seo_description,

    $seo_keywords,

    $status,

    $id

]);

echo json_encode([

    "success"=>true,

    "message"=>"PDF updated successfully."

]);?>