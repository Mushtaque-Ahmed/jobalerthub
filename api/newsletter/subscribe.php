<?php

header("Content-Type:application/json");

require_once "../../includes/database.php";

$data=json_decode(file_get_contents("php://input"),true);

$email=trim($data["email"] ?? "");

if(!filter_var($email,FILTER_VALIDATE_EMAIL)){

    echo json_encode([

        "success"=>false,

        "message"=>"Invalid Email"

    ]);

    exit;

}

$stmt=$pdo->prepare("

SELECT id

FROM subscribers

WHERE email=?

LIMIT 1

");

$stmt->execute([$email]);

if($stmt->fetch()){

    echo json_encode([

        "success"=>false,

        "message"=>"Email already subscribed."

    ]);

    exit;

}

$stmt=$pdo->prepare("

INSERT INTO subscribers

(email,ip_address)

VALUES(?,?)

");

$stmt->execute([

    $email,

    $_SERVER["REMOTE_ADDR"]

]);

echo json_encode([

    "success"=>true,

    "message"=>"Thank you for subscribing."

]);?>