<?php
// Перевіряємо, чи був надісланий запит методом POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. ПАСТКА ДЛЯ БОТІВ
    // Якщо приховане поле 'bot_check' заповнене - це 100% парсер. Просто зупиняємо скрипт.
    if (!empty($_POST['bot_check'])) {
        die("Spam blocked."); 
    }

    // 2. Очищення даних від шкідливого коду (XSS захист)
    $name = htmlspecialchars(strip_tags(trim($_POST['name'])));
    $contact_info = htmlspecialchars(strip_tags(trim($_POST['contact_info'])));
    $message = htmlspecialchars(strip_tags(trim($_POST['message'])));

    // 3. Налаштування відправки (Твоя робоча пошта в безпеці)
    $to = "gbud.digital@gmail.com"; 
    $subject = "Нова заявка з сайту DigitalBud";
    
    // Формуємо тіло листа
    $email_content = "Новий запит з сайту:\n\n";
    $email_content .= "Ім'я: $name\n";
    $email_content .= "Контакт (Email/Телефон): $contact_info\n\n";
    $email_content .= "Повідомлення:\n$message\n";

    // Технічні заголовки
    $headers = "From: noreply@gbud.digital\r\n";
    $headers .= "Reply-To: noreply@gbud.digital\r\n";
    $headers .= "Content-Type: text/plain; charset=utf-8\r\n";

    // 4. Відправка
    if (mail($to, $subject, $email_content, $headers)) {
        // У разі успіху повертаємо на сайт з повідомленням (можна замінити на сторінку "Дякуємо")
        echo "<script>alert('Заявку відправлено! Ми зв\'яжемося з вами найближчим часом.'); window.location.href='index.html';</script>";
    } else {
        echo "<script>alert('Помилка сервера. Спробуйте пізніше.'); window.location.href='index.html';</script>";
    }
} else {
    // Якщо хтось просто зайшов на send.php через адресний рядок
    echo "Доступ заборонено.";
}
?>
