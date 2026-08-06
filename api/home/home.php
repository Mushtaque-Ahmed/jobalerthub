<?php

header("Content-Type: application/json");

require_once __DIR__ . "/../../includes/database.php";

try {

    $data = [];

    /*
    =====================================
    SETTINGS
    =====================================
    */

    $stmt = $pdo->query("
        SELECT *
        FROM settings
        LIMIT 1
    ");

    $data["settings"] = $stmt->fetch(PDO::FETCH_ASSOC);

    /*
    =====================================
    HERO STATISTICS
    =====================================
    */

    $data["statistics"] = [

        "total_posts" => (int)$pdo->query("
            SELECT COUNT(*)
            FROM posts
            WHERE status='published'
        ")->fetchColumn(),

        "total_categories" => (int)$pdo->query("
            SELECT COUNT(*)
            FROM categories
            WHERE status=1
        ")->fetchColumn(),

        "total_pdfs" => (int)$pdo->query("
            SELECT COUNT(*)
            FROM pdf_products
            WHERE status=1
        ")->fetchColumn(),

        "total_pdf_downloads" => (int)$pdo->query("
            SELECT COALESCE(SUM(downloads),0)
            FROM pdf_products
            WHERE status=1
        ")->fetchColumn()

    ];

    /*
    =====================================
    LATEST POSTS
    =====================================
    */

    $stmt = $pdo->prepare("
       SELECT
    p.id,
    p.title,
    p.slug,
    p.short_description,
    p.featured_image,
    p.created_at,
    c.name AS category_name
FROM posts p
LEFT JOIN categories c
    ON c.id = p.category_id
WHERE p.status = 'published'
AND p.post_type='job'
ORDER BY p.id DESC
LIMIT 6
    ");

    $stmt->execute();

    $data["latest_jobs"] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    /*
=================================
LATEST RESULTS
=================================
*/

$stmt = $pdo->prepare("
SELECT
    p.id,
    p.title,
    p.slug,
    p.short_description,
    p.featured_image,
    p.created_at,
    c.name AS category_name
FROM posts p
LEFT JOIN categories c
ON c.id=p.category_id
WHERE p.status='published'
AND p.post_type='result'
ORDER BY p.id DESC
LIMIT 6
");

$stmt->execute();

$data["latest_results"] = $stmt->fetchAll(PDO::FETCH_ASSOC);

/*
=================================
LATEST ADMIT CARDS
=================================
*/

$stmt = $pdo->prepare("
SELECT
    p.id,
    p.title,
    p.slug,
    p.short_description,
    p.featured_image,
    p.created_at
FROM posts p
WHERE
    p.status='published'
    AND p.post_type='admit_card'
ORDER BY p.id DESC
LIMIT 8
");

$stmt->execute();

$data["latest_admit_cards"] = $stmt->fetchAll(PDO::FETCH_ASSOC);
/* ===============================
        current affairs
 ================================*/
 $stmt = $pdo->prepare("
SELECT
    id,
    title,
    slug,
    short_description,
    featured_image,
    created_at
FROM posts
WHERE
    status='published'
    AND post_type='current-affairs'
ORDER BY id DESC
LIMIT 3
");

$stmt->execute();

$data["current_affairs"] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    /*
    =====================================
    LATEST PDF PRODUCTS
    =====================================
    */

    $stmt = $pdo->query("
        SELECT
            id,
            title,
            slug,
            featured_image,
            price,
            pages,
            downloads,
            is_free
        FROM pdf_products
        WHERE status=1
        ORDER BY id DESC
        LIMIT 8
    ");

    $data["pdf_products"] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    /* =====================================
    breaking newas
    =====================================*/
    $stmt = $pdo->prepare("
SELECT
    title,
    slug,
    post_type
FROM posts
WHERE
    status='published'
    AND is_breaking=1
ORDER BY created_at DESC
LIMIT 10
");

$stmt->execute();

$data["breakingNews"] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    /*
    =====================================
    CATEGORIES
    =====================================
    */

    $stmt = $pdo->query("
     SELECT
    c.id,
    c.name,
    c.icon,
    c.slug,
    COUNT(p.id) AS total_posts
FROM categories c
LEFT JOIN posts p
    ON p.category_id = c.id
    AND p.status = 'published'
WHERE c.status = 1
GROUP BY c.id
ORDER BY c.name");

    $data["categories"] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "data" => $data
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);

}?>