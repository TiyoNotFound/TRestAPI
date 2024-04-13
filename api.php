<?php

// Define the path to the JSON files storing authentication keys and usage counts
define('AUTH_KEYS_FILE', 'database/auth_keys.json');
define('USAGE_COUNTS_FILE', 'database/usage_counts.json');

// Check if the token is provided in the request
if (!isset($_GET['token'])) {
    http_response_code(400);
    echo json_encode(array('error' => 'Token not provided'));
    exit;
}

$token = $_GET['token'];
if (!isValidToken($token)) {
    http_response_code(403);
    echo json_encode(array('error' => 'Unauthorized'));
    exit;
}

// If the token is valid, echo a success message indicating that the token is valid
$limit = getLimit($token);
echo "Token is valid. Usage limit: $limit";

// Function to validate the token against the authentication keys
function isValidToken($token) {
    // Read the authentication keys from the JSON file
    $authKeys = json_decode(file_get_contents(AUTH_KEYS_FILE), true);

    // Check if the token exists in the authentication keys
    return isset($authKeys['tokens'][$token]);
}

// Function to get the usage limit of a token
function getLimit($token) {
    // Read the usage counts from the JSON file
    $usageCounts = json_decode(file_get_contents(USAGE_COUNTS_FILE), true);

    // Initialize the usage count if the token is not found
    if (!isset($usageCounts[$token])) {
        $usageCounts[$token] = 0;
        file_put_contents(USAGE_COUNTS_FILE, json_encode($usageCounts));
    }

    // Read the authentication keys from the JSON file
    $authKeys = json_decode(file_get_contents(AUTH_KEYS_FILE), true);

    // Check if the token exists in the authentication keys and return its limit
    return isset($authKeys['tokens'][$token]) ? $authKeys['tokens'][$token] : 'Unknown';
}

?>
