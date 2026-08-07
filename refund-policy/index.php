<?php

require_once "../includes/config.php";

$activePage = "refund";

$page_title = "Refund Policy | JobAdAssam";

$meta_description = "Read JobAdAssam refund and cancellation policy for PDF purchases and digital products.";

$canonical = BASE_URL . "refund-policy";

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

                    Refund Policy

                </li>

            </ol>

        </nav>


        <h1 class="fw-bold mb-4">
            Refund & Cancellation Policy
        </h1>


        <p>
            At <strong>JobAdAssam.com</strong>, we provide digital products such as PDF notes, study materials, and
            educational resources. Please read our refund policy carefully before making a purchase.
        </p>


        <h3 class="mt-4">
            Digital Products
        </h3>

        <p>
            Due to the digital nature of our products, once a PDF or digital material has been purchased and delivered,
            it
            cannot be returned.
        </p>


        <h3 class="mt-4">
            Refund Eligibility
        </h3>

        <p>
            Refunds may only be considered in situations such as:
        </p>

        <ul>

            <li>Payment was deducted but the product was not delivered.</li>

            <li>Technical issues prevented access to the purchased material.</li>

            <li>Duplicate payment was made accidentally.</li>

        </ul>


        <h3 class="mt-4">
            Non-Refundable Cases
        </h3>

        <ul>

            <li>Change of mind after downloading the product.</li>

            <li>Incorrect purchase made by the user.</li>

            <li>Failure to check product details before purchase.</li>

        </ul>


        <h3 class="mt-4">
            Refund Process
        </h3>

        <p>
            If you are eligible for a refund, please contact us with your payment details and order information. We will
            review the request and respond within a reasonable time.
        </p>


        <h3 class="mt-4">
            Payment Gateway
        </h3>

        <p>
            Payments are processed through secure third-party payment providers. JobAdAssam does not store sensitive
            payment
            information such as card details.
        </p>


        <h3 class="mt-4">
            Contact Us
        </h3>

        <p>
            For refund-related queries, please contact us through our Contact page.
        </p>


    </div>
</main>

<?php include "../includes/footer.php"; ?>