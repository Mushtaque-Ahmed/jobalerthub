<?php

header("Content-Type: application/json");

require_once __DIR__ . "/../../includes/database.php";

try {

    $id     = (int)($_POST['id'] ?? 0);
    $name   = trim($_POST['name'] ?? '');
    $slug   = trim($_POST['slug'] ?? '');
    $status = (int)($_POST['status'] ?? 1);

    if ($id <= 0 || $name == "" || $slug == "") {

        echo json_encode([
            "success" => false,
            "message" => "All fields are required."
        ]);
        exit;

    }

    // Check duplicate slug
    $stmt = $pdo->prepare("
        SELECT id
        FROM pdf_categories
        WHERE slug = ?
        AND id != ?
        LIMIT 1
    ");

    $stmt->execute([$slug, $id]);

    if ($stmt->fetch()) {

        echo json_encode([
            "success" => false,
            "message" => "Slug already exists."
        ]);
        exit;

    }

    $stmt = $pdo->prepare("
        UPDATE pdf_categories
        SET
            name = ?,
            slug = ?,
            status = ?
        WHERE id = ?
    ");

    $stmt->execute([
        $name,
        $slug,
        $status,
        $id
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Category updated successfully."
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);

}?>