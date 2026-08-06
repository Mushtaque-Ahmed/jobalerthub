<?php

header("Content-Type: application/json");

require_once __DIR__ . "/../../admin_hub/includes/database.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . "/../../vendor/src/Exception.php";
require_once __DIR__ . "/../../vendor/src/PHPMailer.php";
require_once __DIR__ . "/../../vendor/src/SMTP.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    echo json_encode([
        "success" => false,
        "message" => "Invalid request."
    ]);

    exit;

}

/* ==========================================
    INPUT
========================================== */

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$subject = trim($_POST["subject"] ?? "");
$message = trim($_POST["message"] ?? "");

/* ==========================================
    VALIDATION
========================================== */

if ($name == "" || $email == "" || $subject == "" || $message == "") {

    echo json_encode([
        "success" => false,
        "message" => "Please fill in all required fields."
    ]);

    exit;

}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    echo json_encode([
        "success" => false,
        "message" => "Invalid email address."
    ]);

    exit;

}

if (strlen($message) < 10) {

    echo json_encode([
        "success" => false,
        "message" => "Message is too short."
    ]);

    exit;

}

/* ==========================================
    SECURITY
========================================== */

$name = htmlspecialchars($name, ENT_QUOTES);
$subject = htmlspecialchars($subject, ENT_QUOTES);

$ip = $_SERVER["REMOTE_ADDR"] ?? "";

$userAgent = $_SERVER["HTTP_USER_AGENT"] ?? "";

/* ==========================================
    SAVE DATABASE
========================================== */

try {

    $stmt = $pdo->prepare("
        INSERT INTO contact_messages
        (
            name,
            email,
            subject,
            message,
            ip_address,
            user_agent
        )
        VALUES
        (
            ?,
            ?,
            ?,
            ?,
            ?,
            ?
        )
    ");

    $stmt->execute([
        $name,
        $email,
        $subject,
        $message,
        $ip,
        $userAgent
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => "Database error."
    ]);

    exit;

}

/* ==========================================
    SEND EMAIL
========================================== */

try {

    $mail = new PHPMailer(true);

    $mail->isSMTP();

    $mail->Host = "smtp.gmail.com";

    $mail->SMTPAuth = true;

    $mail->Username = "waiz783111@gmail.com";

    $mail->Password = "abnp wfmo jqun lqal";

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

    $mail->Port = 587;

    $mail->setFrom("waiz783111@gmail.com", "JobAdAssam");

    $mail->addAddress("waiz783111@gmail.com");

    $mail->addReplyTo($email, $name);

    $mail->isHTML(true);

    $mail->Subject = "New Contact Message - " . $subject;

    $mail->Body = "

        <h2>New Contact Message</h2>

        <table cellpadding='8' cellspacing='0' border='1'>

            <tr>

                <td><strong>Name</strong></td>

                <td>{$name}</td>

            </tr>

            <tr>

                <td><strong>Email</strong></td>

                <td>{$email}</td>

            </tr>

            <tr>

                <td><strong>Subject</strong></td>

                <td>{$subject}</td>

            </tr>

            <tr>

                <td><strong>Message</strong></td>

                <td>" . nl2br(htmlspecialchars($message)) . "</td>

            </tr>

            <tr>

                <td><strong>IP Address</strong></td>

                <td>{$ip}</td>

            </tr>

            <tr>

                <td><strong>Browser</strong></td>

                <td>{$userAgent}</td>

            </tr>

        </table>

    ";

    $mail->send();

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "message" => "Saved successfully, but email could not be sent."
    ]);

    exit;

}

/* ==========================================
    RESPONSE
========================================== */

echo json_encode([
    "success" => true,
    "message" => "Thank you! Your message has been sent successfully."
]);?>