<?php

session_start();

if (
    !isset($_SESSION['admin_logged_in']) ||
    $_SESSION['admin_logged_in'] !== true
) {
    header("Location: index.php");
    exit;
}

require_once __DIR__ . "/../includes/config.php";
require_once __DIR__ . "/../includes/database.php";

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("

SELECT
posts.*,
categories.name AS category_name

FROM posts

LEFT JOIN categories
ON categories.id=posts.category_id

WHERE posts.id=?

LIMIT 1

");

$stmt->execute([$id]);

$post = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$post){

    die("Post not found.");

}

$page_title="View Post";

require_once __DIR__."/../includes/header.php";
require_once __DIR__."/../includes/navbar.php";
require_once __DIR__."/../includes/sidebar.php";

?>

<div class="container-fluid px-4">

<div class="d-flex justify-content-between align-items-center mt-4 mb-4">

<h3>

<?= htmlspecialchars($post['title']) ?>

</h3>

<div>

<a
href="<?= BASE_URL ?>posts/edit.php?id=<?= $post['id'] ?>"
class="btn btn-warning">

<i class="bi bi-pencil"></i>

Edit

</a>

<a
href="<?= BASE_URL ?>posts/index.php"
class="btn btn-secondary">

Back

</a>

</div>

</div>
<div class="card shadow mb-4">

<div class="card-header fw-bold">

Post Information

</div>

<div class="card-body">

<div class="row">

<div class="col-md-4">

<strong>Category</strong>

<p><?= htmlspecialchars($post['category_name']) ?></p>

</div>

<div class="col-md-4">

<strong>Post Type</strong>

<p><?= htmlspecialchars($post['post_type']) ?></p>

</div>

<div class="col-md-4">

<strong>Status</strong>

<p>

<span class="badge <?= $post['status']=="published"
? "bg-success"
: "bg-secondary" ?>">

<?= ucfirst($post['status']) ?>

</span>

</p>

</div>

</div>

<hr>

<strong>Short Description</strong>

<p>

<?= nl2br(htmlspecialchars($post['short_description'])) ?>

</p>

<hr>

<strong>Description</strong>

<div>

<?= $post['description'] ?>

</div>

</div>

</div>
<div class="card shadow mb-4">

<div class="card-header fw-bold">

Job Details

</div>

<div class="card-body">

<div class="row">

<div class="col-md-6">

<strong>Organization</strong>

<p><?= htmlspecialchars($post['organization']) ?></p>

</div>

<div class="col-md-6">

<strong>Qualification</strong>

<p><?= htmlspecialchars($post['qualification']) ?></p>

</div>

<div class="col-md-4">

<strong>Total Posts</strong>

<p><?= htmlspecialchars($post['total_posts']) ?></p>

</div>

<div class="col-md-4">

<strong>Age Limit</strong>

<p><?= htmlspecialchars($post['age_limit']) ?></p>

</div>

<div class="col-md-4">

<strong>Salary</strong>

<p><?= htmlspecialchars($post['salary']) ?></p>

</div>

<div class="col-md-6">

<strong>Application Fee</strong>

<p><?= htmlspecialchars($post['application_fee']) ?></p>

</div>

<div class="col-md-6">

<strong>Apply Start</strong>

<p><?= $post['apply_start'] ?></p>

</div>

<div class="col-md-6">

<strong>Apply Last</strong>

<p><?= $post['apply_last'] ?></p>

</div>

<div class="col-md-6">

<strong>Exam Date</strong>

<p><?= $post['exam_date'] ?></p>

</div>

<div class="col-md-6">

<strong>Result Date</strong>

<p><?= $post['result_date'] ?></p>

</div>

<div class="col-md-6">

<strong>Official Website</strong>

<p>

<a
target="_blank"
href="<?= htmlspecialchars($post['official_website']) ?>">

<?= htmlspecialchars($post['official_website']) ?>

</a>

</p>

</div>

<div class="col-md-6">

<strong>Apply Link</strong>

<p>

<a
target="_blank"
href="<?= htmlspecialchars($post['apply_link']) ?>">

Apply Now

</a>

</p>

</div>

</div>

</div>

</div>
<div class="row">

<div class="col-lg-8">

<!-- Previous Cards -->

</div>

<div class="col-lg-4">

<div class="card shadow mb-4">

<div class="card-header">

Featured Image

</div>

<div class="card-body text-center">

<img

src="<?= BASE_URL ?>uploads/posts/<?= $post['featured_image'] ?>"

class="img-fluid rounded">

</div>

</div>

<div class="card shadow">

<div class="card-header">

SEO

</div>

<div class="card-body">

<p>

<strong>SEO Title</strong>

</p>

<p>

<?= htmlspecialchars($post['seo_title']) ?>

</p>

<hr>

<p>

<strong>Description</strong>

</p>

<p>

<?= htmlspecialchars($post['seo_description']) ?>

</p>

<hr>

<p>

<strong>Keywords</strong>

</p>

<p>

<?= htmlspecialchars($post['seo_keywords']) ?>

</p>

</div>

</div>

</div>

</div>

<?php require_once __DIR__."/../includes/footer.php"; ?>