<?php

header("Content-Type: application/json");

require_once __DIR__ . "/../../includes/database.php";

try {

    $id = (int)($_GET["id"] ?? 0);

    $stmt = $pdo->prepare("
        SELECT
            id,
            name,
            slug,
            status
        FROM pdf_categories
        WHERE id=?
        LIMIT 1
    ");

    $stmt->execute([$id]);

    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($category) {

        echo json_encode([
            "success" => true,
            "data" => $category
        ]);

    } else {

        echo json_encode([
            "success" => false,
            "message" => "Category not found."
        ]);

    }

} catch(PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);

}?>