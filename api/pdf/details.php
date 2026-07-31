<?php

header("Content-Type: application/json");

require_once __DIR__ . "/../../admin_hub/includes/database.php";

$slug = trim($_GET["slug"] ?? "");

if ($slug == "") {

    echo json_encode([
        "success" => false,
        "message" => "Invalid Slug."
    ]);

    exit;
}

/*
|--------------------------------------------------------------------------
| Get PDF Details
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("

SELECT *

FROM pdf_products

WHERE

slug = ?

AND status = 1

LIMIT 1

");

$stmt->execute([$slug]);

$pdf = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pdf) {

    echo json_encode([

        "success" => false,

        "message" => "PDF Not Found."

    ]);

    exit;
}

/*
|--------------------------------------------------------------------------
| Latest PDFs
|--------------------------------------------------------------------------
*/

$stmt = $pdo->query("

SELECT

    id,
    title,
    slug

FROM pdf_products

WHERE status=1

ORDER BY created_at DESC

LIMIT 5

");

$latestPdf = $stmt->fetchAll(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Related PDFs
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("

SELECT

    id,
    title,
    slug,
    featured_image,
    pages,
    language,
    price,
    is_free

FROM pdf_products

WHERE

status=1

AND id != ?

ORDER BY created_at DESC

LIMIT 6

");

$stmt->execute([

    $pdf["id"]

]);

$relatedPdf = $stmt->fetchAll(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Response
|--------------------------------------------------------------------------
*/

echo json_encode([

    "success" => true,

    "data" => $pdf,

    "latest_pdf" => $latestPdf,

    "related_pdf" => $relatedPdf

]);?>