<?php

header("Content-Type: application/json");

require_once __DIR__ . "/../../admin_hub/includes/database.php";

try {

    /*
    =====================================
    GET PARAMETERS
    =====================================
    */

    $type = trim($_GET['type'] ?? 'job');

    $page = max(1, (int)($_GET['page'] ?? 1));

    $search = trim($_GET['search'] ?? '');

    $category = (int)($_GET['category'] ?? 0);

    $limit = 12;

    $offset = ($page - 1) * $limit;

    /*
    =====================================
    ALLOWED TYPES
    =====================================
    */

    $allowedTypes = [

        "job",
        "result",
        "admit-card",
        "answer-key",
        "current-affairs"

    ];

    if (!in_array($type, $allowedTypes)) {

        echo json_encode([
            "success" => false,
            "message" => "Invalid Post Type"
        ]);

        exit;

    }

    /*
    =====================================
    BUILD WHERE
    =====================================
    */

    $where = [];

    $params = [];

    $where[] = "p.status='published'";

    $where[] = "p.post_type=?";

    $params[] = $type;

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
    TOTAL POSTS
    =====================================
    */

    $countSql = "

        SELECT COUNT(*)

        FROM posts p

        WHERE {$whereSql}

    ";

    $stmt = $pdo->prepare($countSql);

    $stmt->execute($params);

    $totalPosts = $stmt->fetchColumn();

    $totalPages = ceil($totalPosts / $limit);

    /*
    =====================================
    GET POSTS
    =====================================
    */

    $sql = "

    SELECT

        p.id,
        p.title,
        p.slug,
        p.organization,
        p.featured_image,
        p.qualification,
        p.total_posts,
        p.salary,
        p.apply_last,
        p.created_at,
        c.name AS category_name

    FROM posts p

    LEFT JOIN categories c

        ON c.id=p.category_id

    WHERE {$whereSql}

    ORDER BY p.created_at DESC

    LIMIT {$limit}

    OFFSET {$offset}

    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute($params);

    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

        WHERE status=1

        ORDER BY name

    ");

    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    /*
    =====================================
    RESPONSE
    =====================================
    */

    echo json_encode([

        "success" => true,

        "posts" => $posts,

        "categories" => $categories,

        "pagination" => [

            "page" => $page,

            "limit" => $limit,

            "total_posts" => (int)$totalPosts,

            "total_pages" => (int)$totalPages

        ]

    ]);

} catch (PDOException $e) {

    echo json_encode([

        "success" => false,

        "message" => $e->getMessage()

    ]);

}?>