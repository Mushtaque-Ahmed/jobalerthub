<?php

session_start();

if (
    !isset($_SESSION['admin_logged_in']) ||
    $_SESSION['admin_logged_in'] !== true
) {
    header("Location: " . BASE_URL . "index.php");
    exit;
}

$page_title = "Edit Post";

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
require_once __DIR__ . '/../includes/sidebar.php';

$id = (int) ($_GET['id'] ?? 0);

if ($id <= 0) {

    echo "<div class='container mt-5'>
            <div class='alert alert-danger'>
                Invalid Post ID.
            </div>
          </div>";

    require_once "../includes/footer.php";
    exit;

}

?>

<div class="container-fluid px-4">

    <h3 class="mt-4 mb-4">

        Edit Post

    </h3>

    <div id="msg"></div>

    <form id="editPostForm" enctype="multipart/form-data">

        <input type="hidden" id="post_id" name="id" value="<?= $id ?>">

        <div class="row">

            <!-- LEFT -->

            <div class="col-lg-8">

                <div class="card shadow mb-4">

                    <div class="card-header">

                        Post Information

                    </div>

                    <div class="card-body">

                        <div class="mb-3">

                            <label class="form-label">

                                Category

                            </label>

                            <select class="form-select" name="category_id" id="category_id">

                                <?php

                                require "../includes/database.php";

                                $stmt = $pdo->query("
                                    SELECT id,name
                                    FROM categories
                                    WHERE status=1
                                    ORDER BY name
                                ");

                                while ($row = $stmt->fetch()) {

                                    ?>

                                <option value="<?= $row['id'] ?>">

                                    <?= htmlspecialchars($row['name']) ?>

                                </option>

                                <?php } ?>

                            </select>

                        </div>

                        <div class="mb-3">

                            <label>

                                Post Type

                            </label>

                            <select class="form-select" name="post_type" id="post_type">

                                <option value="job">Job</option>

                                <option value="result">Result</option>

                                <option value="admit-card">Admit Card</option>

                                <option value="answer-key">Answer Key</option>

                                <option value="article">Article</option>

                            </select>

                        </div>

                        <div class="mb-3">

                            <label>

                                Title

                            </label>

                            <input type="text" class="form-control" id="title" name="title">

                        </div>

                        <div class="mb-3">

                            <label>

                                Slug

                            </label>

                            <input type="text" class="form-control" id="slug" name="slug">

                        </div>

                        <div class="mb-3">

                            <label>

                                Short Description

                            </label>

                            <textarea class="form-control" rows="3" id="short_description"
                                name="short_description"></textarea>

                        </div>

                        <div class="mb-3">

                            <label>

                                Description

                            </label>

                            <textarea id="description" name="description"></textarea>

                        </div>

                    </div>

                </div>
                <div class="card shadow mb-4">

                    <div class="card-header">
                        Job Information
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Organization</label>
                                <input type="text" class="form-control" id="organization" name="organization">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Qualification</label>
                                <input type="text" class="form-control" id="qualification" name="qualification">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Total Posts</label>
                                <input type="text" class="form-control" id="total_posts" name="total_posts">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Age Limit</label>
                                <input type="text" class="form-control" id="age_limit" name="age_limit">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Salary</label>
                                <input type="text" class="form-control" id="salary" name="salary">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Application Fee</label>
                                <input type="text" class="form-control" id="application_fee" name="application_fee">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Apply Start</label>
                                <input type="date" class="form-control" id="apply_start" name="apply_start">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Apply Last</label>
                                <input type="date" class="form-control" id="apply_last" name="apply_last">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Exam Date</label>
                                <input type="date" class="form-control" id="exam_date" name="exam_date">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Result Date</label>
                                <input type="date" class="form-control" id="result_date" name="result_date">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Official Website</label>
                                <input type="url" class="form-control" id="official_website" name="official_website">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Apply Link</label>
                                <input type="url" class="form-control" id="apply_link" name="apply_link">
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- RIGHT -->

            <!-- RIGHT -->
            <div class="col-lg-4">

                <!-- Featured Image -->
                <div class="card shadow mb-4">

                    <div class="card-header fw-bold">
                        Featured Image
                    </div>

                    <div class="card-body text-center">

                        <img id="preview" src="<?= BASE_URL ?>assets/img/no-image.png"
                            class="img-fluid rounded border mb-3" style="max-height:220px;object-fit:cover;">

                        <input type="hidden" name="old_image" id="old_image">

                        <input type="file" class="form-control" id="featured_image" name="featured_image"
                            accept=".webp,image/webp">

                        <small class="text-danger d-block mt-2">
                            ✔ Only WEBP image
                            <br>
                            ✔ Maximum Size: 100 KB
                            <br>
                            Leave empty to keep the existing image.
                        </small>

                    </div>

                </div>

                <!-- SEO -->
                <div class="card shadow mb-4">

                    <div class="card-header fw-bold">
                        SEO Settings
                    </div>

                    <div class="card-body">

                        <div class="mb-3">

                            <label class="form-label">
                                SEO Title
                            </label>

                            <input type="text" class="form-control" id="seo_title" name="seo_title">

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                SEO Description
                            </label>

                            <textarea class="form-control" rows="4" id="seo_description"
                                name="seo_description"></textarea>

                        </div>

                        <div>

                            <label class="form-label">
                                SEO Keywords
                            </label>

                            <textarea class="form-control" rows="4" id="seo_keywords" name="seo_keywords"
                                placeholder="job, assam job, railway recruitment"></textarea>

                        </div>

                    </div>

                </div>
                <!-- ==============breacking ============ -->
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="is_breaking" name="is_breaking" value="1">

                    <label class="form-check-label" for="is_breaking">
                        Show in Breaking News
                    </label>
                </div>
                <!-- Publish -->
                <div class="card shadow">

                    <div class="card-header fw-bold">
                        Publish
                    </div>

                    <div class="card-body">

                        <div class="mb-3">

                            <label class="form-label">
                                Status
                            </label>

                            <select class="form-select" id="status" name="status">

                                <option value="draft">
                                    Draft
                                </option>

                                <option value="published">
                                    Published
                                </option>

                            </select>

                        </div>

                        <div class="d-grid">

                            <button type="submit" id="updateBtn" class="btn btn-primary">

                                <i class="bi bi-check-circle"></i>
                                Update Post

                            </button>

                        </div>

                        <a href="<?= BASE_URL ?>posts/index.php" class="btn btn-outline-secondary w-100 mt-2">

                            <i class="bi bi-arrow-left"></i>
                            Back to Posts

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

<script>
const POST_ID = <?= $id ?>;
</script>

<script src="<?= BASE_URL ?>assets/js/post-edit.js"></script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>