<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

// Настройки сервера
$to = "pogoriliy15@gmail.com"; // Замените на свой адрес электронной почты
$subject = "Новое сообщение с формы"; // Тема письма

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
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Попытка отправки письма
$mail_success = mail($to, $subject, $body, $headers);

if ($mail_success) {
    echo json_encode(["status" => "success", "message" => "Сообщение успешно отправлено!"]);
} else {
    $error = error_get_last();
    $error_message = isset($error['message']) ? $error['message'] : 'Неизвестная ошибка';
    // Логирование ошибки для отладки на сервере
    error_log("Ошибка отправки письма: $error_message");
    echo json_encode(["status" => "error", "message" => "Произошла ошибка при отправке сообщения: $error_message"]);
}
?>
