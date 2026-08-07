<?php
$page_title = "Add pdf Category";

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
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
        <i class="bi bi-plus-circle"></i>
        Add PDF Category
    </button>
    <div class="card shadow-sm mt-4">

        <div class="card-header">
            <h5 class="mb-0">PDF Categories</h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead>

                        <tr>
                            <th width="70">#</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th width="180">Action</th>
                        </tr>

                    </thead>

                    <tbody id="categoryTable"></tbody>

                </table>

            </div>

        </div>

    </div>
</div>




</div>

<!-- Add PDF Category Modal -->

<div class="modal fade" id="addCategoryModal" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">


            <div class="modal-header">

                <h5 class="modal-title">
                    Add PDF Category
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

            </div>



            <div class="modal-body">


                <div id="msg"></div>


                <form id="categoryForm">


                    <div class="mb-3">

                        <label class="form-label">
                            Category Name
                        </label>

                        <input type="text" class="form-control" id="name" name="name" required>

                    </div>




                    <div class="mb-3">

                        <label class="form-label">
                            Slug
                        </label>

                        <input type="text" class="form-control" id="slug" name="slug" required>

                    </div>




                    <div class="mb-3">

                        <label class="form-label">
                            Bootstrap Icon Class
                        </label>


                        <input type="text" class="form-control" name="icon" id="icon" placeholder="bi bi-book">

                    </div>




                    <div class="mb-3">

                        <label class="form-label">
                            Status
                        </label>


                        <select class="form-select" name="status" id="status">


                            <option value="1">
                                Active
                            </option>


                            <option value="0">
                                Inactive
                            </option>


                        </select>


                    </div>



                    <button type="submit" class="btn btn-primary" id="saveBtn">

                        Save Category

                    </button>


                </form>


            </div>


        </div>

    </div>

</div>

<!-- edit modal  -->
<div class="modal fade" id="editCategoryModal" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form id="editCategoryForm">

                <div class="modal-header">

                    <h5 class="modal-title">Edit PDF Category</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div id="editMsg"></div>

                    <input type="hidden" id="edit_id" name="id">

                    <div class="mb-3">

                        <label class="form-label">
                            Category Name
                        </label>

                        <input type="text" class="form-control" id="edit_name" name="name" required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Slug
                        </label>

                        <input type="text" class="form-control" id="edit_slug" name="slug" readonly>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Status
                        </label>

                        <select class="form-select" id="edit_status" name="status">

                            <option value="1">Active</option>
                            <option value="0">Inactive</option>

                        </select>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>

                    <button type="submit" id="updateBtn" class="btn btn-primary">
                        Update Category
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
<script src="<?= BASE_URL ?>assets/js/pdf-category.js"></script>
<?php  require_once __DIR__ . '/../includes/footer.php';?>