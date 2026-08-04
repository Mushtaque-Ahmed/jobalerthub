<footer class="bg-dark text-white py-5">

    <div class="container">

        <div class="row">

            <div class="col-md-4">

                <h4>

                    JobAlertHub

                </h4>

                <p>

                    Latest Jobs,
                    Results,
                    Admit Cards &
                    Current Affairs.

                </p>

            </div>

            <div class="col-md-4">

                <h5>

                    Quick Links

                </h5>

                <ul class="list-unstyled">

                    <li>

                        <a href="<?= BASE_URL ?>">

                            Home

                        </a>

                    </li>

                    <li>

                        <a href="<?= BASE_URL ?>jobs/">

                            Jobs

                        </a>

                    </li>

                    <li>

                        <a href="<?= BASE_URL ?>results/">

                            Results

                        </a>

                    </li>

                </ul>

            </div>

            <div class="col-md-4">

                <h5>Follow Us</h5>

                <div class="d-flex gap-3 mt-3">

                    <?php if (!empty($settings['facebook'])): ?>
                        <a href="<?= htmlspecialchars($settings['facebook']) ?>" target="_blank" class="text-white fs-3">
                            <i class="bi bi-facebook"></i>
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($settings['instagram'])): ?>
                        <a href="<?= htmlspecialchars($settings['instagram']) ?>" target="_blank" class="text-white fs-3">
                            <i class="bi bi-instagram"></i>
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($settings['youtube'])): ?>
                        <a href="<?= htmlspecialchars($settings['youtube']) ?>" target="_blank" class="text-white fs-3">
                            <i class="bi bi-youtube"></i>
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($settings['telegram'])): ?>
                        <a href="<?= htmlspecialchars($settings['telegram']) ?>" target="_blank" class="text-white fs-3">
                            <i class="bi bi-telegram"></i>
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($settings['twitter'])): ?>
                        <a href="<?= htmlspecialchars($settings['twitter']) ?>" target="_blank" class="text-white fs-3">
                            <i class="bi bi-twitter-x"></i>
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($settings['linkedin'])): ?>
                        <a href="<?= htmlspecialchars($settings['linkedin']) ?>" target="_blank" class="text-white fs-3">
                            <i class="bi bi-linkedin"></i>
                        </a>
                    <?php endif; ?>

                </div>

            </div>

        </div>

        <hr>

        <div class="text-center">

            ©
            <?= date('Y'); ?>

            <?= htmlspecialchars($settings["site_name"] ?? "JobAlertHub") ?>

        </div>

    </div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="<?= BASE_URL ?>assets/js/app.js"></script>

</body>

</html>