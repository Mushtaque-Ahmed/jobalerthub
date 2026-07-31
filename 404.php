<?php
http_response_code(404);

require_once "includes/config.php";

$page_title = "404 - Page Not Found";

include "includes/header.php";
include "includes/navbar.php";
?>

<div class="container py-5 text-center">

    <h1 class="display-3 fw-bold text-danger">
        404
    </h1>

    <h3>Page Not Found</h3>

    <p class="text-muted">
        The page you are looking for doesn't exist.
    </p>

    <a href="<?= BASE_URL ?>" class="btn btn-primary">
        Go Home
    </a>

</div>

<?php include "includes/footer.php"; ?>