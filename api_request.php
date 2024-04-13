<?php

// Define the security token
$securityToken = 'supersecretkey123';

// Define the path to the JSON file storing authentication keys
define('AUTH_KEYS_FILE', 'database/auth_keys.json');
define('USAGE_COUNTS_FILE', 'database/usage_counts.json');


// Check if the request is made to the /tokens endpoint with the correct security key
if (strpos($_SERVER['REQUEST_URI'], '/api_request.php/tokens') !== false && isset($_GET['security']) && $_GET['security'] === $securityToken) {
    // Check if the request method is GET
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Read the authentication keys from the JSON file and return them
        $authKeys = json_decode(file_get_contents(AUTH_KEYS_FILE), true);
        // Instead of echoing, return the JSON data
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode($authKeys, JSON_PRETTY_PRINT);
        exit;
    } else {
        // Method not allowed for other HTTP methods
        http_response_code(405);
        header('Content-Type: application/json');
        echo json_encode(array('error' => 'Method Not Allowed'));
        exit;
    }
} elseif ($_SERVER['REQUEST_URI'] === '/api_request.php/createtoken' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the security token is provided
    if (!isset($_POST['security']) || $_POST['security'] !== $securityToken) {
        http_response_code(403);
        echo json_encode(array('error' => 'Unauthorized'));
        exit;
    }

    // Check if the token is provided in the POST request
    if (!isset($_POST['token'])) {
        http_response_code(400);
        echo json_encode(array('error' => 'Token not provided'));
        exit;
    }

    $token = $_POST['token'];
    $limit = isset($_POST['limit']) ? intval($_POST['limit']) : 1; // Default limit is 1 if not provided

    // Read existing authentication keys from the JSON file
    $authKeys = json_decode(file_get_contents(AUTH_KEYS_FILE), true);

    // Add the new token with its limit to the authentication keys
    $authKeys['tokens'][$token] = true;

    // Write the updated authentication keys back to the JSON file
    file_put_contents(AUTH_KEYS_FILE, json_encode($authKeys, JSON_PRETTY_PRINT));

    // Initialize usage counts for the new token
    $usageCounts = json_decode(file_get_contents(USAGE_COUNTS_FILE), true);
    $usageCounts[$token] = 0; // Initialize usage count to 0
    file_put_contents(USAGE_COUNTS_FILE, json_encode($usageCounts, JSON_PRETTY_PRINT));

    echo 'Token successfully created';
    exit;
} else {
    // Invalid endpoint or method
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(array('error' => 'Endpoint Not Found'));
    exit;
}

?>
