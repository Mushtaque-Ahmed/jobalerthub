<?php

require_once "admin_hub/includes/database.php";

$slug = trim($_GET["slug"] ?? "");

$stmt = $pdo->prepare("
    SELECT id, pdf_file
    FROM pdf_products
    WHERE slug = ?
      AND status = 1
      AND is_free = 1
    LIMIT 1
");

$stmt->execute([$slug]);

$pdf = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pdf) {
    http_response_code(404);
    exit("PDF not found.");
}

// Increase download count
$pdo->prepare("
    UPDATE pdf_products
    SET downloads = downloads + 1
    WHERE id = ?
")->execute([$pdf["id"]]);

$file = __DIR__ . "/admin_hub/uploads/pdfs/" . basename($pdf["pdf_file"]);

if (!file_exists($file)) {
    http_response_code(404);
    exit("File not found.");
}

header("Content-Type: application/pdf");
header("Content-Disposition: attachment; filename=\"" . basename($file) . "\"");
header("Content-Length: " . filesize($file));

readfile($file);
exit;?>