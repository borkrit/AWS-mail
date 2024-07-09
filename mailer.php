<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *"); // Разрешаем кросс-доменные запросы

// Подключение PHPMailer
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

// Создание экземпляра PHPMailer
$mail = new PHPMailer(true);

try {
    // Настройки сервера
    $mail->isSMTP();
    $mail->Host = 'smtp.example.com'; // Укажите SMTP-сервер вашего провайдера
    $mail->SMTPAuth = true;
    $mail->Username = 'your_email@example.com'; // Ваш SMTP логин
    $mail->Password = 'your_email_password'; // Ваш SMTP пароль
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Получатели
    $mail->setFrom($email, $name);
    $mail->addAddress('pogoriliy15@gmail.com'); // Добавление получателя

    // Содержание письма
    $mail->isHTML(false);
    $mail->Subject = 'Новое сообщение с формы';
    $mail->Body    = "Имя: $name\nEmail: $email\nСообщение:\n$message\nСогласие на обработку данных: $accept";

    // Отправка письма
    $mail->send();
    echo json_encode(["status" => "success", "message" => "Сообщение успешно отправлено!"]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Произошла ошибка при отправке сообщения: {$mail->ErrorInfo}"]);
}
?>
