<?php
// Настройки вашего аккаунта amoCRM
$subdomain = 'newanna'; // Только имя вашего субдомена (без .amocrm.ru)
$accessToken = 'тут_был_токен_amo'; // Вставьте сюда ваш длинный Access Token



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
