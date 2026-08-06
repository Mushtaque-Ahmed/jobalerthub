<?php

header("Content-Type: application/json");

require_once __DIR__ . "/../../admin_hub/includes/database.php";

try {

    $search = trim($_GET["q"] ?? "");

    if ($search == "") {

        echo json_encode([
            "success" => false,
            "message" => "Empty search."
        ]);

        exit; 
    }

    $keyword = "%{$search}%";

    /*
    ==========================================
    POSTS
    ==========================================
    */

    $stmt = $pdo->prepare("

        SELECT

            id,
            title,
            slug,
            featured_image,
            post_type,
            organization,
            created_at

        FROM posts

        WHERE

            status='published'

        AND

        (

            title LIKE ?

            OR short_description LIKE ?

            OR description LIKE ?

        )

        ORDER BY created_at DESC

    ");

    $stmt->execute([

        $keyword,
        $keyword,
        $keyword

    ]);

    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    /*
    ==========================================
    PDF
    ==========================================
    */

    $stmt = $pdo->prepare("

        SELECT

            id,
            title,
            slug,
            featured_image,
            pages,
            language,
            is_free,
            price

        FROM pdf_products

        WHERE

            status=1

        AND

        (

            title LIKE ?

            OR short_description LIKE ?

            OR description LIKE ?

        )

        ORDER BY created_at DESC

    ");

    $stmt->execute([

        $keyword,
        $keyword,
        $keyword

    ]);

    $pdfs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    /*
    ==========================================
    RESPONSE
    ==========================================
    */

    echo json_encode([

        "success"=>true,

        "posts"=>$posts,

        "pdfs"=>$pdfs

    ]);

} catch(PDOException $e){

    echo json_encode([

        "success"=>false,

        "message"=>$e->getMessage()

    ]);

}?>