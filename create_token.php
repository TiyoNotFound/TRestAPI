<?php

// Define the path to the JSON files storing authentication keys and usage counts
define('AUTH_KEYS_FILE', 'database/auth_keys.json');
define('USAGE_COUNTS_FILE', 'database/usage_counts.json');

// Check if the security token is provided
if (!isset($_POST['security']) || $_POST['security'] !== 'here') {
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

?>
