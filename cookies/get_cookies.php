<?php
header('Content-Type: application/json');
echo json_encode([
    'cookieConsent' => isset($_COOKIE['cookieConsent']) ? $_COOKIE['cookieConsent'] : null
]);