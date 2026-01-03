<?php
require_once '../backend/config.php';
require_once '../backend/auth.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Invalid request method', null, 405);
}

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['email']) || !isset($input['password'])) {
    jsonResponse(false, 'Email and password are required', null, 400);
}

$auth = new Auth();
$result = $auth->login($input['email'], $input['password']);

if ($result['success']) {
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => $result['message'],
        'role' => $result['role']
    ]);
} else {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => $result['message']
    ]);
}
?>
