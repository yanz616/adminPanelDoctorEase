<?php
session_start();

if (isset($_SESSION['token'])) {
    $opts = [
        'http' => [
            'method' => 'POST',
            'header' => "Authorization: Bearer {$_SESSION['token']}"
        ]
    ];

    $context = stream_context_create($opts);
    @file_get_contents('http://127.0.0.1:8000/api/logout', false, $context);
}

session_destroy();  // hapus semua session

header("Location: login.php");
exit;
