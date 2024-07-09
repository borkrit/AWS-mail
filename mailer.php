<?php
// Разрешить кросс-доменные запросы от определенного домена
header("Access-Control-Allow-Origin: https://bsm.byd.pl"); // Замените на домен вашего основного сайта
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Обработка предварительного запроса (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(204);
    exit;
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

// Получение данных из формы
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
$accept = isset($_POST['accept']) ? 'Yes' : 'No';

// Проверка обязательных полей
if (empty($name) || empty($email) || empty($message) || $accept === 'No') {
    echo json_encode(["status" => "error", "message" => "Пожалуйста, заполните все поля."]);
    exit;
}

// Формирование текста письма
$body = "Имя: $name\n";
$body .= "Email: $email\n";
$body .= "Сообщение:\n$message\n";
$body .= "Согласие на обработку данных: $accept";

// Заголовки письма
$headers = "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";

// Попытка отправки письма
if (mail("pogoriliy15@gmail.com", "Новое сообщение с формы", $body, $headers)) {
    echo json_encode(["status" => "success", "message" => "Сообщение успешно отправлено!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Произошла ошибка при отправке сообщения."]);
}
?>
