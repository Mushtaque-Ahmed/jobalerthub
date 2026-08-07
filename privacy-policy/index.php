<?php

require_once "../includes/config.php";

$activePage = "privacy";

$page_title = "Privacy Policy | JobAdAssam";

$meta_description = "Read JobAdAssam privacy policy to understand how we collect, use, and protect visitor information.";

$canonical = BASE_URL . "privacy-policy";

include "../includes/header.php";
include "../includes/navbar.php";

?>
<main>
    <div class="container py-5">

        <nav class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= BASE_URL ?>">Home</a>
                </li>
                <li class="breadcrumb-item active">
                    Privacy Policy
                </li>
            </ol>
        </nav>


        <h1 class="fw-bold mb-4">
            Privacy Policy
        </h1>


        <p>
            At <strong>JobAdAssam.com</strong>, we respect your privacy and are committed to protecting your personal
            information.
        </p>


        <h3 class="mt-4">
            Information We Collect
        </h3>

        <p>
            We may collect information such as your name, email address, contact details, IP address, browser
            information,
            and website usage data when you interact with our website.
        </p>


        <h3 class="mt-4">
            How We Use Information
        </h3>

        <ul>

            <li>To improve our website and user experience.</li>

            <li>To respond to user inquiries and contact requests.</li>

            <li>To provide job, education, and career-related updates.</li>

            <li>To prevent spam and fraudulent activities.</li>

        </ul>


        <h3 class="mt-4">
            Cookies
        </h3>

        <p>
            JobAdAssam may use cookies and similar technologies to improve website performance, analyze traffic, and
            provide
            relevant content.
        </p>


        <h3 class="mt-4">
            Third Party Services
        </h3>

        <p>
            We may use third-party services such as analytics, advertising networks, and payment providers. These
            services
            may collect information according to their own privacy policies.
        </p>


        <h3 class="mt-4">
            Data Security
        </h3>

        <p>
            We take reasonable steps to protect user information. However, no online platform can guarantee complete
            security.
        </p>


        <h3 class="mt-4">
            Contact Us
        </h3>

        <p>
            If you have questions regarding this Privacy Policy, please contact us through our Contact page.
        </p>


    </div>
</main>

<?php include "../includes/footer.php"; ?>