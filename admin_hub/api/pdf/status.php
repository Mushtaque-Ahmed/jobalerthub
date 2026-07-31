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

$status = (int)($_POST["status"] ?? 0);

if ($id <= 0) {

    exit(json_encode([
        "success" => false,
        "message" => "Invalid PDF."
    ]));

}

$status = $status ? 1 : 0;

$stmt = $pdo->prepare("
UPDATE pdf_products
SET status = ?,
updated_at = NOW()
WHERE id = ?
");

$stmt->execute([$status, $id]);

echo json_encode([
    "success" => true,
    "message" => $status
        ? "PDF published successfully."
        : "PDF moved to draft."
]);?>