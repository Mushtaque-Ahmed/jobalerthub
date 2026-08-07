<?php
require_once "../includes/config.php";

$slug = trim($_GET["slug"] ?? "");

if ($slug === "") {

    header("Location: " . BASE_URL);

    exit;

}

$url = BASE_URL . "api/post/details.php?slug=" . urlencode($slug);

$response = file_get_contents($url);

if ($response === false) {

    http_response_code(500);

    die("Unable to load job.");

}

$response = json_decode($response, true);

if (
    !$response ||
    empty($response["success"])
) {

    http_response_code(404);

    die("Job Not Found.");

}

$job = $response["data"];

$relatedJobs = $response["related_jobs"] ?? [];

$latestJobs = $response["latest_jobs"] ?? [];
$latestResults = $response["latest_results"] ?? [];

$latestAdmitCards = $response["latest_admit_cards"] ?? [];

$latestPdf = $response["latest_pdf"] ?? [];
$categories = $response["categories"] ?? [];

/*
|--------------------------------------------------------------------------
| SEO
|--------------------------------------------------------------------------
*/

$page_title = !empty($job["seo_title"])
    ? $job["seo_title"]
    : $job["title"];

$meta_description = !empty($job["seo_description"])
    ? $job["seo_description"]
    : $job["short_description"];

$meta_keywords = $job["seo_keywords"] ?? "";

$canonical = BASE_URL . "result/" . $job["slug"];

/* Open Graph */

$og_title = $page_title;

$og_description = $meta_description;

$og_url = $canonical;

$og_image = !empty($job["featured_image"])
    ? BASE_URL . "admin_hub/uploads/posts/" . $job["featured_image"]
    : BASE_URL . "assets/image/default-og.webp";

$og_type = "article";

include "../includes/header.php";

include "../includes/navbar.php";

?>
<main>
    <div class="container py-4">

        <div class="row">

            <!-- =======================================
                                                 LEFT SIDEBAR
                               ======================================== -->

            <aside class="col-lg-3">

                <!-- Advertisement -->
                <div class="card shadow-sm mb-4">

                    <div class="card-header fw-bold">
                        Advertisement
                    </div>

                    <div class="card-body text-center">

                        <div
                            style="height:600px;background:#f8f9fa;border:1px dashed #ccc;display:flex;align-items:center;justify-content:center;">

                            300 x 600 Ad

                        </div>

                    </div>

                </div>

                <!-- Latest Jobs -->

                <div class="card shadow-sm mb-4">

                    <div class="card-header bg-primary text-white">

                        Latest Jobs

                    </div>

                    <div class="list-group list-group-flush">

                        <?php if (!empty($latestJobs)): ?>

                        <?php foreach ($latestJobs as $item): ?>

                        <a href="<?= BASE_URL ?>job/<?= urlencode($item['slug']) ?>"
                            class="list-group-item list-group-item-action">

                            <?= htmlspecialchars($item['title']) ?>

                        </a>

                        <?php endforeach; ?>

                        <?php else: ?>

                        <div class="list-group-item">

                            No Jobs Found

                        </div>

                        <?php endif; ?>

                    </div>

                </div>
                <!-- Categories -->

                <div class="card shadow-sm mb-4">

                    <div class="card-header bg-success text-white">

                        Categories

                    </div>

                    <div class="list-group list-group-flush">

                        <?php foreach ($categories as $category): ?>

                        <a href="<?= BASE_URL . $category['slug'] ?>" class="list-group-item list-group-item-action">

                            <?= htmlspecialchars($category['name']) ?>

                        </a>

                        <?php endforeach; ?>

                    </div>

                </div>
                <!-- result -->
                <div class="card shadow-sm mb-4">

                    <div class="card-header bg-danger text-white">

                        Latest Results

                    </div>

                    <div class="list-group list-group-flush">

                        <?php if (!empty($latestResults)): ?>

                        <?php foreach ($latestResults as $item): ?>

                        <a href="<?= BASE_URL ?>result/<?= urlencode($item['slug']) ?>"
                            class="list-group-item list-group-item-action">

                            <?= htmlspecialchars($item['title']) ?>

                        </a>

                        <?php endforeach; ?>

                        <?php else: ?>

                        <div class="list-group-item">

                            No Results Found

                        </div>

                        <?php endif; ?>

                    </div>

                </div>

            </aside>



            <!-- =======================================
        MAIN CONTENT
        ======================================== -->

            <div class="col-lg-6">

                <!-- Featured Image -->

                <div class="card shadow-sm mb-4">

                    <img src="<?= BASE_URL ?>admin_hub/uploads/posts/<?= htmlspecialchars($job["featured_image"]) ?>"
                        class="card-img-top" alt="<?= htmlspecialchars($job["title"]) ?>">

                    <div class="card-body">

                        <span class="badge bg-primary">

                            <?= htmlspecialchars($job["category_name"]) ?>

                        </span>

                        <h1 class="mt-3">

                            <?= htmlspecialchars($job["title"]) ?>

                        </h1>

                        <p class="text-muted">

                            <?= htmlspecialchars($job["organization"]) ?>

                        </p>

                    </div>

                </div>

                <!-- Job Details -->

                <div class="card shadow-sm mb-4">

                    <div class="card-header bg-primary text-white">

                        Job Details

                    </div>

                    <div class="card-body">

                        <table class="table table-bordered">

                            <tr>
                                <th>Organization</th>
                                <td><?= htmlspecialchars($job["organization"]) ?></td>
                            </tr>

                            <tr>
                                <th>Qualification</th>
                                <td><?= htmlspecialchars($job["qualification"]) ?></td>
                            </tr>

                            <tr>
                                <th>Total Posts</th>
                                <td><?= htmlspecialchars($job["total_posts"]) ?></td>
                            </tr>

                            <tr>
                                <th>Age Limit</th>
                                <td><?= htmlspecialchars($job["age_limit"]) ?></td>
                            </tr>

                            <tr>
                                <th>Salary</th>
                                <td><?= htmlspecialchars($job["salary"]) ?></td>
                            </tr>

                            <tr>
                                <th>Application Fee</th>
                                <td><?= htmlspecialchars($job["application_fee"]) ?></td>
                            </tr>

                            <tr>
                                <th>Apply Start</th>
                                <td><?= $job["apply_start"] ?></td>
                            </tr>

                            <tr>
                                <th>Last Date</th>
                                <td><?= $job["apply_last"] ?></td>
                            </tr>

                        </table>

                    </div>

                </div>

                <!-- Advertisement -->

                <div class="text-center my-4">

                    <div
                        style="height:250px;background:#f8f9fa;border:1px dashed #ccc;display:flex;align-items:center;justify-content:center;">

                        728 x 90 Advertisement

                    </div>

                </div>

                <!-- Description -->

                <div class="card shadow-sm mb-4">

                    <div class="card-header">

                        Full Notification

                    </div>

                    <div class="card-body">

                        <?= $job["description"] ?>

                    </div>

                </div>

                <!-- Related Jobs -->

                <!-- =======================================
              RELATED JOBS
======================================= -->

                <div class="card shadow-sm mt-4">

                    <div class="card-header bg-primary text-white">

                        Related Jobs

                    </div>

                    <div class="card-body">

                        <?php if (!empty($relatedJobs)): ?>

                        <div class="row">

                            <?php foreach ($relatedJobs as $item): ?>

                            <div class="col-md-6 mb-4">

                                <div class="card h-100 border-0 shadow-sm">

                                    <img src="<?= BASE_URL ?>admin_hub/uploads/posts/<?= htmlspecialchars($item["featured_image"]) ?>"
                                        class="card-img-top" style="height:180px;object-fit:cover;"
                                        alt="<?= htmlspecialchars($item["title"]) ?>">

                                    <div class="card-body d-flex flex-column">

                                        <span class="badge bg-primary mb-2">

                                            <?= htmlspecialchars($item["category_name"]) ?>

                                        </span>

                                        <h5 class="card-title">

                                            <?= htmlspecialchars($item["title"]) ?>

                                        </h5>

                                        <p class="text-muted small mb-2">

                                            <?= htmlspecialchars($item["organization"]) ?>

                                        </p>

                                        <p class="small mb-3">

                                            <strong>Last Date:</strong>

                                            <?= !empty($item["apply_last"])
                                                    ? date("d M Y", strtotime($item["apply_last"]))
                                                    : "N/A"; ?>

                                        </p>

                                        <div class="mt-auto">

                                            <a href="<?= BASE_URL ?>job/<?= urlencode($item["slug"]) ?>"
                                                class="btn btn-outline-primary w-100">

                                                Read Details

                                            </a>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <?php endforeach; ?>

                        </div>

                        <?php else: ?>

                        <div class="alert alert-light border">

                            No related jobs available.

                        </div>

                        <?php endif; ?>

                    </div>

                </div>

            </div>



            <!-- =======================================
        RIGHT SIDEBAR
        ======================================== -->

            <aside class="col-lg-3">

                <!-- Important Links -->

                <div class="card shadow-sm mb-4">

                    <div class="card-header bg-success text-white">

                        Important Links

                    </div>

                    <div class="card-body d-grid gap-2">

                        <a href="<?= htmlspecialchars($job["apply_link"]) ?>" target="_blank" class="btn btn-success">

                            Apply Online

                        </a>

                        <a href="<?= htmlspecialchars($job["official_website"]) ?>" target="_blank"
                            class="btn btn-primary">

                            Official Website

                        </a>

                    </div>

                </div>

                <!-- Advertisement -->

                <div class="card shadow-sm mb-4">

                    <div class="card-body text-center">

                        <div
                            style="height:600px;background:#f8f9fa;border:1px dashed #ccc;display:flex;align-items:center;justify-content:center;">

                            300 x 600 Ad

                        </div>

                    </div>

                </div>

                <!-- Premium PDFs -->

                <div class="card shadow-sm mb-4">

                    <div class="card-header bg-info text-white">

                        Premium Study Materials

                    </div>

                    <div class="list-group list-group-flush">

                        <?php if (!empty($latestPdf)): ?>

                        <?php foreach ($latestPdf as $pdf): ?>

                        <a href="<?= BASE_URL ?>pdf/<?= urlencode($pdf['slug']) ?>"
                            class="list-group-item list-group-item-action">

                            <?= htmlspecialchars($pdf['title']) ?>

                        </a>

                        <?php endforeach; ?>

                        <?php else: ?>

                        <div class="list-group-item">

                            No PDFs Available

                        </div>

                        <?php endif; ?>

                    </div>

                </div>
                <!-- latest admit card  -->
                <div class="card shadow-sm mb-4">

                    <div class="card-header bg-warning">

                        Latest Admit Cards

                    </div>

                    <div class="list-group list-group-flush">

                        <?php if (!empty($latestAdmitCards)): ?>

                        <?php foreach ($latestAdmitCards as $item): ?>

                        <a href="<?= BASE_URL ?>admit-card/<?= urlencode($item['slug']) ?>"
                            class="list-group-item list-group-item-action">

                            <?= htmlspecialchars($item['title']) ?>

                        </a>

                        <?php endforeach; ?>

                        <?php else: ?>

                        <div class="list-group-item">

                            No Admit Cards

                        </div>

                        <?php endif; ?>

                    </div>

                </div>

            </aside>

        </div>

    </div>
</main>
<?php

include "../includes/footer.php";

?>