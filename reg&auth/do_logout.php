<?php

require_once '../boot.php';

$_SESSION['user_id'] = null;
$_SESSION['name'] = null;
header('Location: /');
