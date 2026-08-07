<?php

header("Content-Type: application/json");

require_once __DIR__ . "/../../includes/database.php";

try {

    $stmt = $pdo->query("
        SELECT
            id,
            name,
            slug,
            status,
            created_at
        FROM pdf_categories
        ORDER BY id DESC
    ");

    echo json_encode([
        "success" => true,
        "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)
    ]);

} catch(PDOException $e){

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);

}?>