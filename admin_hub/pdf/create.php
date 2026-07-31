<?php

session_start();
$page_title = "Add PDF Product";

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



?>

<div class="container-fluid px-4">

    <h3 class="mt-4 mb-4">
        Add PDF Product
    </h3>

    <div id="msg"></div>

    <form id="pdfForm" enctype="multipart/form-data">

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
                                name="category_id"
                                id="category_id">

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

                                while($row=$stmt->fetch()){

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
                                name="short_description"
                                id="short_description"></textarea>

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
                                    name="author">

                            </div>

                            <div class="col-md-6 mb-3">

                                <label>Language</label>

                                <input
                                    class="form-control"
                                    name="language">

                            </div>

                            <div class="col-md-4 mb-3">

                                <label>Pages</label>

                                <input
                                    type="number"
                                    class="form-control"
                                    name="pages">

                            </div>

                            <div class="col-md-4 mb-3">

                                <label>Price (₹)</label>

                                <input
                                    type="number"
                                    class="form-control"
                                    value="0"
                                    name="price">

                            </div>

                            <div class="col-md-4 mb-3">

                                <label>Free PDF</label>

                                <select
                                    class="form-select"
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
                            class="img-fluid border rounded mb-3">

                        <input
                            type="file"
                            class="form-control"
                            id="featured_image"
                            name="featured_image"
                            accept=".webp">

                        <small class="text-danger">
                            WEBP only (Max 100 KB)
                        </small>

                    </div>

                </div>

                <div class="card shadow mb-4">

                    <div class="card-header fw-bold">
                        Upload PDF
                    </div>

                    <div class="card-body">

                        <input
                            type="file"
                            class="form-control"
                            id="pdf_file"
                            name="pdf_file"
                            accept=".pdf">

                        <small class="text-danger">
                            PDF only (Max 50 MB)
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
                            name="seo_title"
                            placeholder="SEO Title">

                        <textarea
                            class="form-control mb-3"
                            name="seo_description"
                            placeholder="SEO Description"></textarea>

                        <textarea
                            class="form-control"
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
                            name="status">

                            <option value="draft">
                                Draft
                            </option>

                            <option value="published">
                                Published
                            </option>

                        </select>

                        <button
                            class="btn btn-primary w-100"
                            id="saveBtn">

                            Save PDF

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>


 <script src="<?= BASE_URL ?>assets/js/pdf.js"></script>
<?php require_once __DIR__ . "/../includes/footer.php"; ?>
