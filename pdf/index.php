<?php

require_once "../includes/config.php";

$pageTitle = "PDF Notes";

$page = max(1, (int)($_GET['page'] ?? 1));

$search = trim($_GET['search'] ?? '');

$url = BASE_URL . "api/pdf/listing.php?page={$page}";

if ($search != "") {
    $url .= "&search=" . urlencode($search);
}

$response = file_get_contents($url);

if ($response === false) {
    die("Unable to load PDF.");
}

$response = json_decode($response, true);

if (!$response || empty($response["success"])) {
    die("Unable to load PDF.");
}

$pdfs = $response["pdfs"] ?? [];
$pagination = $response["pagination"] ?? [];

$page_title = $pageTitle;

include "../includes/header.php";
include "../includes/navbar.php";

?>

<div class="container py-4">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= BASE_URL ?>">Home</a>
            </li>
            <li class="breadcrumb-item active">
                PDF Notes
            </li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="fw-bold">
            PDF Notes
        </h1>

    </div>

    <form method="GET" class="mb-4">

        <div class="input-group">

            <input type="text" class="form-control" name="search" placeholder="Search PDF..."
                value="<?= htmlspecialchars($search) ?>">

            <button class="btn btn-primary">

                Search

            </button>

        </div>

    </form>

    <div class="row">

        <?php foreach($pdfs as $pdf): ?>

        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">

            <div class="card shadow-sm h-100">

                <img src="<?= BASE_URL ?>admin_hub/uploads/pdf/<?= htmlspecialchars($pdf["featured_image"]) ?>"
                    class="card-img-top" style="height:250px;object-fit:cover;">

                <div class="card-body d-flex flex-column">

                    <h6 class="fw-bold">

                        <?= htmlspecialchars($pdf["title"]) ?>

                    </h6>

                    <small class="text-muted">

                        <?= $pdf["pages"] ?> Pages

                    </small>

                    <small class="text-muted">

                        <?= htmlspecialchars($pdf["language"]) ?>

                    </small>

                    <small class="text-muted">

                        <?= htmlspecialchars($pdf["author"]) ?>

                    </small>

                    <div class="mt-2">

                        <?php if($pdf["is_free"]): ?>

                        <span class="badge bg-success">

                            FREE

                        </span>

                        <?php else: ?>

                        <span class="badge bg-danger">

                            ₹<?= $pdf["price"] ?>

                        </span>

                        <?php endif; ?>

                    </div>

                    <div class="mt-auto pt-3">

                        <a href="<?= BASE_URL ?>pdf/<?= urlencode($pdf["slug"]) ?>" class="btn btn-primary w-100">

                            View Details

                        </a>

                    </div>

                </div>

            </div>

        </div>

        <?php endforeach; ?>

    </div>

    <?php

    $current = $pagination["page"] ?? 1;
    $total = $pagination["total_pages"] ?? 1;

    if($total>1):

    ?>

    <nav>

        <ul class="pagination justify-content-center">

            <?php for($i=1;$i<=$total;$i++): ?>

            <li class="page-item <?= $current==$i?'active':'' ?>">

                <a class="page-link"
                    href="?page=<?= $i ?><?php if($search!=""): ?>&search=<?= urlencode($search) ?><?php endif; ?>">

                    <?= $i ?>

                </a>

            </li>

            <?php endfor; ?>

        </ul>

    </nav>

    <?php endif; ?>

</div>

<?php

include "../includes/footer.php";

?>