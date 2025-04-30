<?php

if (!isset($_GET['code'])) {
	die('Authorization code not found');
}

$code = $_GET['code'];

$client_id = 'f4ef52c6-9432-49ae-bfc0-9dcb399ec15b';
$client_secret = 'K1d8zhwTUaeljYVDA6dKrO9AFbZWX8yVdIbqdctWtklYyHmmfJRs9IgKD8UrVv0N';
$redirect_uri = 'https://task-emfi-1.onrender.com/callback.php';
$subdomain = 'khatamovnodir1301';

$url = "https://{$subdomain}.amocrm.ru/oauth2/access_token";

$data = [
	'grant_type' => 'authorization_code',
	'client_id' => $client_id,
	'client_secret' => $client_secret,
	'code' => $code,
	'redirect_uri' => $redirect_uri
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

$response = curl_exec($ch);

if ($response === false) {
	die('Curl error: ' . curl_error($ch));
}

curl_close($ch);

file_put_contents('token.json', $response);

echo "Token saqlandi:<br><pre>$response</pre>";
