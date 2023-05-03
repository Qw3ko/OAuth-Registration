<?php

require_once '../boot.php';
require '../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// Создаем логгер 
$log = new Logger('mylogger');

// Хендлер, который будет писать логи в "mylog.log" и слушать все ошибки с уровнем "WARNING" и выше .
$log->pushHandler(new StreamHandler('../logs/app.log', Logger::WARNING));

// Проверяем наличие пользователя с указанным юзернеймом
$stmt = pdo()->prepare("SELECT * FROM `users` WHERE `username` = :username");
$stmt->execute(['username' => $_POST['username']]);
if (!$stmt->rowCount()) {
    flash('Пользователь с такими данными не зарегистрирован');
    $log->error('Ошибка входа');
    header('Location: ../login.php');
    die;
}
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Проверяем пароль
if (password_verify($_POST['password'], $user['password'])) {
    // Проверяем, не нужно ли использовать более новый алгоритм
    // или другую алгоритмическую стоимость
    // Например, если вы поменяете опции хеширования
    if (password_needs_rehash($user['password'], PASSWORD_DEFAULT)) {
        $newHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = pdo()->prepare('UPDATE `users` SET `password` = :password WHERE `username` = :username');
        $stmt->execute([
            'username' => $_POST['username'],
            'password' => $newHash,
        ]);
    }
    $_SESSION['user_id'] = $user['id'];
    header('Location: /');
    die;
}

$log->error('Ошибка входа');

flash('Пароль неверен');

header('Location: ../login.php');
