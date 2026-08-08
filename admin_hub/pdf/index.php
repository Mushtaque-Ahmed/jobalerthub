<?php

session_start();

if (
    !isset($_SESSION['admin_logged_in']) ||
    $_SESSION['admin_logged_in'] !== true
) {
    header("Location: ../index.php");
    exit;
}

$page_title = "PDF Products";

require_once __DIR__ . "/../includes/config.php";
require_once __DIR__ . "/../includes/header.php";
require_once __DIR__ . "/../includes/navbar.php";
require_once __DIR__ . "/../includes/sidebar.php";
require_once __DIR__ . "/../includes/database.php";

?>

<div class="container-fluid px-4">

    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">

        <h3 class="mb-0">
            PDF Products
        </h3>

        <a href="<?= BASE_URL ?>pdf/create.php" class="btn btn-primary">

            <i class="bi bi-plus-circle"></i>

            Add PDF

        </a>

    </div>

    <div id="msg"></div>

    <div class="card shadow">

        <div class="card-body">

            <div class="row mb-3">

                <div class="col-md-4">

                    <input type="text" id="search" class="form-control" placeholder="Search PDF...">

                </div>

                <div class="col-md-3">

                    <select id="categoryFilter" class="form-select">

                        <option value="">
                            All Categories
                        </option>

                        <?php

                        $stmt = $pdo->query("
                            SELECT id,name
                            FROM pdf_categories
                            WHERE status=1
                            ORDER BY name
                        ");

                        while($cat=$stmt->fetch()){

                        ?>

                        <option value="<?= $cat['id'] ?>">

                            <?= htmlspecialchars($cat['name']) ?>

                        </option>

                        <?php } ?>

                    </select>

                </div>

                <div class="col-md-3">

                    <select id="statusFilter" class="form-select">

                        <option value="">
                            All Status
                        </option>

                        <option value="1">
                            Published
                        </option>

                        <option value="0">
                            Draft
                        </option>

                    </select>

                </div>

            </div>

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-dark">

                        <tr>

                            <th width="80">
                                Image
                            </th>

                            <th>
                                Title
                            </th>

                            <th>
                                Category
                            </th>

                            <th>
                                Pages
                            </th>

                            <th>
                                Price
                            </th>

                            <th>
                                Downloads
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Created
                            </th>

                            <th width="180">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody id="pdfTable"></tbody>

                </table>

            </div>

            <div id="pagination" class="mt-3 d-flex justify-content-end">

            </div>

        </div>

    </div>

</div>


<script src="<?= BASE_URL ?>assets/js/pdf-list.js"></script>

<?php require_once __DIR__ . "/../includes/footer.php"; ?>