<?php

header("Content-Type: application/json");

require_once __DIR__ . "/../../admin_hub/includes/database.php";

try {

    /*
    =====================================
    GET PARAMETERS
    =====================================
    */

    $page = max(1, (int)($_GET['page'] ?? 1));

    $search = trim($_GET['search'] ?? '');

    $category = (int)($_GET['category'] ?? 0);

    $limit = 12;

    $offset = ($page - 1) * $limit;

    /*
    =====================================
    BUILD WHERE
    =====================================
    */

    $where = [];

    $params = [];

    $where[] = "p.status= 1 ";

    if ($search != "") {

        $where[] = "p.title LIKE ?";

        $params[] = "%{$search}%";

    }

    if ($category > 0) {

        $where[] = "p.category_id=?";

        $params[] = $category;

    }

    $whereSql = implode(" AND ", $where);

    /*
    =====================================
    TOTAL PDF
    =====================================
    */

    $stmt = $pdo->prepare("

        SELECT COUNT(*)

        FROM pdf_products p

        WHERE {$whereSql}

    ");

    $stmt->execute($params);

    $totalPdf = $stmt->fetchColumn();

    $totalPages = ceil($totalPdf / $limit);

    /*
    =====================================
    PDF LIST
    =====================================
    */

    $sql = "

    SELECT

        p.id,
        p.title,
        p.slug,
        p.featured_image,
        p.file_size,
        p.price,
        p.is_free,
        p.pages,
        p.language,
        p.author,
        p.seo_title,
        p.seo_description,
        p.seo_keywords,
        p.downloads,
        p.created_at,
        c.name AS category_name

    FROM pdf_products p

    LEFT JOIN categories c

        ON c.id = p.category_id

    WHERE {$whereSql}

    ORDER BY p.created_at DESC

    LIMIT {$limit}

    OFFSET {$offset}

    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute($params);

    $pdfs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    /*
    =====================================
    CATEGORIES
    =====================================
    */

    $stmt = $pdo->query("

        SELECT

            id,
            name,
            slug

        FROM categories

        WHERE status = 1

        ORDER BY name ASC

    ");

    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    /*
    =====================================
    RESPONSE
    =====================================
    */

    echo json_encode([

        "success" => true,

        "pdfs" => $pdfs,

        "categories" => $categories,

        "pagination" => [

            "page" => $page,

            "limit" => $limit,

            "total_pdf" => (int)$totalPdf,

            "total_pages" => (int)$totalPages

        ]

    ]);

} catch (PDOException $e) {

    echo json_encode([

        "success" => false,

        "message" => $e->getMessage()

    ]);

}
?>