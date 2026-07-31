<?php
// Turn off inline HTML error display to prevent malformed JSON outputs


session_start();

header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . "/../../includes/database.php";

/*=================================
AUTH & METHOD CHECK
=================================*/
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo json_encode([
        "success" => false,
        "message" => "Unauthorized."
    ]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "success" => false,
        "message" => "Invalid Request."
    ]);
    exit;
}

/*=================================
GET DATA
=================================*/
$category_id            = (int) ($_POST["category_id"] ?? 0);
$title                  = trim($_POST["title"] ?? "");
$slug                   = trim($_POST["slug"] ?? "");
$short_description     = trim($_POST["short_description"] ?? "");
$description           = $_POST["description"] ?? "";
$author                 = trim($_POST["author"] ?? "");
$language               = trim($_POST["language"] ?? "");
$pages                  = (int) ($_POST["pages"] ?? 0);
$price                  = (float) ($_POST["price"] ?? 0);
$is_free                = (int) ($_POST["is_free"] ?? 1);
$external_download_link = trim($_POST["external_download_link"] ?? "");
$seo_title              = trim($_POST["seo_title"] ?? "");
$seo_description        = trim($_POST["seo_description"] ?? "");
$seo_keywords           = trim($_POST["seo_keywords"] ?? "");
$status                 = $_POST["status"] ?? "draft";

/*=================================
VALIDATION
=================================*/
if ($category_id <= 0) {
    exit(json_encode(["success" => false, "message" => "Please select a category."]));
}

if ($title === "") {
    exit(json_encode(["success" => false, "message" => "Title is required."]));
}

if (strlen($title) < 5) {
    exit(json_encode(["success" => false, "message" => "Title must be at least 5 characters."]));
}

if ($slug === "") {
    exit(json_encode(["success" => false, "message" => "Slug is required."]));
}

if ($pages <= 0) {
    exit(json_encode(["success" => false, "message" => "Enter valid total pages."]));
}

if ($price < 0) {
    exit(json_encode(["success" => false, "message" => "Invalid price."]));
}

if (!in_array($status, ["draft", "published"], true)) {
    exit(json_encode(["success" => false, "message" => "Invalid status."]));
}

if ($external_download_link !== "" && !filter_var($external_download_link, FILTER_VALIDATE_URL)) {
    exit(json_encode(["success" => false, "message" => "Invalid download URL."]));
}

/* Duplicate Slug Check */
try {
    $stmt = $pdo->prepare("SELECT id FROM pdf_products WHERE slug = ? LIMIT 1");
    $stmt->execute([$slug]);

    if ($stmt->fetch()) {
        exit(json_encode(["success" => false, "message" => "Slug already exists."]));
    }
} catch (PDOException $e) {
    exit(json_encode(["success" => false, "message" => "Database validation error."]));
}

/*=================================
THUMBNAIL UPLOAD
=================================*/
if (!isset($_FILES["featured_image"]) || $_FILES["featured_image"]["error"] !== UPLOAD_ERR_OK) {
    exit(json_encode(["success" => false, "message" => "Thumbnail is required or upload failed."]));
}

$img = $_FILES["featured_image"];

// Check actual extension rather than relying strictly on browser-provided MIME type
$imgExt = strtolower(pathinfo($img["name"], PATHINFO_EXTENSION));
if ($imgExt !== "webp") {
    exit(json_encode(["success" => false, "message" => "Only WEBP images are allowed."]));
}

if ($img["size"] > 102400) { // 100 KB
    exit(json_encode(["success" => false, "message" => "Thumbnail must be below 100 KB."]));
}

$imageDir = __DIR__ . "/../../uploads/pdf-images/";
if (!is_dir($imageDir)) {
    mkdir($imageDir, 0755, true);
}

$imageName = time() . "_" . uniqid() . ".webp";
if (!move_uploaded_file($img["tmp_name"], $imageDir . $imageName)) {
    exit(json_encode(["success" => false, "message" => "Thumbnail upload failed."]));
}

/*=================================
PDF UPLOAD
=================================*/
if (!isset($_FILES["pdf_file"]) || $_FILES["pdf_file"]["error"] !== UPLOAD_ERR_OK) {
    exit(json_encode(["success" => false, "message" => "PDF file is required or upload failed."]));
}

$pdf = $_FILES["pdf_file"];
$pdfExt = strtolower(pathinfo($pdf["name"], PATHINFO_EXTENSION));

if ($pdfExt !== "pdf") {
    exit(json_encode(["success" => false, "message" => "Only PDF files are allowed."]));
}

if ($pdf["size"] > 50 * 1024 * 1024) { // 50 MB
    exit(json_encode(["success" => false, "message" => "PDF must be below 50 MB."]));
}

$pdfDir = __DIR__ . "/../../uploads/pdfs/";
if (!is_dir($pdfDir)) {
    mkdir($pdfDir, 0755, true);
}

$pdfName = time() . "_" . uniqid() . ".pdf";
if (!move_uploaded_file($pdf["tmp_name"], $pdfDir . $pdfName)) {
    // Clean up uploaded thumbnail if PDF upload fails
    if (file_exists($imageDir . $imageName)) {
        unlink($imageDir . $imageName);
    }
    exit(json_encode(["success" => false, "message" => "PDF upload failed."]));
}

$fileSize = round($pdf["size"] / 1024 / 1024, 2) . " MB";

/*=================================
INSERT TO DATABASE
=================================*/
$sql = "INSERT INTO pdf_products (
    category_id, title, slug, short_description, description,
    featured_image, pdf_file, file_size, pages, language,
    author, price, is_free, external_download_link, seo_title,
    seo_description, seo_keywords, status
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $category_id,
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
        $status
    ]);

    echo json_encode([
        "success" => true,
        "message" => "PDF Product created successfully."
    ]);
} catch (PDOException $e) {
    // Clean up files if database insertion fails
    if (file_exists($imageDir . $imageName)) unlink($imageDir . $imageName);
    if (file_exists($pdfDir . $pdfName)) unlink($pdfDir . $pdfName);

    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $e->getMessage() // Change to generic message in production
    ]);
}?>