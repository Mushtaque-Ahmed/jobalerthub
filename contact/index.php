<?php

require_once "../includes/config.php";

$activePage = "contact";

$page_title = "Contact Us | JobAdAssam";

$meta_description = "Contact JobAdAssam for job updates, report issues, advertisement inquiries, feedback, or general support.";

$meta_keywords = "Contact JobAdAssam, JobAdAssam Support, Assam Job Portal Contact";

$canonical = BASE_URL . "contact";

include "../includes/header.php";
include "../includes/navbar.php";

?>
<main>
    <div class="container py-5">

        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= BASE_URL ?>">Home</a>
                </li>
                <li class="breadcrumb-item active">
                    Contact Us
                </li>
            </ol>
        </nav>

        <div class="row g-4">

            <div class="col-lg-5">

                <div class="card shadow-sm border-0 rounded-4 h-100">

                    <div class="card-body">

                        <h2 class="fw-bold mb-3">
                            Contact JobAdAssam
                        </h2>

                        <p class="text-muted">
                            We'd love to hear from you. Whether you have a question, want to report an issue, or are
                            interested in advertising with us, feel free to contact us.
                        </p>

                        <hr>

                        <div class="mb-3">
                            <h6 class="fw-bold">
                                <i class="bi bi-envelope-fill text-primary"></i>
                                Email
                            </h6>

                            <p class="mb-0">
                                support@jobadassam.com
                            </p>
                        </div>

                        <div class="mb-3">
                            <h6 class="fw-bold">
                                <i class="bi bi-clock-fill text-primary"></i>
                                Support Hours
                            </h6>

                            <p class="mb-0">
                                Monday – Saturday<br>
                                9:00 AM – 6:00 PM (IST)
                            </p>
                        </div>

                        <div class="mb-3">
                            <h6 class="fw-bold">
                                <i class="bi bi-megaphone-fill text-primary"></i>
                                Advertisement & Business
                            </h6>

                            <p class="mb-0">
                                Contact us for banner advertisements, sponsored posts, and partnership opportunities.
                            </p>
                        </div>

                    </div>

                </div>

            </div>

            <div class="col-lg-7">

                <div class="card shadow-sm border-0 rounded-4">

                    <div class="card-body">
                        <div id="messageBox"></div>
                        <h3 class="fw-bold mb-4">
                            Send Us a Message
                        </h3>

                        <form id="contactForm">

                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Full Name
                                    </label>

                                    <input type="text" class="form-control" name="name" required>

                                </div>

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Email Address
                                    </label>

                                    <input type="email" class="form-control" name="email" required>

                                </div>

                            </div>

                            <div class="mb-3">

                                <label class="form-label">
                                    Subject
                                </label>

                                <input type="text" class="form-control" name="subject" required>

                            </div>

                            <div class="mb-4">

                                <label class="form-label">
                                    Message
                                </label>

                                <textarea class="form-control" name="message" rows="6" required></textarea>

                            </div>
                            <div class="row mb-4">

                                <div class="col-md-6">

                                    <label class="form-label fw-semibold">

                                        Solve this:

                                        <span id="captchaQuestion" class="text-primary"></span>

                                    </label>

                                    <input type="number" name="captcha" class="form-control" required>

                                </div>

                            </div>
                            <button type="submit" id="submitBtn" class="btn btn-primary">

                                <i class="bi bi-send-fill"></i>

                                Send Message

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

        <div class="card border-0 bg-light rounded-4 mt-5">

            <div class="card-body">

                <h4 class="fw-bold">
                    Before Contacting Us
                </h4>

                <ul class="mb-0">

                    <li>JobAdAssam publishes information related to government jobs, private jobs, educational updates,
                        results, admit cards, answer keys, scholarships, and business opportunities for informational
                        purposes only.</li>

                    <li>We do not conduct recruitment, admissions, examinations, or business transactions, and we do not
                        accept job applications or registration on behalf of any organization.</li>

                    <li>Please verify all information, including eligibility, important dates, fees, and application
                        procedures, through the official website or notification before taking any action.</li>

                    <li>For recruitment, admission, examination, scholarship, or business-related queries, please
                        contact
                        the respective organization or authority directly.</li>

                    <li>If you notice any incorrect or outdated information on our website, please contact us so we can
                        review and update it as quickly as possible.</li>

                </ul>

            </div>

        </div>

    </div>
</main>

<?php include "../includes/footer.php"; ?>
<script src="<?= BASE_URL ?>assets/js/contact.js"></script>