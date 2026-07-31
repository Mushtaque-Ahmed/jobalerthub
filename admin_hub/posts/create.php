<?php

$page_title = "Create Post";


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

    <h3 class="mt-4">Create New Post</h3>

    <div id="msg"></div>

    <form id="postForm" enctype="multipart/form-data">

        <div class="row">

            <!-- LEFT -->

            <div class="col-lg-8">

                <div class="card shadow mb-4">

                    <div class="card-header">
                        Post Information
                    </div>

                    <div class="card-body">

                        <!-- Category -->

                        <div class="mb-3">

                            <label class="form-label">
                                Category <span class="text-danger">*</span>
                            </label>

                            <select class="form-select" name="category_id" id="category_id" required>

                                <option value="">
                                    Select Category
                                </option>

                                <?php

                                require '../includes/database.php';

                                $stmt = $pdo->query("SELECT id,name FROM categories WHERE status=1 ORDER BY name");

                                while($row=$stmt->fetch()){

                                    ?>

                                <option value="<?=$row['id']?>">

                                    <?=htmlspecialchars($row['name'])?>

                                </option>

                                <?php

                                }

                                ?>

                            </select>

                        </div>

                        <!-- Post Type -->

                        <div class="mb-3">

                            <label class="form-label">
                                Post Type
                            </label>

                            <select class="form-select" name="post_type" id="post_type">

                                <option value="job">Job</option>

                                <option value="result">Result</option>

                                <option value="admit_card">Admit Card</option>

                                <option value="answer_key">Answer Key</option>

                                <option value="article">Article</option>

                            </select>

                        </div>

                        <!-- Title -->

                        <div class="mb-3">

                            <label class="form-label">

                                Title

                            </label>

                            <input type="text" class="form-control" name="title" id="title">

                        </div>

                        <!-- Slug -->

                        <div class="mb-3">

                            <label class="form-label">

                                Slug

                            </label>

                            <input type="text" class="form-control" name="slug" id="slug">

                        </div>

                        <!-- Short Description -->

                        <div class="mb-3">

                            <label>

                                Short Description

                            </label>

                            <textarea class="form-control" rows="3" name="short_description"
                                id="short_description"></textarea>

                        </div>

                        <!-- Description -->

                        <div class="mb-3">

                            <label>

                                Description

                            </label>

                            <textarea class="form-control" id="description" name="description"></textarea>

                        </div>

                    </div>

                </div>

                <!-- JOB DETAILS -->

                <div class="card shadow mb-4">

                    <div class="card-header">

                        Job Information

                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label>

                                    Organization

                                </label>

                                <input class="form-control" name="organization">

                            </div>

                            <div class="col-md-6 mb-3">

                                <label>

                                    Qualification

                                </label>

                                <input class="form-control" name="qualification">

                            </div>

                            <div class="col-md-6 mb-3">

                                <label>

                                    Total Posts

                                </label>

                                <input class="form-control" name="total_posts">

                            </div>

                            <div class="col-md-6 mb-3">

                                <label>

                                    Age Limit

                                </label>

                                <input class="form-control" name="age_limit">

                            </div>

                            <div class="col-md-6 mb-3">

                                <label>

                                    Salary

                                </label>

                                <input class="form-control" name="salary">

                            </div>

                            <div class="col-md-6 mb-3">

                                <label>

                                    Application Fee

                                </label>

                                <input class="form-control" name="application_fee">

                            </div>

                            <div class="col-md-6 mb-3">

                                <label>

                                    Apply Start

                                </label>

                                <input type="date" class="form-control" name="apply_start">

                            </div>

                            <div class="col-md-6 mb-3">

                                <label>

                                    Apply Last

                                </label>

                                <input type="date" class="form-control" name="apply_last">

                            </div>

                            <div class="col-md-6 mb-3">

                                <label>

                                    Exam Date

                                </label>

                                <input type="date" class="form-control" name="exam_date">

                            </div>

                            <div class="col-md-6 mb-3">

                                <label>

                                    Result Date

                                </label>

                                <input type="date" class="form-control" name="result_date">

                            </div>

                            <div class="col-md-6 mb-3">

                                <label>

                                    Official Website

                                </label>

                                <input class="form-control" name="official_website">

                            </div>

                            <div class="col-md-6 mb-3">

                                <label>

                                    Apply Link

                                </label>

                                <input class="form-control" name="apply_link">

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- RIGHT -->

            <div class="col-lg-4">

                <div class="card shadow mb-4">

                    <div class="card-header">

                        Featured Image

                    </div>

                    <div class="card-body">

                        <input type="file" class="form-control" id="featured_image" name="featured_image"
                            accept=".webp,image/webp">

                        <small class="text-danger">

                            Only WEBP • Max 100 KB

                        </small>

                        <img id="preview" class="img-fluid rounded mt-3 d-none">

                    </div>

                </div>

                <div class="card shadow mb-4">

                    <div class="card-header">

                        SEO

                    </div>

                    <div class="card-body">

                        <input class="form-control mb-3" placeholder="SEO Title" name="seo_title">

                        <textarea class="form-control mb-3" placeholder="SEO Description"
                            name="seo_description"></textarea>

                        <textarea class="form-control" placeholder="SEO Keywords" name="seo_keywords"></textarea>

                    </div>

                </div>

                <div class="card shadow">

                    <div class="card-header">

                        Publish

                    </div>

                    <div class="card-body">

                        <select class="form-select mb-3" name="status">

                            <option value="draft">

                                Draft

                            </option>

                            <option value="published">

                                Published

                            </option>

                        </select>

                        <button class="btn btn-primary w-100" id="saveBtn">

                            Publish Post

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>



 <script src="<?=BASE_URL?>assets/js/post.js"></script>
<?php  require_once __DIR__ . '/../includes/footer.php';?>