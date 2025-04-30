<?php
// webhook.php

$input = json_decode(file_get_contents('php://input'), true);
$tokenData = json_decode(file_get_contents('token.json'), true);

$access_token = $tokenData['access_token'];
$subdomain = 'khatamovnodir1301';

$event = $input['event'];
$object = $input['object'];
$type = $object['type'];
$id = $object['id'];

if (!$type || !$id) {
	http_response_code(400);
	exit("No valid data");
}

$noteText = '';
if ($event === 'add') {
	$noteText = "Yangi $type qo‘shildi\nID: $id\nSana: " . date('Y-m-d H:i:s');
} elseif ($event === 'update') {
	$noteText = "$type yangilandi\nID: $id\nSana: " . date('Y-m-d H:i:s');
} else {
	exit('Unsupported event');
}

$entity = $type === 'contact' ? 'contacts' : 'leads';
$noteData = [
	[
		'entity_id' => $id,
		'note_type' => 'common',
		'params' => ['text' => $noteText]
	]
];

$url = "https://{$subdomain}.amocrm.ru/api/v4/{$entity}/notes";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
	"Authorization: Bearer $access_token",
	"Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($noteData));

$response = curl_exec($ch);
curl_close($ch);

file_put_contents('log.txt', "[" . date('Y-m-d H:i:s') . "]\n$response\n\n", FILE_APPEND);
http_response_code(200);
echo "✅ Webhook ishladi: $event $type ID: $id\n";
