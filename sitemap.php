<?php

header("Content-Type: application/xml; charset=utf-8");

require_once "admin_hub/includes/database.php";

$base = "https://jobadassam.com/";

echo '<?xml version="1.0" encoding="UTF-8"?>';

?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">


    <!-- =====================
     MAIN LISTING PAGES
===================== -->


    <url>

        <loc><?= $base ?></loc>

        <changefreq>daily</changefreq>

        <priority>1.0</priority>

    </url>


    <url>

        <loc><?= $base ?>job</loc>

        <changefreq>daily</changefreq>

        <priority>0.9</priority>

    </url>


    <url>

        <loc><?= $base ?>category</loc>

        <changefreq>weekly</changefreq>

        <priority>0.8</priority>

    </url>


    <url>

        <loc><?= $base ?>result</loc>

        <changefreq>daily</changefreq>

        <priority>0.8</priority>

    </url>


    <url>

        <loc><?= $base ?>admit-card</loc>

        <changefreq>daily</changefreq>

        <priority>0.8</priority>

    </url>


    <url>

        <loc><?= $base ?>answer-key</loc>

        <changefreq>weekly</changefreq>

        <priority>0.7</priority>

    </url>


    <url>

        <loc><?= $base ?>current-affair</loc>

        <changefreq>daily</changefreq>

        <priority>0.7</priority>

    </url>


    <url>

        <loc><?= $base ?>pdf</loc>

        <changefreq>weekly</changefreq>

        <priority>0.8</priority>

    </url>




    <!-- =====================
     STATIC PAGES
===================== -->


    <url>

        <loc><?= $base ?>about</loc>

        <priority>0.5</priority>

    </url>


    <url>

        <loc><?= $base ?>contact</loc>

        <priority>0.5</priority>

    </url>


    <url>

        <loc><?= $base ?>privacy-policy</loc>

        <priority>0.3</priority>

    </url>


    <url>

        <loc><?= $base ?>terms-condition</loc>

        <priority>0.3</priority>

    </url>


    <url>

        <loc><?= $base ?>disclaimer</loc>

        <priority>0.3</priority>

    </url>


    <url>

        <loc><?= $base ?>refund-policy</loc>

        <priority>0.3</priority>

    </url>





    <!-- =====================
     DYNAMIC POSTS
===================== -->


    <?php

$stmt = $pdo->query("

SELECT 

slug,
post_type,
updated_at,
created_at

FROM posts

WHERE status='published'

ORDER BY created_at DESC

");


while($post = $stmt->fetch(PDO::FETCH_ASSOC)):


$url = "";


switch($post['post_type']){


case "job":

$url = "job/";

break;


case "result":

$url = "result/";

break;


case "admit-card":

$url = "admit-card/";

break;


case "answer-key":

$url = "answer-key/";

break;


case "current-affair":

$url = "current-affair/";

break;


default:

continue 2;


}

?>


    <url>

        <loc>
            <?= $base . $url . htmlspecialchars($post['slug']) ?>
        </loc>


        <lastmod>
            <?= date("Y-m-d", strtotime($post['updated_at'] ?? $post['created_at'])) ?>
        </lastmod>


        <changefreq>weekly</changefreq>


        <priority>0.8</priority>


    </url>


    <?php endwhile; ?>






    <!-- =====================
     DYNAMIC PDF PRODUCTS
===================== -->


    <?php

$stmt = $pdo->query("

SELECT

slug,
created_at

FROM pdf_products

WHERE status=1

ORDER BY created_at DESC

");


while($pdf = $stmt->fetch(PDO::FETCH_ASSOC)):

?>


    <url>

        <loc>
            <?= $base ?>pdf/<?= htmlspecialchars($pdf['slug']) ?>
        </loc>


        <lastmod>
            <?= date("Y-m-d", strtotime($pdf['created_at'])) ?>
        </lastmod>


        <changefreq>monthly</changefreq>


        <priority>0.7</priority>


    </url>


    <?php endwhile; ?>


</urlset>