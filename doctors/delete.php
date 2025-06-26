<?php
include '../includes/auth.php';

$id = $_GET['id'];

$opts = [
    'http' => [
        'method' => 'DELETE',
        'header' => "Authorization: Bearer {$_SESSION['token']}"
    ]
];

$context = stream_context_create($opts);
file_get_contents("http://127.0.0.1:8000/api/admin/doctors/$id", false, $context);

header("Location: doctor.php");
exit;
