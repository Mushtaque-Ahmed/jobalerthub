<?php

session_start();

$page_title = "Website Settings";

require_once __DIR__ . "/../includes/config.php";
require_once __DIR__ . "/../includes/header.php";
require_once __DIR__ . "/../includes/navbar.php";
require_once __DIR__ . "/../includes/sidebar.php";
require_once __DIR__ . "/../includes/database.php";


if (
    !isset($_SESSION['admin_logged_in']) ||
    $_SESSION['admin_logged_in'] !== true
) {

    header("Location: ".BASE_URL."index.php");
    exit;

}


$stmt = $pdo->query("
SELECT *
FROM settings
WHERE id=1
");

$settings = $stmt->fetch(PDO::FETCH_ASSOC);


?>


<div class="container-fluid px-4">

<h3 class="mt-4 mb-4">
    Website Settings
</h3>


<div id="msg"></div>


<form id="settingsForm" enctype="multipart/form-data">


<div class="row">


<!-- LEFT -->

<div class="col-lg-8">


<div class="card shadow mb-4">

<div class="card-header fw-bold">
General Settings
</div>


<div class="card-body">


<div class="mb-3">

<label>
Site Name
</label>

<input 
type="text"
class="form-control"
name="site_name"
value="<?= htmlspecialchars($settings['site_name'] ?? '') ?>"
>

</div>



<div class="mb-3">

<label>
Email
</label>

<input 
type="email"
class="form-control"
name="site_email"
value="<?= htmlspecialchars($settings['site_email'] ?? '') ?>"
>

</div>



<div class="mb-3">

<label>
Phone
</label>

<input 
type="text"
class="form-control"
name="site_phone"
value="<?= htmlspecialchars($settings['site_phone'] ?? '') ?>"
>

</div>



<div class="mb-3">

<label>
Address
</label>

<textarea
class="form-control"
name="site_address"
rows="3"
><?= htmlspecialchars($settings['site_address'] ?? '') ?></textarea>

</div>


<div class="mb-3">

<label>
Footer Text
</label>

<textarea
class="form-control"
name="footer_text"
rows="2"
><?= htmlspecialchars($settings['footer_text'] ?? '') ?></textarea>

</div>



</div>

</div>





<div class="card shadow mb-4">


<div class="card-header fw-bold">
Social Links
</div>


<div class="card-body">


<input 
class="form-control mb-3"
name="facebook"
placeholder="Facebook URL"
value="<?= htmlspecialchars($settings['facebook'] ?? '') ?>"
>



<input 
class="form-control mb-3"
name="twitter"
placeholder="Twitter URL"
value="<?= htmlspecialchars($settings['twitter'] ?? '') ?>"
>



<input 
class="form-control mb-3"
name="instagram"
placeholder="Instagram URL"
value="<?= htmlspecialchars($settings['instagram'] ?? '') ?>"
>



<input 
class="form-control mb-3"
name="youtube"
placeholder="Youtube URL"
value="<?= htmlspecialchars($settings['youtube'] ?? '') ?>"
>



<input 
class="form-control"
name="linkedin"
placeholder="Linkedin URL"
value="<?= htmlspecialchars($settings['linkedin'] ?? '') ?>"
>



</div>

</div>



</div>





<!-- RIGHT -->

<div class="col-lg-4">


<div class="card shadow mb-4">


<div class="card-header fw-bold">
Logo & Favicon
</div>


<div class="card-body text-center">


<label>
Site Logo
</label>


<?php if(!empty($settings['site_logo'])): ?>

<img 
src="<?= BASE_URL ?>uploads/settings/<?= $settings['site_logo'] ?>"
class="img-fluid border rounded mb-3"
style="max-height:100px"
>


<?php endif; ?>


<input 
type="file"
class="form-control mb-4"
name="site_logo"
accept=".webp"
>



<label>
Favicon
</label>


<?php if(!empty($settings['site_favicon'])): ?>

<img 
src="<?= BASE_URL ?>uploads/settings/<?= $settings['site_favicon'] ?>"
class="border rounded mb-3"
style="width:50px"
>


<?php endif; ?>


<input 
type="file"
class="form-control"
name="site_favicon"
accept=".webp"
>


</div>

</div>





<div class="card shadow mb-4">


<div class="card-header fw-bold">
SEO Settings
</div>


<div class="card-body">


<input
class="form-control mb-3"
name="meta_title"
placeholder="Meta Title"
value="<?= htmlspecialchars($settings['meta_title'] ?? '') ?>"
>



<textarea
class="form-control mb-3"
name="meta_description"
placeholder="Meta Description"
><?= htmlspecialchars($settings['meta_description'] ?? '') ?></textarea>



<textarea
class="form-control"
name="meta_keywords"
placeholder="Meta Keywords"
><?= htmlspecialchars($settings['meta_keywords'] ?? '') ?></textarea>



</div>


</div>





<div class="card shadow">


<div class="card-header fw-bold">
Analytics
</div>


<div class="card-body">


<textarea
class="form-control mb-3"
name="google_verification"
placeholder="Google Search Console Verification"
><?= htmlspecialchars($settings['google_verification'] ?? '') ?></textarea>



<textarea
class="form-control"
name="google_analytics"
placeholder="Google Analytics Code"
><?= htmlspecialchars($settings['google_analytics'] ?? '') ?></textarea>



</div>


</div>





<button
class="btn btn-primary w-100 mt-4"
id="saveBtn"
>

Save Settings

</button>


</div>


</div>


</form>


</div>



<script src="<?= BASE_URL ?>assets/js/settings.js"></script>


<?php require_once __DIR__ . "/../includes/footer.php"; ?>