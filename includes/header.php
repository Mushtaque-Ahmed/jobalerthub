
<?php
$json = file_get_contents("http://localhost/jobalerthub/api/home/home.php");

$response = json_decode($json, true);

if (!$response || !$response["success"]) {
    die("Unable to load homepage.");
}

$data = $response["data"];

$settings = $data["settings"];
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?= htmlspecialchars($settings['meta_title'] ?? 'JobAdAssam') ?></title>

<meta name="description" content="<?= htmlspecialchars($settings['meta_description'] ?? '') ?>">
<meta name="keywords" content="<?= htmlspecialchars($settings['meta_keywords'] ?? '') ?>">

<meta name="robots" content="index, follow">
<meta name="author" content="<?= htmlspecialchars($settings['site_name'] ?? 'JobAdAssam') ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="canonical" href="<?= BASE_URL ?>">

<!-- Favicon -->
<link rel="icon"
      href="<?= BASE_URL ?>admin_hub/uploads/settings/<?= htmlspecialchars($settings['site_favicon'] ?? 'favicon.webp') ?>">

<!-- Open Graph -->
<meta property="og:type" content="website">
<meta property="og:site_name" content="<?= htmlspecialchars($settings['site_name'] ?? 'JobAdAssam') ?>">
<meta property="og:title" content="<?= htmlspecialchars($settings['meta_title'] ?? 'JobAdAssam') ?>">
<meta property="og:description" content="<?= htmlspecialchars($settings['meta_description'] ?? '') ?>">
<meta property="og:url" content="<?= BASE_URL ?>">
<meta property="og:image" content="<?= BASE_URL ?>admin_hub/uploads/posts/<?= htmlspecialchars($settings['site_logo'] ?? 'logo.webp') ?>">
<meta property="og:image:alt" content="<?= htmlspecialchars($settings['site_name'] ?? 'JobAdAssam') ?>">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= htmlspecialchars($settings['meta_title'] ?? 'JobAdAssam') ?>">
<meta name="twitter:description" content="<?= htmlspecialchars($settings['meta_description'] ?? '') ?>">
<meta name="twitter:image" content="<?= BASE_URL ?>admin_hub/uploads/settings/<?= htmlspecialchars($settings['site_logo'] ?? 'logo.webp') ?>">

<!-- Theme -->
<meta name="theme-color" content="#0d6efd">
<meta name="msapplication-TileColor" content="#0d6efd">
<link rel="icon"
      type="image/webp"
      href="<?= BASE_URL ?>admin_hub/uploads/settings/<?= htmlspecialchars($settings['site_favicon'] ?? 'favicon.webp') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">

</head>

<body>