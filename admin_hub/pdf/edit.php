<?php

session_start();

$page_title = "Edit PDF Product";

require_once __DIR__ . "/../includes/config.php";

if (
    !isset($_SESSION['admin_logged_in']) ||
    $_SESSION['admin_logged_in'] !== true
) {
    header("Location: " . BASE_URL . "index.php");
    exit;
}

require_once __DIR__ . "/../includes/header.php";
require_once __DIR__ . "/../includes/navbar.php";
require_once __DIR__ . "/../includes/sidebar.php";
require_once __DIR__ . "/../includes/database.php";

$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {

    echo "
    <div class='container mt-5'>
        <div class='alert alert-danger'>
            Invalid PDF ID.
        </div>
    </div>";

    require_once __DIR__ . "/../includes/footer.php";

    exit;

}

?>

<div class="container-fluid px-4">

    <h3 class="mt-4 mb-4">
        Edit PDF Product
    </h3>

    <div id="msg"></div>

    <form id="pdfForm" enctype="multipart/form-data">

        <input
            type="hidden"
            id="pdf_id"
            name="id"
            value="<?= $id ?>">

        <div class="row">

            <!-- LEFT -->
            <div class="col-lg-8">

                <div class="card shadow mb-4">

                    <div class="card-header fw-bold">
                        PDF Information
                    </div>

                    <div class="card-body">

                        <div class="mb-3">

                            <label>Category</label>

                            <select
                                class="form-select"
                                id="category_id"
                                name="category_id">

                                <option value="">
                                    Select Category
                                </option>

                                <?php

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

                            <label>Title</label>

                            <input
                                type="text"
                                class="form-control"
                                id="title"
                                name="title">

                        </div>

                        <div class="mb-3">

                            <label>Slug</label>

                            <input
                                type="text"
                                class="form-control"
                                id="slug"
                                name="slug">

                        </div>

                        <div class="mb-3">

                            <label>Short Description</label>

                            <textarea
                                class="form-control"
                                rows="3"
                                id="short_description"
                                name="short_description"></textarea>

                        </div>

                        <div class="mb-3">

                            <label>Description</label>

                            <textarea
                                id="description"
                                name="description"></textarea>

                        </div>

                    </div>

                </div>

                <div class="card shadow mb-4">

                    <div class="card-header fw-bold">
                        PDF Details
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label>Author</label>

                                <input
                                    class="form-control"
                                    id="author"
                                    name="author">

                            </div>

                            <div class="col-md-6 mb-3">

                                <label>Language</label>

                                <input
                                    class="form-control"
                                    id="language"
                                    name="language">

                            </div>

                            <div class="col-md-4 mb-3">

                                <label>Pages</label>

                                <input
                                    type="number"
                                    class="form-control"
                                    id="pages"
                                    name="pages">

                            </div>

                            <div class="col-md-4 mb-3">

                                <label>Price (₹)</label>

                                <input
                                    type="number"
                                    class="form-control"
                                    id="price"
                                    name="price">

                            </div>

                            <div class="col-md-4 mb-3">

                                <label>Free PDF</label>

                                <select
                                    class="form-select"
                                    id="is_free"
                                    name="is_free">

                                    <option value="1">
                                        Yes
                                    </option>

                                    <option value="0">
                                        No
                                    </option>

                                </select>

                            </div>

                            <div class="col-12">

                                <label>
                                    External Download Link
                                </label>

                                <input
                                    type="url"
                                    class="form-control"
                                    id="external_download_link"
                                    name="external_download_link">

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- RIGHT -->
            <div class="col-lg-4">

                <div class="card shadow mb-4">

                    <div class="card-header fw-bold">
                        Thumbnail
                    </div>

                    <div class="card-body text-center">

                        <img
                            id="preview"
                            class="img-fluid rounded border mb-3">

                        <input
                            type="file"
                            class="form-control"
                            id="featured_image"
                            name="featured_image"
                            accept=".webp">

                        <small class="text-danger">

                            Leave empty to keep existing thumbnail.

                        </small>

                    </div>

                </div>

                <div class="card shadow mb-4">

                    <div class="card-header fw-bold">
                        PDF File
                    </div>

                    <div class="card-body">

                        <div
                            id="currentPdf"
                            class="mb-2 small text-success"></div>

                        <input
                            type="file"
                            class="form-control"
                            id="pdf_file"
                            name="pdf_file"
                            accept=".pdf">

                        <small class="text-danger">

                            Leave empty to keep existing PDF.

                        </small>

                    </div>

                </div>

                <div class="card shadow mb-4">

                    <div class="card-header fw-bold">
                        SEO
                    </div>

                    <div class="card-body">

                        <input
                            class="form-control mb-3"
                            id="seo_title"
                            name="seo_title"
                            placeholder="SEO Title">

                        <textarea
                            class="form-control mb-3"
                            id="seo_description"
                            name="seo_description"
                            placeholder="SEO Description"></textarea>

                        <textarea
                            class="form-control"
                            id="seo_keywords"
                            name="seo_keywords"
                            placeholder="SEO Keywords"></textarea>

                    </div>

                </div>

                <div class="card shadow">

                    <div class="card-header fw-bold">
                        Publish
                    </div>

                    <div class="card-body">

                        <select
                            class="form-select mb-3"
                            id="status"
                            name="status">

                            <option value="0">
                                Draft
                            </option>

                            <option value="1">
                                Published
                            </option>

                        </select>

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                            id="updateBtn">

                            Update PDF

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

<script>

const PDF_ID = <?= $id ?>;

</script>

<script src="<?= BASE_URL ?>assets/js/pdf-edit.js"></script>

<?php require_once __DIR__ . "/../includes/footer.php"; ?>