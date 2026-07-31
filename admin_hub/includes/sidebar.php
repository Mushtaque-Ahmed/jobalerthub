<?php

$currentPage = basename($_SERVER['PHP_SELF']);
$currentFolder = basename(dirname($_SERVER['PHP_SELF']));

?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Core</div>
                    <a class="nav-link <?= ($currentPage == 'dashboard.php') ? 'active' : '' ?>"
                        href="<?= BASE_URL ?>dashboard.php">
                        <div class="sb-nav-link-icon">
                            <i class="fas fa-tachometer-alt"></i>
                        </div>
                        Dashboard
                    </a>
                    <div class="sb-sidenav-menu-heading"></div>
                    <a class="nav-link collapsed <?= ($currentFolder == 'posts') ? 'active' : '' ?>" href="#"
                        data-bs-toggle="collapse" data-bs-target="#collapseLayouts">

                        <div class="sb-nav-link-icon">
                            <i class="fas fa-columns "></i>
                        </div>

                        Posts

                        <div class="sb-sidenav-collapse-arrow">
                            <i class="fas fa-angle-down "></i>
                        </div>

                    </a>
                    <div id="collapseLayouts" class="collapse <?= ($currentFolder == 'posts') ? 'show' : '' ?>"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link <?= ($currentPage == 'index.php' && $currentFolder == 'posts') ? 'active' : '' ?>"
                                href="<?= BASE_URL ?>posts/index.php">
                                View Post
                            </a>
                            <a class="nav-link <?= ($currentPage == 'create.php' && $currentFolder == 'posts') ? 'active' : '' ?>"
                                href="<?= BASE_URL ?>posts/create.php">
                                Create Post
                            </a>
                            <a class="nav-link <?= ($currentPage == 'category.php' && $currentFolder == 'posts') ? 'active' : '' ?>"
                                href="<?= BASE_URL ?>posts/category.php">
                                Category
                            </a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed <?= ($currentFolder == 'pdf') ? 'active' : '' ?>" href="#"
                        data-bs-toggle="collapse" data-bs-target="#collapsepdf" aria-expanded="false"
                        aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        PDF
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div id="collapsepdf" class="collapse <?= ($currentFolder == 'pdf') ? 'show' : '' ?>"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link <?= ($currentPage == 'index.php' && $currentFolder == 'pdf') ? 'active' : '' ?>"
                                href="<?= BASE_URL ?>pdf/index.php">
                                View PDF
                            </a>

                            <a class="nav-link <?= ($currentPage == 'create.php' && $currentFolder == 'pdf') ? 'active' : '' ?>"
                                href="<?= BASE_URL ?>pdf/create.php">
                                Create PDF
                            </a>

                            <a class="nav-link <?= ($currentPage == 'edit.php' && $currentFolder == 'pdf') ? 'active' : '' ?>"
                                href="#">
                                Edit PDF
                            </a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed <?= ($currentFolder == 'settings') ? 'active' : '' ?>" href="#"
                        data-bs-toggle="collapse" data-bs-target="#settings" aria-expanded="false"
                        aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Settings
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div id="settings" class="collapse <?= ($currentFolder == 'settings') ? 'show' : '' ?>"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link <?= ($currentPage == 'create.php' && $currentFolder == 'settings') ? 'active' : '' ?>"
                                href="<?= BASE_URL ?>settings/create.php">
                                Settings
                            </a>

                        </nav>
                    </div>


                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                <?= htmlspecialchars($_SESSION['admin_role']) ?>
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">