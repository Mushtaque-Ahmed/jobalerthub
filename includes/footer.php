<footer class="bg-dark text-white py-5">

    <div class="container">

        <div class="row">

            <div class="col-md-3">

                <h4>

                    JobAdAssam

                </h4>

                <p>

                    JobAdAssam provides latest job updates, education news, results,
                    admit cards, and study materials.

                </p>

            </div>

            <div class="col-md-3">

                <h5>

                    Quick Links

                </h5>

                <ul class="list-unstyled">

                    <li>

                        <a href="<?= BASE_URL ?>" class="text-decoration-none">

                            Home

                        </a>

                    </li>

                    <li>

                        <a href="<?= BASE_URL ?>job" class="text-decoration-none">

                            Jobs

                        </a>

                    </li>

                    <li>

                        <a href="<?= BASE_URL ?>result" class="text-decoration-none">

                            Results

                        </a>

                    </li>
                    <li>
                        <a href="<?= BASE_URL ?>about" class="text-decoration-none">
                            About Us
                        </a>
                    </li>

                    <li>
                        <a href="<?= BASE_URL ?>contact" class="text-decoration-none">
                            Contact Us
                        </a>
                    </li>

                </ul>

            </div>
            <!-- Legal -->
            <div class="col-lg-3">

                <h5>Legal</h5>

                <ul class="list-unstyled">

                    <li>
                        <a href="<?= BASE_URL ?>privacy-policy" class="text-decoration-none">
                            Privacy Policy
                        </a>
                    </li>


                    <li>
                        <a href="<?= BASE_URL ?>terms-condition" class="text-decoration-none">
                            Terms & Conditions
                        </a>
                    </li>


                    <li>
                        <a href="<?= BASE_URL ?>disclaimer" class="text-decoration-none">
                            Disclaimer
                        </a>
                    </li>


                    <!-- <li>
                        <a href="refund-policy">
                            Refund Policy
                        </a>
                    </li> -->

                </ul>

            </div>







            <div class="col-lg-3">

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
            <?= htmlspecialchars($settings["site_name"] ?? "JobAdAssam") ?>

        </div>

    </div>

</footer>


<script src="<?= BASE_URL ?>assets/js/bootstrap.bundle.min.js"></script>
<script>
const BASE_URL = "<?= BASE_URL ?>";
</script>
<script src="<?= BASE_URL ?>assets/js/post-search.js"></script>
<script src="<?= BASE_URL ?>assets/js/app.js"></script>

</body>

</html>