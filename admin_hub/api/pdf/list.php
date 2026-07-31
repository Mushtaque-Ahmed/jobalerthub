<?php

session_start();

header("Content-Type: application/json");
require_once __DIR__ . "/../../includes/config.php";

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

/* =========================
GET FILTERS
========================= */

$page = max(1, (int)($_GET["page"] ?? 1));

$limit = 10;

$offset = ($page - 1) * $limit;

$search = trim($_GET["search"] ?? "");

$category = (int)($_GET["category"] ?? 0);

$status = $_GET["status"] ?? "";

/* =========================
WHERE
========================= */

$where = [];

$params = [];

if ($search != "") {

    $where[] = "p.title LIKE ?";

    $params[] = "%{$search}%";

}

if ($category > 0) {

    $where[] = "p.category_id=?";

    $params[] = $category;

}

if ($status !== "") {

    $where[] = "p.status=?";

    $params[] = (int)$status;

}

$whereSQL = "";

if ($where) {

    $whereSQL = "WHERE " . implode(" AND ", $where);

}

/* =========================
TOTAL
========================= */

$stmt = $pdo->prepare("
SELECT COUNT(*)
FROM pdf_products p
$whereSQL
");

$stmt->execute($params);

$total = $stmt->fetchColumn();

$totalPages = ceil($total / $limit);

/* =========================
LIST
========================= */

$sql = "

SELECT

p.*,

c.name AS category_name

FROM pdf_products p

LEFT JOIN categories c

ON c.id=p.category_id

$whereSQL

ORDER BY p.id DESC

LIMIT $limit OFFSET $offset

";

$stmt = $pdo->prepare($sql);

$stmt->execute($params);

$rows = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    $row["image"] = BASE_URL .
        "uploads/pdf-images/" .
        $row["featured_image"];

    $row["status_badge"] =
        $row["status"] == 1
        ? '<span class="badge bg-success">Published</span>'
        : '<span class="badge bg-secondary">Draft</span>';

    $row["price_text"] =
        $row["is_free"] == 1
        ? '<span class="badge bg-success">Free</span>'
        : "₹" . number_format($row["price"], 2);

    $row["created"] = date(
        "d M Y",
        strtotime($row["created_at"])
    );

    $rows[] = $row;

}

echo json_encode([

    "success" => true,

    "data" => $rows,

    "page" => $page,

    "total_pages" => $totalPages,

    "total_records" => $total

]);?>