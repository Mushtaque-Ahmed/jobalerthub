<?php

require_once "../includes/config.php";

$slug = trim($_GET["slug"] ?? "");

if ($slug == "") {

    header("Location: " . BASE_URL . "pdf");

    exit;

}

$url = BASE_URL . "api/pdf/details.php?slug=" . urlencode($slug);

$response = file_get_contents($url);

if ($response === false) {

    die("Unable to load PDF.");

}

$response = json_decode($response, true);

if (!$response || empty($response["success"])) {

    die("PDF Not Found.");

}

$pdf = $response["data"];

$relatedPdf = $response["related_pdf"] ?? [];

$latestPdf = $response["latest_pdf"] ?? [];

$page_title = !empty($pdf["seo_title"])
    ? $pdf["seo_title"]
    : $pdf["title"];

$meta_description = !empty($pdf["seo_description"])
    ? $pdf["seo_description"]
    : $pdf["short_description"];

$meta_keywords = $pdf["seo_keywords"] ?? "";

include "../includes/header.php";
include "../includes/navbar.php";
?>

<div class="container py-4">

    <div class="row">

        <!-- LEFT CONTENT -->

        <div class="col-lg-8">

            <div class="card shadow-sm mb-4">

                <img src="<?= BASE_URL ?>admin_hub/uploads/pdf-images/<?= htmlspecialchars($pdf["featured_image"]) ?>"
                    class="card-img-top" style="max-height:450px;object-fit:contain;">

                <div class="card-body">

                    <h1 class="h3 mb-3">

                        <?= htmlspecialchars($pdf["title"]) ?>

                    </h1>

                    <div class="row mb-3">

                        <div class="col-md-6">

                            <p><strong>Author:</strong> <?= htmlspecialchars($pdf["author"]) ?></p>

                            <p><strong>Pages:</strong> <?= $pdf["pages"] ?></p>

                            <p><strong>Language:</strong> <?= htmlspecialchars($pdf["language"]) ?></p>

                        </div>

                        <div class="col-md-6">

                            <p><strong>File Size:</strong> <?= htmlspecialchars($pdf["file_size"]) ?></p>

                            <p><strong>Downloads:</strong> <?= (int)$pdf["downloads"] ?></p>

                            <p>

                                <strong>Price:</strong>

                                <?php if($pdf["is_free"]): ?>

                                <span class="badge bg-success">

                                    FREE

                                </span>

                                <?php else: ?>

                                ₹<?= number_format($pdf["price"],2) ?>

                                <?php endif; ?>

                            </p>

                        </div>

                    </div>

                    <hr>

                    <?= $pdf["description"] ?>

                    <hr>

                    <?php if($pdf["is_free"]): ?>

                    <a href="<?= htmlspecialchars($pdf["pdf_file"]) ?>" class="btn btn-success btn-lg" target="_blank">

                        Download PDF

                    </a>

                    <?php else: ?>

                    <a href="#" class="btn btn-primary btn-lg">

                        Buy Now

                    </a>

                    <?php endif; ?>

                </div>

            </div>

            <!-- Related PDF -->

            <div class="card shadow-sm">

                <div class="card-header">

                    <h4 class="mb-0">

                        Related PDFs

                    </h4>

                </div>

                <div class="list-group list-group-flush">

                    <?php foreach($relatedPdf as $item): ?>

                    <a href="<?= BASE_URL ?>pdf/<?= urlencode($item["slug"]) ?>"
                        class="list-group-item list-group-item-action">

                        <?= htmlspecialchars($item["title"]) ?>

                    </a>

                    <?php endforeach; ?>

                </div>

            </div>

        </div>

        <!-- SIDEBAR -->

        <div class="col-lg-4">

            <div class="card shadow-sm mb-4">

                <div class="card-header">

                    <h5 class="mb-0">

                        Latest PDFs

                    </h5>

                </div>

                <div class="list-group list-group-flush">

                    <?php foreach($latestPdf as $item): ?>

                    <a href="<?= BASE_URL ?>pdf/<?= urlencode($item["slug"]) ?>"
                        class="list-group-item list-group-item-action">

                        <?= htmlspecialchars($item["title"]) ?>

                    </a>

                    <?php endforeach; ?>

                </div>

            </div>

            <div class="card shadow-sm">

                <div class="card-body text-center">

                    Advertisement

                </div>

            </div>

        </div>

    </div>

</div>

<?php

include "../includes/footer.php";

?>