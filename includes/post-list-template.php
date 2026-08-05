<?php

$route = [

    "job" => "job",

    "result" => "result",

    "admit_card" => "admit-card",

    "answer_key" => "answer-key",

    "current_affairs" => "current-affair",

    "category" => "job"

];

$detailUrl = $route[$type] ?? "job";
?>
<div class="container py-4">

    <nav>

        <ol class="breadcrumb">

            <li class="breadcrumb-item">

                <a href="<?= BASE_URL ?>">

                    Home

                </a>

            </li>

            <li class="breadcrumb-item active">

                <?= $page_title ?>

            </li>

        </ol>

    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1>
            <?= $page_title ?>
        </h1>

    </div>
    <!-- search  -->
    <form method="GET" class="row g-3 mb-4">

        <div class="col-lg-7">

            <input type="text" name="search" class="form-control" placeholder="Search..."
                value="<?= htmlspecialchars($search) ?>">

        </div>

        <div class="col-lg-3">

            <select name="category" class="form-select">

                <option value="0">

                    All Categories

                </option>

                <?php foreach ($categories as $cat): ?>

                <option value="<?= $cat["id"] ?>" <?= $category == $cat["id"] ? 'selected' : '' ?>>

                    <?= $cat["name"] ?>

                </option>

                <?php endforeach; ?>

            </select>

        </div>

        <div class="col-lg-2">

            <button class="btn btn-primary w-100">

                Search

            </button>

        </div>

    </form>
    <div class="row">

        <?php foreach ($posts as $post): ?>

        <div class="col-lg-4 mb-4">

            <div class="card shadow-sm h-100">

                <img src="<?= BASE_URL ?>admin_hub/uploads/posts/<?= htmlspecialchars($post["featured_image"]) ?>"
                    class="card-img-top">

                <div class="card-body d-flex flex-column">

                    <h5>

                        <?= htmlspecialchars($post["title"]) ?>

                    </h5>

                    <p>

                        <strong>Organization:</strong>

                        <?= htmlspecialchars($post["organization"]) ?>

                    </p>

                    <p>

                        <strong>Qualification:</strong>

                        <?= htmlspecialchars($post["qualification"]) ?>

                    </p>

                    <p>

                        <strong>Vacancy:</strong>

                        <?= htmlspecialchars($post["total_posts"]) ?>

                    </p>

                    <p>

                        <strong>Last Date:</strong>

                        <?= !empty($post["apply_last"])
                                ? date("d M Y", strtotime($post["apply_last"]))
                                : "N/A" ?>

                    </p>

                    <div class="mt-auto">

                        <a href="<?= BASE_URL ?>job/<?= urlencode($post["slug"]) ?>" class="btn btn-primary w-100">

                            Read Details

                        </a>

                    </div>

                </div>

            </div>

        </div>

        <?php endforeach; ?>

    </div>
    <!-- paginations  -->
    <?php

    $current = $pagination["page"];

    $total = $pagination["total_pages"];

    if ($total > 1):

        ?>

    <nav>

        <ul class="pagination justify-content-center">

            <?php for ($i = 1; $i <= $total; $i++): ?>

            <li class="page-item <?= $current == $i ? 'active' : '' ?>">

                <a class="page-link" href="?page=<?= $i ?>

                                <?php if ($search != ""): ?>

                                 &search=<?= urlencode($search) ?>

                                   <?php endif; ?>

                                  <?php if ($category > 0): ?>

                                  &category=<?= $category ?>

                                   <?php endif; ?>">

                    <?= $i ?>

                </a>

            </li>

            <?php endfor; ?>

        </ul>

    </nav>

    <?php endif; ?>

</div>