<header>
    <!-- =======================
TOP BAR
======================= -->
    <div class="bg-primary text-white py-2 small">
        <div class="container d-flex justify-content-between align-items-center">

            <div>
                <i class="bi bi-lightning-charge-fill text-warning"></i>
                Latest Government Jobs, Results, Admit Cards & Exam Updates
            </div>

            <div>
                <!-- <a href="login" class="text-white text-decoration-none me-3">
                Login
            </a>

            <a href="register" class="text-white text-decoration-none">
                Register
            </a> -->
            </div>

        </div>
    </div>

    <!-- =======================
NAVBAR
======================= -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">

        <div class="container">

            <a href="<?= BASE_URL ?>" class="navbar-brand">
                <img src="<?= BASE_URL ?>admin_hub/uploads/settings/logo.webp"
                    alt="<?= htmlspecialchars($settings['site_name']) ?>" class="img-fluid navbar-logo me-2" width="45"
                    height="45">
            </a>

            <style>
            /* Custom CSS to control the size */
            .navbar-logo {
                max-height: 70px;
                /* Limits the size on desktop */
                height: auto;
                width: auto;
                object-fit: contain;
                /* Prevents stretching */
            }

            /* Optional Mobile specific adjustments */
            @media (max-width: 768px) {
                .navbar-logo {
                    max-height: 60px;
                    /* Smaller size on smaller screens */
                }
            }
            </style>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">

                <span class="navbar-toggler-icon"></span>


            </button>

            <div class="collapse navbar-collapse" id="menu">

                <ul class="navbar-nav ms-auto align-items-lg-center">

                    <li class="nav-item">
                        <a class="nav-link <?= ($activePage==BASE_URL) ? "active fw-bold text-primary" : "" ?>"
                            href="<?= BASE_URL ?>">
                            Home
                        </a>
                    </li>

                    <li class="nav-item">

                        <a class="nav-link <?= ($activePage=="job") ? "active fw-bold text-primary" : "" ?>"
                            href="<?= BASE_URL ?>job/">
                            Jobs
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?= ($activePage=="result") ? "active fw-bold text-primary" : "" ?>"
                            href="<?= BASE_URL ?>result">
                            Results
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?= ($activePage=="admit-card") ? "active fw-bold text-primary" : "" ?>"
                            href="<?= BASE_URL ?>admit-card">
                            Admit Card
                        </a>
                    </li>

                    <!-- <li class="nav-item">
                    <a href="<?= BASE_URL ?>answer-key" class="nav-link">
                        Answer Keys
                    </a>
                </li> -->

                    <!-- <li class="nav-item">
                    <a href="<?= BASE_URL ?>current-affair" class="nav-link">
                        Current Affairs
                    </a>
                </li> -->

                    <li class="nav-item">
                        <a class="nav-link <?= ($activePage=="pdf") ? "active fw-bold text-primary" : "" ?>"
                            href="<?= BASE_URL ?>pdf">
                            PDFs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>about"
                            class="nav-link <?= ($activePage=="about") ? "active fw-bold text-primary" : "" ?>">
                            About
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>contact"
                            class="nav-link <?= ($activePage=="contact") ? "active fw-bold text-primary" : "" ?>">
                            Contact us
                        </a>
                    </li>

                </ul>

            </div>

        </div>

    </nav>
</header>