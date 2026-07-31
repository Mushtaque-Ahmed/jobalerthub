<?php

header("Content-Type: application/json");

require_once __DIR__ . "/../../admin_hub/includes/database.php";

$slug = trim($_GET["slug"] ?? "");

if ($slug == "") {

    echo json_encode([
        "success" => false,
        "message" => "Invalid Slug."
    ]);

    exit;

}

/*
|--------------------------------------------------------------------------
| Get Job Details
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("

SELECT

    p.*,
    c.name AS category_name

FROM posts p

LEFT JOIN categories c
    ON c.id = p.category_id

WHERE

    p.slug = ?

    AND p.status = 'published'

LIMIT 1

");

$stmt->execute([$slug]);

$post = $stmt->fetch(PDO::FETCH_ASSOC);
/*
==========================================
LATEST RESULTS
==========================================
*/

$stmt = $pdo->query("

SELECT
    title,
    slug

FROM posts

WHERE

    post_type='result'

    AND status='published'

ORDER BY id DESC

LIMIT 5

");

$latestResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

/*
==========================================
LATEST ADMIT CARDS
==========================================
*/

$stmt = $pdo->query("

SELECT
    title,
    slug

FROM posts

WHERE

    post_type='admit_card'

    AND status='published'

ORDER BY id DESC

LIMIT 5

");

$latestAdmitCards = $stmt->fetchAll(PDO::FETCH_ASSOC);

/*
==========================================
LATEST PDF
==========================================
*/

$stmt = $pdo->query("

SELECT
    title,
    slug

FROM pdf_products

WHERE status='published'

ORDER BY id DESC

LIMIT 5

");

$latestPdf = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$post) {

    echo json_encode([

        "success" => false,

        "message" => "Job Not Found."

    ]);

    exit;

}

/*
|--------------------------------------------------------------------------
| Related Jobs
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("

SELECT

    p.id,
    p.title,
    p.slug,
    p.organization,
    p.apply_last,
    p.featured_image,
    c.name AS category_name

FROM posts p

LEFT JOIN categories c
    ON c.id = p.category_id

WHERE

    p.post_type = ?

    AND p.status = 'published'

    AND p.id != ?

ORDER BY p.id DESC

LIMIT 6

");

$stmt->execute([

    $post["post_type"],
    $post["id"]

]);

$related = $stmt->fetchAll(PDO::FETCH_ASSOC);
/*
==========================================
LATEST JOBS
==========================================
*/

$stmt = $pdo->query("

SELECT
    title,
    slug

FROM posts

WHERE

    post_type='job'

    AND status='published'

ORDER BY id DESC

LIMIT 5

");

$latestJobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
/*
==========================================
CATEGORIES
==========================================
*/

$stmt = $pdo->query("

SELECT
    id,
    name,
    slug,
    icon

FROM categories

WHERE status = 1

ORDER BY name ASC

");

$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Response
|--------------------------------------------------------------------------
*/
echo json_encode([

    "success" => true,

    "data" => $post,

    "related_jobs" => $related,

    "latest_jobs" => $latestJobs,

    "latest_results" => $latestResults,

    "latest_admit_cards" => $latestAdmitCards,

    "latest_pdf" => $latestPdf,

    "categories" => $categories

]);

?>