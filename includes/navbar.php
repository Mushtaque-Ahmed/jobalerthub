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
            <a href="<?= BASE_URL ?>login" class="text-white text-decoration-none me-3">
                Login
            </a>

            <a href="<?= BASE_URL ?>register" class="text-white text-decoration-none">
                Register
            </a>
        </div>

    </div>
</div>

<!-- =======================
NAVBAR
======================= -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">

    <div class="container">

        <a href="<?= BASE_URL ?>" class="navbar-brand">

             <img src="<?= BASE_URL ?>admin_hub/uploads/settings/<?= htmlspecialchars($settings['site_logo']) ??''?>"
         alt="<?= htmlspecialchars($settings['site_name']) ?>"
         height="50"
         class="me-2">
            <span class="fw-bold fs-4">
        <?= htmlspecialchars($settings['site_name']) ?>
    </span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="menu">

            <ul class="navbar-nav ms-auto align-items-lg-center">

                <li class="nav-item">
                    <a href="<?= BASE_URL ?>" class="nav-link">
                        Home
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= BASE_URL ?>job/" class="nav-link">
                        Latest Jobs
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= BASE_URL ?>result" class="nav-link">
                        Results
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= BASE_URL ?>admit-card" class="nav-link">
                        Admit Cards
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
                    <a href="<?= BASE_URL ?>pdf" class="nav-link">
                        PDF Notes
                    </a>
                </li>

            </ul>

        </div>

    </div>

</nav>