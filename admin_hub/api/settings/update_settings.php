<?php
// 1. Catch any output or stray whitespace from required files so it doesn't break JSON
ob_start();

session_start();

// Suppress displaying HTML errors to the client; handle them via JSON instead
ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once __DIR__ . "/../../includes/config.php";
require_once __DIR__ . "/../../includes/database.php";

// Clear any accidental output from included files
ob_end_clean();

header("Content-Type: application/json; charset=utf-8");

// Check login
if (
    !isset($_SESSION['admin_logged_in']) ||
    $_SESSION['admin_logged_in'] !== true
) {
    echo json_encode([
        "status" => "error",
        "message" => "Unauthorized access"
    ]);
    exit;
}

try {
    $uploadDir = __DIR__ . "/../../uploads/settings/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $data = $_POST;

    // Helper function to safely get post variables without throwing "Undefined array key" warnings
    function getPostVal($key, $data) {
        return isset($data[$key]) ? trim($data[$key]) : null;
    }

    $site_logo = null;
    $site_favicon = null;

    // GET OLD DATA
    $stmt = $pdo->query("
        SELECT site_logo, site_favicon
        FROM settings
        WHERE id=1
    ");
    $old = $stmt->fetch(PDO::FETCH_ASSOC);

    // LOGO UPLOAD
    if (isset($_FILES['site_logo']) && $_FILES['site_logo']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['site_logo'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if ($ext !== "webp") {
            echo json_encode([
                "status" => "error",
                "message" => "Only WEBP logo allowed"
            ]);
            exit;
        }

        $name = "logo_" . time() . ".webp";
        move_uploaded_file($file['tmp_name'], $uploadDir . $name);
        $site_logo = $name;
    }

    // FAVICON UPLOAD
    if (isset($_FILES['site_favicon']) && $_FILES['site_favicon']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['site_favicon'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if ($ext !== "webp") {
            echo json_encode([
                "status" => "error",
                "message" => "Only WEBP favicon allowed"
            ]);
            exit;
        }

        $name = "favicon_" . time() . ".webp";
        move_uploaded_file($file['tmp_name'], $uploadDir . $name);
        $site_favicon = $name;
    }

    // KEEP OLD IMAGE IF NEW ONE IS NOT UPLOADED
    if (!$site_logo) {
        $site_logo = $old['site_logo'] ?? null;
    }

    if (!$site_favicon) {
        $site_favicon = $old['site_favicon'] ?? null;
    }

    $sql = "
    UPDATE settings SET
        site_name = ?,
        site_email = ?,
        site_phone = ?,
        site_address = ?,
        footer_text = ?,

        facebook = ?,
        twitter = ?,
        instagram = ?,
        youtube = ?,
        linkedin = ?,

        site_logo = ?,
        site_favicon = ?,

        meta_title = ?,
        meta_description = ?,
        meta_keywords = ?,

        google_verification = ?,
        google_analytics = ?
    WHERE id = 1
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        getPostVal('site_name', $data),
        getPostVal('site_email', $data),
        getPostVal('site_phone', $data),
        getPostVal('site_address', $data),
        getPostVal('footer_text', $data),

        getPostVal('facebook', $data),
        getPostVal('twitter', $data),
        getPostVal('instagram', $data),
        getPostVal('youtube', $data),
        getPostVal('linkedin', $data),

        $site_logo,
        $site_favicon,

        getPostVal('meta_title', $data),
        getPostVal('meta_description', $data),
        getPostVal('meta_keywords', $data),

        getPostVal('google_verification', $data),
        getPostVal('google_analytics', $data)
    ]);

    echo json_encode([
        "status" => "success",
        "message" => "Website settings updated successfully"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}?>