<?php
require_once "includes/config.php";
require_once "includes/database.php";
$activePage = BASE_URL;
/*
|--------------------------------------------------------------------------
| Load Home API
|--------------------------------------------------------------------------
*/

$json = file_get_contents(BASE_URL . "api/home/home.php");

$response = json_decode($json, true);

if (!$response || !$response["success"]) {
    die("Unable to load homepage.");
}

$data = $response["data"];

/*
|--------------------------------------------------------------------------
| Settings
|--------------------------------------------------------------------------
*/

$settings = $data["settings"] ?? [];

/*
|--------------------------------------------------------------------------
| SEO
|--------------------------------------------------------------------------
*/

$page_title = $settings["meta_title"] ?? "JobAdAssam";

$meta_description = $settings["meta_description"] ?? "";

$meta_keywords = $settings["meta_keyword"] ?? "";

$canonical = BASE_URL;

$og_title = $page_title;

$og_description = $meta_description;

$og_url = $canonical;

$og_image = !empty($settings["site_logo"])
    ? BASE_URL . "admin_hub/uploads/settings/" . $settings["site_logo"]
    : BASE_URL . "assets/image/default-og.webp";

$og_type = "website";

/*
|--------------------------------------------------------------------------
| Homepage Data
|--------------------------------------------------------------------------
*/

$stats = $data["statistics"] ?? [];

$categories = $data["categories"] ?? [];

$latestJobs = $data["latest_jobs"] ?? [];

$pdfProducts = $data["pdf_products"] ?? [];

$pdfCategories = $data['pdf_categories'] ?? [];

$latestResults = $data["latest_results"] ?? [];

$latestAdmitCards = $data["latest_admit_cards"] ?? [];

$currentAffairs = $data["current_affairs"] ?? [];
$breakingNews = $data["breakingNews"] ?? [];
/*
|--------------------------------------------------------------------------
| Header
|--------------------------------------------------------------------------
*/

include "includes/header.php";
include "includes/navbar.php";
?>

<!-- Homepage Sections -->
<!-- =======================
HERO SECTION
======================= -->
<main>
    <section class="bg-primary text-white py-5">

        <div class="container">

            <div class="row align-items-center">

                <div class="col-lg-7">

                    <h1 class="display-4 fw-bold">

                        Latest Jobs,
                        Results & Exam Updates

                    </h1>

                    <p class="lead mt-3">

                        Stay updated with the latest Assam Government Jobs, Sarkari Results, Admit Cards, Answer Keys,
                        Current Affairs and premium study materials. Get daily job alerts and never miss an important
                        recruitment notification.

                    </p>


                    <div class="row mt-5">

                        <div class="col-4">

                            <h2><?= number_format($stats['total_posts']) ?>+</h2>
                            <p>Latest Jobs</p>

                        </div>

                        <div class="col-4">

                            <h2><?= number_format($stats['total_categories']) ?></h2>
                            <p>Categories</p>

                        </div>

                        <div class="col-4">

                            <h2><?= number_format($stats['total_pdfs']) ?>+</h2>
                            <p>Premium PDFs</p>

                        </div>

                    </div>

                </div>

                <div class="col-lg-5 text-center">

                    <img src="<?= BASE_URL ?>assets/image/jobadassam-hero-banner.webp" class="img-fluid" width="600"
                        height="350" alt="Government Jobs">

                </div>

            </div>

        </div>

    </section>

    <!-- =======================
BREAKING NEWS
======================= -->

    <section class="bg-danger text-white py-2">

        <div class="container">

            <strong class="me-2">Breaking:</strong>

            <?php if (!empty($breakingNews)): ?>

            <?php foreach ($breakingNews as $index => $news): ?>

            <?php
                    switch ($news['post_type']) {

                        case 'job':
                            $url = BASE_URL . 'job/' . $news['slug'];
                            break;

                        case 'result':
                            $url = BASE_URL . 'result/' . $news['slug'];
                            break;

                        case 'admit_card':
                            $url = BASE_URL . 'admit-card/' . $news['slug'];
                            break;

                        case 'current-affairs':
                            $url = BASE_URL . 'current-affairs/' . $news['slug'];
                            break;

                        default:
                            $url = '#';
                    }
                ?>

            <a href="<?= $url ?>" class="text-white text-decoration-none fw-semibold">

                <?= htmlspecialchars($news['title']) ?>

            </a>

            <?php if ($index != count($breakingNews)-1): ?>
            <span class="mx-2">•</span>
            <?php endif; ?>

            <?php endforeach; ?>

            <?php else: ?>

            No Breaking News

            <?php endif; ?>

        </div>

    </section>

    <!-- =======================
QUICK CATEGORIES
======================= -->

    <section class="py-5">

        <div class="container">

            <h2 class="fw-bold mb-4">

                Popular Categories

            </h2>

            <div class="row g-4">

                <?php if (!empty($categories)): ?>

                <?php foreach ($categories as $category): ?>

                <div class="col-6 col-md-3">

                    <a href="<?= BASE_URL ?>category/<?= htmlspecialchars($category['slug']) ?>"
                        class="text-decoration-none">

                        <div class="card border-0 shadow-sm h-100 text-center">

                            <div class="card-body">

                                <div class="display-5 text-primary mb-3">

                                    <i class=" <?= htmlspecialchars($category['icon']) ?>"></i>

                                </div>

                                <h3 class="fw-bold text-dark fs-5">

                                    <?= htmlspecialchars($category['name']) ?>

                                </h3>

                                <small class="text-muted">

                                    <?= (int) $category['total_posts'] ?> Posts

                                </small>

                            </div>

                        </div>

                    </a>

                </div>

                <?php endforeach; ?>

                <?php else: ?>

                <div class="col-12">

                    <div class="alert alert-warning">

                        No categories found.

                    </div>

                </div>

                <?php endif; ?>

            </div>

        </div>

    </section>

    <!-- More sections will be added in the next step -->
    <!-- ==========================
LATEST JOBS
=========================== -->

    <section class="py-5 bg-light">

        <div class="container">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h2 class="fw-bold">Latest Government Jobs</h2>

                    <p class="text-muted mb-0">
                        Recently announced government recruitment.
                    </p>

                </div>

                <a href="<?= BASE_URL ?>job/" class="btn btn-outline-primary">

                    View All

                </a>

            </div>

            <div class="row g-4">

                <?php if (!empty($latestJobs)): ?>

                <?php foreach ($latestJobs as $job): ?>

                <div class="col-lg-4 col-md-6">

                    <div class="card border-0 shadow-sm rounded-4 h-100">

                        <img width="400" height="220"
                            src="<?= BASE_URL ?>admin_hub/uploads/posts/<?= htmlspecialchars($job['featured_image']) ?>"
                            class="card-img-top" alt="<?= htmlspecialchars($job['title']) ?>"
                            style="height:220px; object-fit:cover;">

                        <div class="card-body d-flex flex-column">

                            <div class="d-flex justify-content-between align-items-center mb-2">

                                <span class="badge bg-primary">

                                    <?= htmlspecialchars($job['category_name']) ?>

                                </span>

                                <small class="text-muted">

                                    <?= date("d M Y", strtotime($job['created_at'])) ?>

                                </small>

                            </div>

                            <h3 class="fw-bold fs-5">

                                <a href="<?= BASE_URL ?>job/<?= htmlspecialchars($job['slug']) ?>"
                                    class="text-dark text-decoration-none">

                                    <?= htmlspecialchars($job['title']) ?>

                                </a>

                            </h3>

                            <p class="text-muted small mt-2">

                                <?= mb_strimwidth(strip_tags($job['short_description']), 0, 120, "...") ?>

                            </p>

                            <div class="mt-auto">

                                <a href="<?= BASE_URL ?>job/<?= htmlspecialchars($job['slug']) ?>"
                                    class="btn btn-primary w-100">

                                    Read Details

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

                <?php endforeach; ?>

                <?php else: ?>

                <div class="col-12">

                    <div class="alert alert-warning">

                        No Government Jobs Available.

                    </div>

                </div>

                <?php endif; ?>

            </div>

        </div>

    </section>
    <!-- ======================================
     Latest result 
     ========================================== -->
    <section class="py-5">

        <div class="container">

            <div class="d-flex justify-content-between mb-4">

                <h2 class="fw-bold">

                    Latest Results

                </h2>

                <a href="<?= BASE_URL ?>result" class="btn btn-outline-success">

                    View All

                </a>

            </div>

            <div class="row">

                <?php if (!empty($latestResults)): ?>

                <?php foreach ($latestResults as $result): ?>

                <div class="col-md-6 mb-3">

                    <div class="list-group shadow-sm">

                        <a href="<?= BASE_URL ?>result/<?= htmlspecialchars($result['slug']) ?>"
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">

                            <?= htmlspecialchars($result['title']) ?>

                            <span class="badge bg-success">

                                New

                            </span>

                        </a>

                    </div>

                </div>

                <?php endforeach; ?>

                <?php else: ?>

                <div class="col-12">

                    <div class="alert alert-warning">

                        No Results Available.

                    </div>

                </div>

                <?php endif; ?>

            </div>

        </div>

    </section>
    <!-- ===========================================
 Admit cards 
 =============================================== -->
    <section class="py-5 bg-light">

        <div class="container">

            <h2 class="fw-bold mb-4">

                Latest Admit Cards

            </h2>

            <div class="row g-4">

                <?php if (!empty($latestAdmitCards)): ?>

                <?php foreach ($latestAdmitCards as $card): ?>

                <div class="col-lg-3 col-md-6">

                    <div class="card border-0 shadow-sm h-100">

                        <img width="390" height="260" loading="lazy"
                            src="<?= BASE_URL ?>admin_hub/uploads/posts/<?= htmlspecialchars($card['featured_image']) ?>"
                            class="card-img-top" alt="<?= htmlspecialchars($card['title']) ?>"
                            style="height:180px;object-fit:cover;">

                        <div class="card-body d-flex flex-column">

                            <h3 class="fw-bold fs-5">

                                <?= htmlspecialchars($card['title']) ?>

                            </h3>

                            <small class="text-muted mb-3">

                                <?= date("d M Y", strtotime($card['created_at'])) ?>

                            </small>

                            <div class="mt-auto">

                                <a href="<?= BASE_URL ?>admit-card/<?= htmlspecialchars($card['slug']) ?>"
                                    class="btn btn-primary w-100">

                                    Download Admit Card

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

                <?php endforeach; ?>

                <?php else: ?>

                <div class="col-12">

                    <div class="alert alert-warning">

                        No Admit Cards Available.

                    </div>

                </div>

                <?php endif; ?>

            </div>

        </div>

    </section>
    <!-- ==========================
CURRENT AFFAIRS
========================== -->

    <section class="py-5 bg-light">

        <div class="container">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h2 class="fw-bold">
                        Current Affairs
                    </h2>

                    <p class="text-muted">
                        Latest Current Affairs PDFs for Competitive Exams
                    </p>

                </div>

                <a href="<?= BASE_URL ?>pdf-category/current-affairs" class="btn btn-outline-primary">

                    View All

                </a>

            </div>

            <div class="row g-4">

                <?php if (!empty($currentAffairs)): ?>

                <?php foreach ($currentAffairs as $news): ?>

                <div class="col-lg-4">

                    <div class="card border-0 shadow-sm h-100">

                        <img width="390" height="260" loading="lazy"
                            src="<?= BASE_URL ?>admin_hub/uploads/pdf-images/<?= htmlspecialchars($news['featured_image']) ?>"
                            class="card-img-top" alt="<?= htmlspecialchars($news['title']) ?>"
                            style="height:220px;object-fit:cover;">

                        <div class="card-body d-flex flex-column">

                            <span class="badge bg-primary mb-2">
                                Current Affairs PDF
                            </span>

                            <h3 class="fw-bold fs-5">

                                <a href="<?= BASE_URL ?>pdf/<?= htmlspecialchars($news['slug']) ?>"
                                    class="text-decoration-none text-dark">

                                    <?= htmlspecialchars($news['title']) ?>

                                </a>

                            </h3>

                            <small class="text-muted mb-3">

                                <?= date("d M Y", strtotime($news['created_at'])) ?>

                            </small>

                            <p class="text-muted">

                                <?= mb_strimwidth(strip_tags($news['short_description']), 0, 120, "...") ?>

                            </p>

                            <div class="mt-auto">

                                <a href="<?= BASE_URL ?>pdf/<?= htmlspecialchars($news['slug']) ?>"
                                    class="btn btn-primary w-100">

                                    View PDF

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

                <?php endforeach; ?>

                <?php else: ?>

                <div class="col-12">

                    <div class="alert alert-warning">
                        No Current Affairs PDFs Available.
                    </div>

                </div>

                <?php endif; ?>

            </div>

        </div>

    </section>
    <!--========================================
     job calander 
     ========================================= -->
    <!-- <section class="py-5 bg-light">

    <div class="container">

        <div class="d-flex justify-content-between">

            <h2 class="fw-bold">

                Upcoming Exams

            </h2>

            <a href="#" class="btn btn-outline-danger">

                Full Calendar

            </a>

        </div>

        <div class="table-responsive mt-4">

            <table class="table table-bordered align-middle">

                <thead class="table-primary">

                    <tr>

                        <th>Exam</th>

                        <th>Date</th>

                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>SSC CGL</td>

                        <td>25 Aug 2026</td>

                        <td>

                            <span class="badge bg-success">

                                Upcoming

                            </span>

                        </td>

                    </tr>

                    <tr>

                        <td>Railway NTPC</td>

                        <td>05 Sept 2026</td>

                        <td>

                            <span class="badge bg-warning">

                                Soon

                            </span>

                        </td>

                    </tr>

                    <tr>

                        <td>UPSC Mains</td>

                        <td>18 Sept 2026</td>

                        <td>

                            <span class="badge bg-primary">

                                Scheduled

                            </span>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</section> -->
    <!-- premium pdf stor  -->
    <section class="py-5 bg-light">

        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4 gy-3">

                <div class="col-lg-6">

                    <h2 class="fw-bold mb-1">
                        Premium Study Materials
                    </h2>

                    <p class="text-muted mb-0">
                        High Quality PDFs with Solutions
                    </p>

                </div>

                <div class="col-lg-3">

                    <div class="row g-2 justify-content-lg-end">

                        <div class="col-sm-7 col-md-8">

                            <select id="pdfCategoryFilter" class="form-select">

                                <option value="all">
                                    📚 All Categories
                                </option>

                                <?php foreach ($pdfCategories as $cat): ?>

                                <option value="<?= $cat['id'] ?>">
                                    <?= htmlspecialchars($cat['name']) ?>
                                </option>

                                <?php endforeach; ?>

                            </select>

                        </div>

                        <div class=" col-lg-3">

                            <a href="<?= BASE_URL ?>pdf/" class="btn btn-primary w-100">

                                <i class="bi bi-shop me-1"></i>
                                View Store

                            </a>

                        </div>

                    </div>

                </div>

            </div>

            <div class="row mt-4 g-4" id="pdfProductsContainer">

                <?php if (!empty($pdfProducts)): ?>

                <?php foreach ($pdfProducts as $pdf): ?>

                <div class="col-lg-3 col-md-6 pdf-item" data-category="<?= (int)$pdf['pdf_category_id'] ?>">

                    <div class="card border-0 shadow-sm h-100">

                        <img width="390" height="260" loading="lazy"
                            src="<?= BASE_URL ?>admin_hub/uploads/pdf-images/<?= htmlspecialchars($pdf['featured_image']) ?>"
                            class="card-img-top" alt="<?= htmlspecialchars($pdf['title']) ?>"
                            style="height:260px;object-fit:cover;">

                        <div class="card-body d-flex flex-column">

                            <?php if (!empty($pdf['category_name'])): ?>

                            <span class="badge bg-primary mb-2">
                                <?= htmlspecialchars($pdf['category_name']) ?>
                            </span>

                            <?php endif; ?>

                            <h3 class="fw-bold fs-5">

                                <a href="<?= BASE_URL ?>pdf/<?= htmlspecialchars($pdf['slug']) ?>"
                                    class="text-decoration-none text-dark">

                                    <?= htmlspecialchars($pdf['title']) ?>

                                </a>

                            </h3>

                            <div class="small text-muted mb-3">

                                <?= (int)$pdf['pages'] ?> Pages

                                <?php if (!empty($pdf['file_size'])): ?>

                                • <?= htmlspecialchars($pdf['file_size']) ?>

                                <?php endif; ?>

                            </div>

                            <h4 class="text-primary mb-3">

                                <?php if ((float)$pdf['price'] <= 0): ?>

                                Free

                                <?php else: ?>

                                ₹<?= number_format($pdf['price'], 2) ?>

                                <?php endif; ?>

                            </h4>

                            <div class="mt-auto">

                                <a href="<?= BASE_URL ?>pdf/<?= htmlspecialchars($pdf['slug']) ?>"
                                    class="btn btn-primary w-100">

                                    View Details

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

                <?php endforeach; ?>

                <?php else: ?>

                <div class="col-12">

                    <div class="alert alert-warning">

                        No PDF products available.

                    </div>

                </div>

                <?php endif; ?>

            </div>
        </div>

    </section>
    <!-- ===================================
     News later
     ======================================= -->
    <section class="bg-primary text-white py-5">

        <div class="container text-center">

            <h2>Get Daily Job Alerts</h2>

            <p>Subscribe to receive latest Government Jobs & Results.</p>

            <div class="row justify-content-center">

                <div class="col-lg-6">

                    <form id="newsletterForm">

                        <div class="input-group">

                            <input type="email" id="newsletterEmail" class="form-control form-control-lg"
                                placeholder="Enter your email" required>

                            <button class="btn btn-warning" type="submit">

                                Subscribe

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </section>

</main>

<script src="<?= BASE_URL ?>assets/js/newsletter.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
<?php

include "includes/footer.php";

?>