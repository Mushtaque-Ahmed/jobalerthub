<?php
$page_title = "Add Category";

session_start();

if (
    !isset($_SESSION['admin_logged_in']) ||
    $_SESSION['admin_logged_in'] !== true
) {
    header("Location: index.php");
    exit;
}
?>
<?php
              require_once __DIR__ . '/../includes/config.php';
               require_once __DIR__ . '/../includes/header.php';
                require_once __DIR__ . '/../includes/navbar.php';
                require_once __DIR__ . '/../includes/sidebar.php';?>
<div class="container-fluid px-4">

    <h3 class="mt-4">Add Category</h3>

    <div id="msg"></div>

    <div class="card shadow mt-3">
        <div class="card-body">

            <form id="categoryForm">

                <div class="mb-3">
                    <label class="form-label">Category Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>

                </div>

                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text" class="form-control" id="slug" name="slug" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Bootstrap Icon</label>
                    <input type="text" class="form-control" id="icon" name="icon" placeholder="bi bi-briefcase">
                </div>

                <div class="mb-3">
                    <label>Status</label>

                    <select class="form-select" name="status">

                        <option value="1">Active</option>
                        <option value="0">Inactive</option>

                    </select>
                </div>

                <button class="btn btn-primary" id="saveBtn">

                    Save Category

                </button>

            </form>

        </div>
    </div>

</div>
<div class="container-fluid px-4">

    <h3 class="mt-4">Categories</h3>

    <div class="card mt-3 shadow">

        <div class="card-header d-flex justify-content-between">

            <input type="text" class="form-control w-25" id="search" placeholder="Search Category">

            <a href="create.php" class="btn btn-primary">
                Add Post
            </a>

        </div>

        <div class="card-body">
            <div id="msg"></div>
            <div class="table-responsive">

                <table class="table table-bordered align-middle">

                    <thead>

                        <tr>

                            <th>ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Icon</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th width="160">Action</th>

                        </tr>

                    </thead>

                    <tbody id="categoryTable"></tbody>

                </table>

            </div>

            <nav>

                <ul class="pagination justify-content-end" id="pagination"></ul>

            </nav>

        </div>

    </div>

</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editModal" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Edit Category
                </h5>

                <button class="btn-close" data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <div id="editMsg"></div>

                <form id="editForm">

                    <input type="hidden" id="edit_id" name="id">

                    <div class="mb-3">

                        <label>Name</label>

                        <input type="text" class="form-control" id="edit_name" name="name">

                    </div>

                    <div class="mb-3">

                        <label>Slug</label>

                        <input type="text" class="form-control" id="edit_slug" name="slug">

                    </div>

                    <div class="mb-3">

                        <label>Icon</label>

                        <input type="text" class="form-control" id="edit_icon" name="icon">

                    </div>

                    <div class="mb-3">

                        <label>Status</label>

                        <select class="form-select" id="edit_status" name="status">

                            <option value="1">Active</option>
                            <option value="0">Inactive</option>

                        </select>

                    </div>

                </form>

            </div>

            <div class="modal-footer">

                <button class="btn btn-secondary" data-bs-dismiss="modal">

                    Close

                </button>

                <button class="btn btn-primary" id="updateBtn">

                    Update Category

                </button>

            </div>

        </div>

    </div>

</div>

<script src="<?= BASE_URL ?>assets/js/category.js"></script>
<?php  require_once __DIR__ . '/../includes/footer.php';?>