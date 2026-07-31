<?php
// require_once __DIR__ . '/includes/config.php'; // or wherever BASE_URL is defined

session_start();

session_unset();
session_destroy();

header("Location: index.php");
exit;
?>