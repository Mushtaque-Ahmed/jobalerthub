<?php

session_start();

header("Content-Type: application/json");

require_once __DIR__ . "/../../includes/database.php";

if (
    !isset($_SESSION["admin_logged_in"]) ||
    $_SESSION["admin_logged_in"] !== true
) {

    echo json_encode([
        "success" => false,
        "message" => "Unauthorized."
    ]);

    exit;

}

$id = (int)($_GET["id"] ?? 0);

if ($id <= 0) {

    echo json_encode([
        "success" => false,
        "message" => "Invalid PDF ID."
    ]);

    exit;

}

$stmt = $pdo->prepare("
SELECT *
FROM pdf_products
WHERE id = ?
LIMIT 1
");

$stmt->execute([$id]);

$pdf = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pdf) {

    echo json_encode([
        "success" => false,
        "message" => "PDF Product not found."
    ]);

    exit;

}

echo json_encode([
    "success" => true,
    "data" => $pdf
]);?>