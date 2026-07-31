<?php
$page_title = "Post";
session_start();

if (
    !isset($_SESSION['admin_logged_in']) ||
    $_SESSION['admin_logged_in'] !== true
) {
    header("Location: index.php");
    exit;
}
              require_once __DIR__ . '/../includes/config.php';
               require_once __DIR__ . '/../includes/header.php';
                require_once __DIR__ . '/../includes/navbar.php';
                require_once __DIR__ . '/../includes/sidebar.php';?>

<div class="container-fluid px-4">

    <h3 class="mt-4 mb-4">Manage Posts</h3>

    <div id="msg"></div>

    <div class="card shadow">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">All Posts</h5>

            <a href="create.php" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i>
                Add New
            </a>

        </div>

        <div class="card-body">

            <div class="row mb-3">

                <div class="col-md-4">

                    <input type="text" id="search" class="form-control" placeholder="Search title...">

                </div>

            </div>

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Image</th>

                            <th>Title</th>

                            <th>Category</th>

                            <th>Type</th>

                            <th>Status</th>

                            <th>Views</th>

                            <th>Created</th>

                            <th width="170">Action</th>

                        </tr>

                    </thead>

                    <tbody id="postTable">

                    </tbody>

                </table>

            </div>

            <nav>

                <ul class="pagination" id="pagination"></ul>

            </nav>

        </div>

    </div>

</div>
 <script src="<?=BASE_URL?>assets/js/post-list.js"></script>

<?php  require_once __DIR__ . '/../includes/footer.php';?>