<?php
require_once 'config.php';
require_once 'complaint_api.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

$complaintAPI = new ComplaintAPI();
$result = $complaintAPI->getComplaintDetails($_GET['id']);

echo json_encode($result);
exit;
?>
