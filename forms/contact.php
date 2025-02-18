<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $subject = htmlspecialchars($_POST["subject"]);
    $message = htmlspecialchars($_POST["message"]);

    $mail = new PHPMailer(true);

    try {
        // Включаем отладку SMTP
        $mail->SMTPDebug = 0; // 2 - для детального вывода, 0 - отключить
        $mail->Debugoutput = 'html'; // Вывод в HTML

        // Настройки SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // SMTP-сервер Gmail
        $mail->SMTPAuth = true;
        $mail->Username = 'korchkov31012007@gmail.com'; // Твой Gmail
        $mail->Password = 'qsidmepesejqlieq'; // Пароль приложения Google (НЕ обычный пароль)
        
        // Шифрование и порт (ПРОБУЙ 587 или 465)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // STARTTLS для 587
        $mail->Port = 587; // Основной порт

        // Отключаем строгую проверку сертификатов SSL
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        // От кого и кому
        $mail->setFrom($email, $name);
        $mail->addAddress('korchkov31012007@gmail.com'); // Куда отправлять письма

        // Контент письма
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body = "Name: $name\nEmail: $email\n\nMessage:\n$message";

        // Отправляем письмо
        if ($mail->send()) {
            echo "success";
        } else {
            echo "error: " . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo "error: " . $mail->ErrorInfo;
    }
} else {
    echo "Invalid request.";
}
?>
