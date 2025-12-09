<?php

$apiKey = getenv('WEATHERAPI_KEY');
$city = getenv('WEATHER_CITY');

if (!$city) {
    $city = 'London';
}

if (!$apiKey) {
    http_response_code(500);
    echo 'Не задан ключ API (переменная окружения WEATHERAPI_KEY).';
    exit;
}

$url = 'http://api.weatherapi.com/v1/current.json'
    . '?key=' . $apiKey
    . '&q=' . urlencode($city)
    . '&aqi=no';

$response = @file_get_contents($url);

if ($response === false) {
    http_response_code(502);
    echo 'Не удалось получить ответ от WeatherAPI.';
    exit;
}

$data = json_decode($response, true);

if (!is_array($data) || !isset($data['current']['temp_c'])) {
    http_response_code(502);
    echo 'Некорректный ответ от WeatherAPI.';
    exit;
}

$temp = $data['current']['temp_c'];
$condition = isset($data['current']['condition']['text']) ? $data['current']['condition']['text'] : '';
$location = isset($data['location']['name']) ? $data['location']['name'] : $city;
$country = isset($data['location']['country']) ? $data['location']['country'] : '';
$time = isset($data['location']['localtime']) ? $data['location']['localtime'] : '';

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Погода</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 400px;
            margin: 40px auto;
        }
        h1 {
            font-size: 24px;
        }
        .temp {
            font-size: 32px;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <h1>Текущая погода</h1>
    <p>Город: <?= htmlspecialchars($location) ?><?= $country ? ', ' . htmlspecialchars($country) : '' ?></p>
    <p class="temp"><?= round($temp, 1) ?> °C</p>

    <?php if ($condition): ?>
        <p>Условия: <?= htmlspecialchars($condition) ?></p>
    <?php endif; ?>

    <?php if ($time): ?>
        <p>Местное время: <?= htmlspecialchars($time) ?></p>
    <?php endif; ?>
</body>
</html>