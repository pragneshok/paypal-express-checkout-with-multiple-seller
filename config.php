<?php
// Set sandbox (test mode) to true/false.
$sandbox = TRUE;

// Set PayPal API version and credentials.
$api_version = '93.0';
$api_endpoint = $sandbox ? 'https://api-3t.sandbox.paypal.com/nvp' : 'https://api-3t.paypal.com/nvp';
$api_username = $sandbox ? 'SANDBOX_USERNAME_GOES_HERE' : 'LIVE_USERNAME_GOES_HERE';
$api_password = $sandbox ? 'SANDBOX_PASSWORD_GOES_HERE' : 'LIVE_PASSWORD_GOES_HERE';
$api_signature = $sandbox ? 'SANDBOX_SIGNATURE_GOES_HERE' : 'LIVE_SIGNATURE_GOES_HERE';


