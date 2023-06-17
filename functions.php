<?php 

require 'config.php';

function chatgpt($prompt) {
    global $api_key;
    $url = 'https://api.openai.com/v1/chat/completions';

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $api_key,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            [
                'role' => 'user',
                'content' => $prompt,
            ]
        ],
    ]));

    $result = curl_exec($ch);

    curl_close($ch);

    $answer = json_decode($result, true);

    if (isset($answer['error'])) {
        return $answer['error']['message'];
    }

    return $answer['choices'][0]['message']['content'];

   /*  if (isset($answer['choices'][0]['text'])) {
        return $answer['choices'][0]['text'];
    } else {
        return "Не удалось получить идеи.";
    }  */
} 

function generateImage($prompt, $size = '256x256') {
    global $api_key;
    $url = 'https://api.openai.com/v1/images/generations';

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $api_key,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'prompt' => $prompt,
        'size' => $size,
    ]));

    $result = curl_exec($ch);

    curl_close($ch);

    $answer = json_decode($result, true);

    if (isset($answer['error'])) {
        return $answer['error']['message'];
    }

    return $answer['data'][0]['url'];
}



/* function generateImage($prompt) {
    global $api_key;
    $url = 'https://api.openai.com/v1/images/generations'; 

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $api_key,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'prompt' => $prompt,
    ]));

    $result = curl_exec($ch);

    curl_close($ch);

    $image = json_decode($result, true);

    if (isset($image['url'])) {
        return $image['url'];
    } else {
        return null;
    }
} */

