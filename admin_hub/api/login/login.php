<?php
session_start();
header('Content-Type: application/json');

require ('../../includes/database.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request.'
    ]);
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($username == '' || $password == '') {
    echo json_encode([
        'success' => false,
        'message' => 'Please enter email/mobile and password.'
    ]);
    exit;
}

try {

    $sql = "SELECT *
            FROM users
            WHERE (email = :username OR mobile = :username)
            LIMIT 1";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':username' => $username
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {

        echo json_encode([
            'success' => false,
            'message' => 'Invalid email/mobile or password.'
        ]);
        exit;
    }

    // Status Check
    if ($user['status'] != 1) {

        echo json_encode([
            'success' => false,
            'message' => 'Your account has been disabled.'
        ]);
        exit;
    }

    // Role Check
    if ($user['role'] != 'admin') {

        echo json_encode([
            'success' => false,
            'message' => 'Access denied.'
        ]);
        exit;
    }

    // Password Verify
    if (!password_verify($password, $user['password'])) {

        echo json_encode([
            'success' => false,
            'message' => 'Invalid email/mobile or password.'
        ]);
        exit;
    }

    // Create Session
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_id'] = $user['id'];
    $_SESSION['admin_name'] = $user['name'];
    $_SESSION['admin_email'] = $user['email'];
    $_SESSION['admin_role'] = $user['role'];

    echo json_encode([
        'success' => true,
        'message' => 'Login successful.',
        'redirect' =>'dashboard.php'
    ]);

} catch (PDOException $e) {

    echo json_encode([
        'success' => false,
        'message' => 'Database error.'
    ]);
}
?>