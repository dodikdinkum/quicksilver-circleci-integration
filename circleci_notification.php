<?php

// Check environment
if (!isset($_ENV['PANTHEON_ENVIRONMENT']) || $_ENV['PANTHEON_ENVIRONMENT'] !== 'test') {
    die('Automatic tests should only be run on the Test environment');
}

// Load a secrets file
$secrets = _get_secrets('secrets.json');

// Use a curl POST request to trigger the Circle CI API action
$url  = 'https://circleci.com/api/v1/project/';
$url  = $url . $secrets['username'] . '/' . $secrets['project'] . '?circle-token=' . $secrets['token'];
$curl = curl_init($url);

// Declare request as a post and setup the fields
curl_setopt($curl, CURLOPT_POST, true);

// All parameters are optional, so we can send an empty array
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array()));

// Execute the request
$response = curl_exec($curl);

if ($response) {
    echo "Build Queued";
} else {
    echo "Build Failed";
}

/**
 * Get secrets from secrets file.
 *
 * @param string $file path within files/private that has your json
 */
function _get_secrets($file)
{
    $secrets_file = $_SERVER['HOME'] . '/files/private/' . $file;
    if (!file_exists($secrets_file)) {
        die('No secrets file found. Aborting!');
    }

    $secrets_json = file_get_contents($secrets_file);
    $secrets      = json_decode($secrets_json, 1);

    if ($secrets == false) {
        die('Could not parse json in secrets file. Aborting!');
    }
    return $secrets;
}
