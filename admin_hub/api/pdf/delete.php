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

$id = (int)($_POST["id"] ?? 0);

if ($id <= 0) {

    exit(json_encode([
        "success" => false,
        "message" => "Invalid PDF ID."
    ]));

}

/* Get Files */

$stmt = $pdo->prepare("
SELECT
featured_image,
pdf_file
FROM pdf_products
WHERE id=?
LIMIT 1
");

$stmt->execute([$id]);

$pdf = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pdf) {

    exit(json_encode([
        "success" => false,
        "message" => "PDF not found."
    ]));

}

/* Delete Database */

$stmt = $pdo->prepare("
DELETE FROM pdf_products
WHERE id=?
");

$stmt->execute([$id]);

/* Delete Thumbnail */

if (

    $pdf["featured_image"] &&

    file_exists(

        __DIR__ .
        "/../../uploads/pdf-images/" .
        $pdf["featured_image"]

    )

) {

    unlink(

        __DIR__ .
        "/../../uploads/pdf-images/" .
        $pdf["featured_image"]

    );

}

/* Delete PDF */

if (

    $pdf["pdf_file"] &&

    file_exists(

        __DIR__ .
        "/../../uploads/pdfs/" .
        $pdf["pdf_file"]

    )

) {

    unlink(

        __DIR__ .
        "/../../uploads/pdfs/" .
        $pdf["pdf_file"]

    );

}

echo json_encode([

    "success" => true,

    "message" => "PDF deleted successfully."

]);?>