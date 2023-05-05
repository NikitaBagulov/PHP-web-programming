<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Получаем данные из формы и удаляем лишние пробелы и теги
$name = test_input($_POST["name"]);
$surname = test_input($_POST["surname"]);
$email = test_input($_POST["email"]);
$phone = test_input($_POST["phone"]);
$topic = test_input($_POST["topic"]);
$payment_method = test_input($_POST["payment_method"]);
$newsletter = isset($_POST["newsletter"]);

// Проверяем, что все поля заполнены
if (empty($name) || empty($surname) || empty($email) || empty($phone) || empty($topic) || empty($payment_method)) {
$error_message = "Пожалуйста, заполните все поля формы.";
} else {
// Генерируем уникальное имя файла на основе текущей даты и времени
$filename = "conference_request_" . date("Ymd_His") . ".txt";

// Сохраняем данные в файл
$data = "Имя: $name\n"
. "Фамилия: $surname\n"
. "Электронный адрес: $email\n"
. "Телефон: $phone\n"
. "Тема: $topic\n"
. "Метод оплаты: $payment_method\n"
. "Подписка на рассылку: " . ($newsletter ? "Да" : "Нет") . "\n";
if (file_put_contents($filename, $data) !== false) {
    $success_message = "Ваша заявка на участие в конференции успешно принята. <a href='admin.php'>Просмотреть заявки</a>.";
    } else {
    $error_message = "Не удалось сохранить заявку. Попробуйте еще раз.";
    }
    

}
}

// Функция для проверки введенных данных
function test_input($data) {
$data = trim($data);
$data = stripslashes($data);
$data = htmlspecialchars($data);
return $data;
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<label>Имя:</label>
<input type="text" name="name" value="<?= $name ?? '' ?>"><br>

<label>Фамилия:</label>
<input type="text" name="surname" value="<?= $surname ?? ''?>"><br>

<label>Электронный адрес:</label>
<input type="email" name="email" value="<?= $email ?? ''?>"><br>

<label>Телефон для связи:</label>
<input type="tel" name="phone" value="<?= $phone ?? ''?>"><br>

<label>Тематика конференции:</label>
<select name="topic">
<option value="<?= $topic ?? ''?>">Выберите тему</option>
<option value="Бизнес">Бизнес</option>
<option value="Технологии">Технологии</option>
<option value="Реклама и маркетинг">Реклама и маркетинг</option>
</select><br>

<label>Предпочитаемый метод оплаты:</label>
<select name="payment_method">
    
<option value="<?= $payment_method ?? ''?>"></option>
<option value="WebMoney">WebMoney</option>
<option value="Яндекс.Деньги">Яндекс.Деньги</option>
<option value="PayPal">PayPal</option>
<option value="Кредитная карта">Кредитная карта</option>
</select><br>

<label>
<input type="checkbox" name="newsletter" value="<?= $newsletter ?? ''?>">Получать рассылку о конференции
</label><br>
<input type="submit" value="Отправить">
</form>
<?php
// Выводим сообщения об ошибках или успешной отправке заявки
if (isset($error_message)) {
echo "<p style='color:red'>$error_message</p>";
}
if (isset($success_message)) {
echo "<p style='color:green'>$success_message</p>";
}
?>