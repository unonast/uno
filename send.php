<?php
// Настройки вашего аккаунта amoCRM
$subdomain = 'newanna'; // Только имя вашего субдомена (без .amocrm.ru)
$accessToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjUwYTU5NDA2ZDQxOTMxMmZjZTJkNTAzZWRmY2Q0YjlmMzYwZmE2MWE0ZjgyZjIzMWFhNjFmZGE0MGJhMjJjY2YyOGE0NDcxOWQ5OTVmNGExIn0.eyJhdWQiOiI5OTg4OWRmOC0zOWRkLTQ2MDMtYTEyNC1mY2Q0NDY5N2MzMDkiLCJqdGkiOiI1MGE1OTQwNmQ0MTkzMTJmY2UyZDUwM2VkZmNkNGI5ZjM2MGZhNjFhNGY4MmYyMzFhYTYxZmRhNDBiYTIyY2NmMjhhNDQ3MTlkOTk1ZjRhMSIsImlhdCI6MTc4NzA4NTA3NSwibmJmIjoxNzg3MDg1MDc1LCJleHAiOjE3ODk1MTY4MDAsInN1YiI6IjY5NzE3NDkiLCJncmFudF90eXBlIjoiIiwiYWNjb3VudF9pZCI6MzMyMjEyMzAsImJhc2VfZG9tYWluIjoiYW1vY3JtLnJ1IiwidmVyc2lvbiI6Miwic2NvcGVzIjpbInB1c2hfbm90aWZpY2F0aW9ucyIsImZpbGVzIiwiY3JtIiwiZmlsZXNfZGVsZXRlIiwibm90aWZpY2F0aW9ucyJdLCJoYXNoX3V1aWQiOiJiN2Q4YzkzZi01Nzg4LTQ0ODQtOGYxMy02YzE4NzdkOTg3NTUiLCJhcGlfZG9tYWluIjoiYXBpLWIuYW1vY3JtLnJ1In0.UtNsezFtn6n1qPKE-jJm01eHhnnzCrp3Uz25OhaZdEVSARIIDfm1LmioG__3o3eCzHJ0CeZDxsWE_QE9egZ6n7SfzojjjSYwLa9UnyPVvztuwdU0wlPEXWUka3X5Z30Na8kGHcGgnHz8sTFjXScPrLSPAsjXWAU8FTGicLfHVc3SOXo1nnPNgnXDyDaFHh043PtQ0XNXCmQG9g2FbyJkBnw06j5j3cnbahgVZf6dbm_vyZEGBI2zuJeRLoFHSEfSeW_O5PzsLu66HVVyqzljXGnv5IICLzGSjFOfebFtF4DBQWv2Qq4DOz2U2jtlaELHxIBwz2vDm9oYhDx9BKMV7w'; // Вставьте сюда ваш длинный Access Token



// Формируем массив для отправки по методу Complex
$data = [
    [
        'name' => 'Новая заявка: ' . $name,
        'price' => (int)$price = $_POST['price'], // Принудительно приводим к числу
        '_embedded' => [
            'contacts' => [
                [
                    'first_name' =>  $name = $_POST['name'],
                    'custom_fields_values' => [
                        [
                            'field_code' => 'PHONE',
                            'values' => [
                                ['value' => $phone = $_POST['phone'], 'enum_code' => 'WORK']
                            ]
                        ],
                        [
                            'field_code' => 'EMAIL',
                            'values' => [
                                ['value' => $email = $_POST['email'], 'enum_code' => 'WORK']
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
];

// Настройка и выполнение cURL запроса
$url = "https://{$subdomain}.amocrm.ru/api/v4/leads/complex";
$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $accessToken
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Проверка результата отправки
if ($httpCode === 200 || $httpCode === 201) {
    echo "Заявка успешно создана в amoCRM!";
} else {
    echo "Произошла ошибка. Код ответа: {$httpCode}. Текст ошибки: {$response}";
}
?>
