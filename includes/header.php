<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= htmlspecialchars($page_title ?? 'JobAdAssam') ?></title>

    <meta name="description" content="<?= htmlspecialchars($meta_description ?? '') ?>">

    <meta name="keywords" content="<?= htmlspecialchars($meta_keywords ?? '') ?>">

    <meta name="robots" content="index,follow">

    <meta name="author" content="<?= htmlspecialchars($settings['site_name'] ?? 'JobAdAssam') ?>">

    <link rel="canonical" href="<?= htmlspecialchars($canonical ?? BASE_URL) ?>">

    <!-- Open Graph -->

    <meta property="og:type" content="<?= $og_type ?? 'website' ?>">

    <meta property="og:title" content="<?= htmlspecialchars($og_title ?? $page_title ?? '') ?>">

    <meta property="og:description" content="<?= htmlspecialchars($og_description ?? $meta_description ?? '') ?>">

    <meta property="og:url" content="<?= htmlspecialchars($og_url ?? $canonical ?? BASE_URL) ?>">

    <meta property="og:image" content="<?= htmlspecialchars($og_image ?? BASE_URL . 'assets/image/default-og.webp') ?>">

    <meta property="og:site_name" content="JobAdAssam">

    <!-- Twitter -->

    <meta name="twitter:card" content="summary_large_image">

    <meta name="twitter:title" content="<?= htmlspecialchars($og_title ?? $page_title ?? '') ?>">

    <meta name="twitter:description" content="<?= htmlspecialchars($og_description ?? $meta_description ?? '') ?>">

    <meta name="twitter:image"
        content="<?= htmlspecialchars($og_image ?? BASE_URL.'admin_hub/uploads/settings/'.$settings['site_logo']) ?>">

    <!-- Favicon -->
    <link rel="icon"
        href="<?= BASE_URL ?>admin_hub/uploads/settings/<?= htmlspecialchars($settings['site_favicon'] ?? 'favicon.webp') ?>">



    <!-- Theme -->
    <meta name="theme-color" content="#0d6efd">
    <meta name="msapplication-TileColor" content="#0d6efd">


    <link rel="preload" href="<?= BASE_URL ?>assets/css/bootstrap.min.css" as="style"
        onload="this.onload=null;this.rel='stylesheet'">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- google fonts start -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="preload" as="style"
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        onload="this.onload=null;this.rel='stylesheet'">

    <noscript>
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    </noscript>
    <!-- google fonts end -->
    <link rel="preload" href="<?= BASE_URL ?>assets/css/style.css" as="style"
        onload="this.onload=null;this.rel='stylesheet'">

    <link rel="preload" href="<?= BASE_URL ?>assets/css/search.css" as="style"
        onload="this.onload=null;this.rel='stylesheet'">

    <noscript>
        <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/search.css">
    </noscript>


</head>

<body>