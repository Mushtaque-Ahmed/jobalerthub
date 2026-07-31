<?php

session_start();

if (
    !isset($_SESSION['admin_logged_in']) ||
    $_SESSION['admin_logged_in'] !== true
) {
    header("Location: index.php");
    exit;
}
$page_title = "home";
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
require_once __DIR__ . '/includes/sidebar.php';

?>
<main>
    <div class="container-fluid px-4">

        <h2 class="mt-4 mb-4">

            Dashboard

        </h2>

        <div class="row g-4">

            <div class="col-xl-3 col-md-6">

                <div class="card bg-primary text-white">

                    <div class="card-body">

                        <h6>Categories</h6>

                        <h2 id="totalCategories">0</h2>

                    </div>

                </div>

            </div>

            <div class="col-xl-3 col-md-6">

                <div class="card bg-success text-white">

                    <div class="card-body">

                        <h6>Total Posts</h6>

                        <h2 id="totalPosts">0</h2>

                    </div>

                </div>

            </div>

            <div class="col-xl-3 col-md-6">

                <div class="card bg-warning text-dark">

                    <div class="card-body">

                        <h6>Published</h6>

                        <h2 id="publishedPosts">0</h2>

                    </div>

                </div>

            </div>

            <div class="col-xl-3 col-md-6">

                <div class="card bg-danger text-white">

                    <div class="card-body">

                        <h6>Draft</h6>

                        <h2 id="draftPosts">0</h2>

                    </div>

                </div>

            </div>

        </div>
        <!-- pdf stastics   -->
        <div class="row g-3 my-1">

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6>Total PDF Products</h6>
                        <h2 id="totalPdf">0</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6>Published PDFs</h6>
                        <h2 id="publishedPdf">0</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6>Draft PDFs</h6>
                        <h2 id="draftPdf">0</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6>Total Downloads</h6>
                        <h2 id="downloadPdf">0</h2>
                    </div>
                </div>
            </div>

        </div>
        <div class="card shadow mt-4">

            <div class="card-header d-flex justify-content-between align-items-center">

                <h5 class="mb-0">
                    Recent Posts
                </h5>

                <a href="<?= BASE_URL ?>posts/index.php" class="btn btn-sm btn-primary">

                    View All

                </a>

            </div>

            <div class="card-body table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>ID</th>

                            <th>Title</th>

                            <th>Category</th>

                            <th>Type</th>

                            <th>Status</th>

                            <th>Date</th>

                            <th width="140">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody id="recentPostsTable">

                        <tr>

                            <td colspan="7" class="text-center">

                                Loading...

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>
    </div>

</main>
<script src="<?= BASE_URL ?>assets/js/dashboard.js"></script>
<?php
require_once __DIR__ . '/includes/footer.php'; ?>