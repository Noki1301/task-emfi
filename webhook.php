<?php
file_put_contents('webhook_raw_log.json', file_get_contents('php://input'));

$input = json_decode(file_get_contents('php://input'), true);
$tokenData = json_decode(file_get_contents('token.json'), true);

$access_token = $tokenData['access_token'];
$subdomain = 'khatamovnodir1301';


$entities = ['leads', 'contacts'];

foreach ($entities as $entity) {
	foreach (['add', 'update'] as $eventType) {
		if (isset($input[$entity][$eventType])) {
			foreach ($input[$entity][$eventType] as $item) {
				$id = $item['id'] ?? null;
				$name = $item['name'] ?? '(nomi yo‘q)';
				$user_id = $item['responsible_user_id'] ?? '(mas’ul yo‘q)';
				$timestamp = $item['updated_at'] ?? $item['created_at'] ?? time();
				$time = date('Y-m-d H:i:s', $timestamp);

				// Izoh matni
				if ($eventType == 'add') {
					$noteText = "Yangi $entity qo‘shildi\nNomi: $name\nMas’ul ID: $user_id\nSana: $time";
				} else {
					$noteText = "$entity yangilandi\nID: $id\nSana: $time";
				}

				// Note yuborish
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
			}
		}
	}
}

http_response_code(200);
echo "✅ Webhook работает.";
