<?php

session_start();

$params = array(
	'client_id'     => '51631366',
	'client_secret' => 'zcdTsrGJZC1ZlG9SZ8vU',
	'code'          => $_GET['code'],
	'redirect_uri'  => 'http://registration/do_login_vk.php'
);

$data = file_get_contents('https://oauth.vk.com/access_token?' . urldecode(http_build_query($params)));
$data = json_decode($data, true);
if (!empty($data['access_token'])) {
	// Получили email
	$email = $data['email'];

	// Получим данные пользователя
	$params = array(
		'v'            => '5.81',
		'uids'         => $data['user_id'],
		'access_token' => $data['access_token'],
		'fields'       => 'photo_big',
	);

	$info = file_get_contents('https://api.vk.com/method/users.get?' . urldecode(http_build_query($params)));
	$info = json_decode($info, true);

	$_SESSION['name'] = $info["response"][0]["first_name"];
	header('Location: /');
}
