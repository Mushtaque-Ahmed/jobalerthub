<?php
session_start();

if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Admin Login | JobAlertHub</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/css/login.css" rel="stylesheet">

</head>

<body>

<div class="login-wrapper">

    <div class="login-card">

        <div class="text-center mb-4">

            <!-- <img src="assets/images/logo.png" class="logo" alt="Logo"> -->

            <h3 class="mt-3">Admin Login</h3>

            <p class="text-muted mb-0">
                Sign in to continue
            </p>

        </div>

        <div id="msg"></div>

        <form id="loginForm">

            <div class="mb-3">

                <label class="form-label">
                    Email or Mobile
                </label>

                <input
                    type="text"
                    class="form-control"
                    name="username"
                    placeholder="Enter email or mobile"
                    required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Password
                </label>

                <div class="password-box">

                    <input
                        type="password"
                        class="form-control"
                        id="password"
                        name="password"
                        placeholder="Enter password"
                        required>

                    <button
                        type="button"
                        class="toggle-password"
                        id="togglePassword">

                        👁

                    </button>

                </div>

            </div>

            <button
                type="submit"
                id="loginBtn"
                class="btn btn-primary w-100">

                Login

            </button>

        </form>

    </div>

</div>

<script src="assets/js/login.js"></script>

</body>
</html>