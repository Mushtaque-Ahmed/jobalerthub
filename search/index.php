<?php

require_once "../includes/config.php";

$q = trim($_GET["q"] ?? "");

$page_title = "Search";

$url = BASE_URL . "api/search/search.php?q=" . urlencode($q);

$response = file_get_contents($url);

if ($response === false) {
    die("Unable to search.");
}

$response = json_decode($response, true);

$posts = $response["posts"] ?? [];
$pdfs = $response["pdfs"] ?? [];

include "../includes/header.php";
include "../includes/navbar.php";

?>

<div class="container py-5">

    <h2 class="mb-4">

        Search Results for

        <span class="text-primary">

            "<?= htmlspecialchars($q) ?>"

        </span>

    </h2>

    <?php if (empty($posts) && empty($pdfs)): ?>

        <div class="alert alert-warning">

            No results found.

        </div>

    <?php endif; ?>
    <?php if (!empty($posts)): ?>

        <h3 class="mb-3">

            Posts

        </h3>

        <div class="row">

            <?php

            $route = [

                "job" => "job",

                "result" => "result",

                "admit_card" => "admit-card",

                "answer_key" => "answer-key",

                "current_affairs" => "current-affair"

            ];

            foreach ($posts as $post):

                $link = $route[$post["post_type"]] ?? "job";

                ?>

                <div class="col-lg-4 mb-4">

                    <div class="card shadow-sm h-100">

                        <img src="<?= BASE_URL ?>admin_hub/uploads/posts/<?= htmlspecialchars($post["featured_image"]) ?>"
                            class="card-img-top" style="height:220px;object-fit:cover;">

                        <div class="card-body">

                            <h5>

                                <?= htmlspecialchars($post["title"]) ?>

                            </h5>

                            <p class="text-muted">

                                <?= ucwords(str_replace("_", " ", $post["post_type"])) ?>

                            </p>

                            <a href="<?= BASE_URL . $link ?>/<?= urlencode($post["slug"]) ?>" class="btn btn-primary">

                                Read Details

                            </a>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>
    <?php if (!empty($pdfs)): ?>

        <h3 class="mt-5 mb-3">

            PDF Products

        </h3>

        <div class="row">

            <?php foreach ($pdfs as $pdf): ?>

                <div class="col-lg-3 mb-4">

                    <div class="card shadow-sm h-100">

                        <img src="<?= BASE_URL ?>admin_hub/uploads/pdf/<?= htmlspecialchars($pdf["featured_image"]) ?>"
                            class="card-img-top" style="height:220px;object-fit:cover;">

                        <div class="card-body">

                            <h5>

                                <?= htmlspecialchars($pdf["title"]) ?>

                            </h5>

                            <p>

                                <?= (int) $pdf["pages"] ?> Pages

                            </p>

                            <a href="<?= BASE_URL ?>pdf/<?= urlencode($pdf["slug"]) ?>" class="btn btn-success w-100">

                                View PDF

                            </a>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>
</div>

<?php

include "../includes/footer.php";

?>