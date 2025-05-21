<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['consent']) && $_POST['consent'] === 'accept') {
    setcookie('cookieConsent', 'accepted', time() + 365*24*60*60, "/");
    echo json_encode(['success' => true]);
    exit;
}
echo json_encode(['success' => false]);
?>