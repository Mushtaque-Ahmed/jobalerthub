<?php

header("Content-Type: application/json");

require_once __DIR__ . "/../../includes/database.php";

try {

    $id = (int)($_POST['id'] ?? 0);

    if ($id <= 0) {

        echo json_encode([
            "success" => false,
            "message" => "Invalid category."
        ]);
        exit;

    }

    // Check whether the category is used by any PDF
    $stmt = $pdo->prepare("
        SELECT COUNT(*)
        FROM pdf_products
        WHERE pdf_category_id = ?
    ");

    $stmt->execute([$id]);

    if ($stmt->fetchColumn() > 0) {

        echo json_encode([
            "success" => false,
            "message" => "Category cannot be deleted because it is assigned to PDF products."
        ]);
        exit;

    }

    $stmt = $pdo->prepare("
        DELETE FROM pdf_categories
        WHERE id=?
    ");

    $stmt->execute([$id]);

    echo json_encode([
        "success" => true,
        "message" => "Category deleted successfully."
    ]);

} catch(PDOException $e){

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);

}?>