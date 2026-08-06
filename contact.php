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

                        <button type="submit" class="btn btn-primary px-4">

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
                <li>JobAdAssam only provides information about recruitment notifications.</li>
                <li>We do not conduct recruitment or accept job applications.</li>
                <li>Please verify all information through the official notification before applying.</li>
                <li>For recruitment-related queries, contact the respective recruiting organization.</li>
            </ul>

        </div>

    </div>

</div>

<?php include "../includes/footer.php"; ?>