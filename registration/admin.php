<?php
// Получаем список всех файлов с заявками в текущей директории
$files = glob("conference_request_*.txt");

if (count($files) == 0) {
echo "Нет заявок.";
} else {
// Отображаем таблицу со списком заявок
echo "<form method='post' action=''>";
echo "<table>";
echo "<tr><th></th><th>Дата</th><th>Имя</th><th>Фамилия</th><th>Email</th><th>Телефон</th><th>Тема</th><th>Метод оплаты</th><th>Подписка на рассылку</th></tr>";
foreach ($files as $file) {
$data = file_get_contents($file);
$lines = explode("\n", $data);
echo "<tr>";
echo "<td><input type='checkbox' name='delete[]' value='$file'></td>";
echo "<td>" . date("d.m.Y H:i:s", filemtime($file)) . "</td>";
foreach ($lines as $line) {
echo "<td>" . htmlspecialchars(trim(substr($line, strpos($line, ":") + 1))) . "</td>";
}
echo "</tr>";
}
echo "</table>";
echo "<input type='submit' value='Удалить'>";
echo "</form>";
}

// Проверяем, была ли отправлена форма на удаление заявок
if ($_SERVER["REQUEST_METHOD"] == "POST") {
if (isset($_POST["delete"])) {
$files_to_delete = $_POST["delete"];
foreach ($files_to_delete as $file) {
unlink($file);
}
}
// После удаления перезагружаем страницу для обновления списка заявок
header("Location: admin.php");
exit();
}
?>
