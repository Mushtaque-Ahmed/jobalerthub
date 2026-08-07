<?php

require_once "../includes/config.php";

$activePage = "about";

$page_title = "About Us | JobAdAssam";

$meta_description = "Learn more about JobAdAssam, a trusted platform providing the latest government jobs, private jobs, educational updates, results, admit cards, answer keys, scholarships, and study materials in Assam and across India.";

$meta_keywords = "About JobAdAssam, Assam Job Portal, Government Jobs Assam, Education Portal";

$canonical = BASE_URL . "about";

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
                    About Us
                </li>
            </ol>
        </nav>

        <div class="row align-items-center g-5">

            <div class="col-lg-6">

                <img src="<?= BASE_URL ?>assets/image/jobadassam-about.webp" class="img-fluid rounded-4 shadow"
                    alt="About JobAdAssam">

            </div>

            <div class="col-lg-6">

                <h1 class="fw-bold mb-4">
                    About JobAdAssam
                </h1>

                <p>
                    <strong>JobAdAssam.com</strong> is an educational and career information platform dedicated to
                    helping
                    students, job seekers, and professionals stay informed about the latest opportunities and important
                    updates from Assam and across India.
                </p>

                <p>
                    Our mission is to make reliable information easily accessible by publishing timely updates on
                    government
                    jobs, private jobs, examination results, admit cards, answer keys, scholarships, educational news,
                    and
                    competitive exam study materials.
                </p>

                <p>
                    We strive to present information in a simple, accurate, and user-friendly format so visitors can
                    quickly
                    find the details they need without unnecessary complexity.
                </p>

            </div>

        </div>

        <div class="row mt-5 g-4">

            <div class="col-md-4">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-body text-center">

                        <i class="bi bi-briefcase-fill text-primary fs-1"></i>

                        <h4 class="mt-3">
                            Job Updates
                        </h4>

                        <p class="text-muted mb-0">
                            Latest Government Jobs, Private Jobs, Recruitment Notifications, Walk-in Interviews, and
                            Career
                            Opportunities.
                        </p>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-body text-center">

                        <i class="bi bi-mortarboard-fill text-success fs-1"></i>

                        <h4 class="mt-3">
                            Education
                        </h4>

                        <p class="text-muted mb-0">
                            Results, Admit Cards, Answer Keys, Scholarships, Admissions, Exam Notifications, and
                            Educational
                            Updates.
                        </p>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-body text-center">

                        <i class="bi bi-file-earmark-pdf-fill text-danger fs-1"></i>

                        <h4 class="mt-3">
                            Study Materials
                        </h4>

                        <p class="text-muted mb-0">
                            Download free and premium PDF notes, previous year question papers, guides, and competitive
                            exam
                            resources.
                        </p>

                    </div>

                </div>

            </div>

        </div>

        <div class="card border-0 bg-light rounded-4 mt-5">

            <div class="card-body p-4">

                <h2 class="fw-bold mb-3">
                    Our Mission
                </h2>

                <p>
                    Our goal is to become one of the most trusted online resources for employment, education, and
                    career-related information. We continuously work to provide accurate, updated, and
                    easy-to-understand
                    content that helps users make informed decisions.
                </p>

            </div>

        </div>

        <div class="card border-0 bg-light rounded-4 mt-4">

            <div class="card-body p-4">

                <h2 class="fw-bold mb-3">
                    Why Choose JobAdAssam?
                </h2>

                <ul class="mb-0">

                    <li>Latest Government & Private Job Notifications.</li>

                    <li>Results, Admit Cards & Answer Keys.</li>

                    <li>Scholarship & Educational Updates.</li>

                    <li>Competitive Exam Study Materials & PDFs.</li>

                    <li>Simple, Fast & Mobile-Friendly Website.</li>

                    <li>Regularly Updated Information.</li>

                </ul>

            </div>

        </div>

        <div class="card border-0 bg-light rounded-4 mt-4">

            <div class="card-body p-4">

                <h2 class="fw-bold mb-3">
                    Disclaimer
                </h2>

                <p class="mb-0">
                    JobAdAssam is an independent informational platform. We are not affiliated with any government
                    organization, recruitment board, educational institution, or examination authority. While we make
                    every
                    effort to provide accurate and timely information, users are strongly advised to verify all details
                    through the respective official websites before applying for jobs, admissions, examinations,
                    scholarships, or other services.
                </p>

            </div>

        </div>

    </div>
</main>
<?php include "../includes/footer.php"; ?>