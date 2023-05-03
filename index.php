<?php
require_once __DIR__ . '/boot.php';

$user = null;

if (check_auth()) {
  // Получим данные пользователя по сохранённому идентификатору
  $stmt = pdo()->prepare("SELECT * FROM `users` WHERE `id` = :id");
  $stmt->execute(['id' => $_SESSION['user_id']]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Регистрация и авторизация</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
</head>

<body>

  <div class="container">
    <div class="row py-5">
      <div class="col-lg-6">

      <?php print_r($_GET['name']); ?>

        <?php if ($user) { ?>

          <h1>Добро пожаловать, <?= htmlspecialchars($user['username']) ?>!</h1>
          <h2>Ваша роль: Обычный пользователь</h2>

          <form class="mt-5" method="post" action="reg&auth/do_logout.php">
            <button type="submit" class="btn btn-primary">Выйти</button>
          </form>
          <br>

          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse non varius orci.
            In malesuada massa ut dui mollis, eu laoreet ligula finibus.
            Etiam et dui arcu. Quisque vehicula metus finibus mi tincidunt ornare.
            Integer porta commodo sapien, id viverra tellus imperdiet quis.
            Nulla nisl ligula, ornare et interdum sit amet, tempus in nisl.
            Nulla eget lobortis mi.
            Donec accumsan interdum diam, non congue nunc porttitor ac.
          </p>
        <?php } elseif (isset($_SESSION['name'])) { ?>

          <h1>Добро пожаловать, <?php print_r($_SESSION['name']) ?>!</h1>
          <h2>Ваша роль: Пользователь VK</h2>

          <form class="mt-5" method="post" action="reg&auth/do_logout.php">
            <button type="submit" class="btn btn-primary">Выйти</button>
          </form>
          <br>

          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse non varius orci.
            In malesuada massa ut dui mollis, eu laoreet ligula finibus.
            Etiam et dui arcu. Quisque vehicula metus finibus mi tincidunt ornare.
            Integer porta commodo sapien, id viverra tellus imperdiet quis.
            Nulla nisl ligula, ornare et interdum sit amet, tempus in nisl.
            Nulla eget lobortis mi.
            Donec accumsan interdum diam, non congue nunc porttitor ac.
          </p>
          <img src="img/logo.png" width="500" height="255" alt="logo">

        <?php } else { ?>

          <h1 class="mb-5">Регистрация</h1>

          <?php flash(); ?>

          <form method="post" action="reg&auth/do_register.php">
            <div class="mb-3">
              <label for="username" class="form-label">Логин</label>
              <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Пароль</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div">
              <button type="submit" class="btn btn-primary">Зарегестрироваться</button>
              <br><br>
              <a class="btn btn-outline-primary" href="login.php">Авторизоваться</a>
              <br><br>
              <?php $params = array(
                'client_id'     => '51631366',
                'redirect_uri'  => 'http://registration/do_login_vk.php',
                'response_type' => 'code',
                'v'             => '5.126',
                'scope'         => 'photos,offline',
              );
              echo '<a class="btn btn-outline-primary" href="http://oauth.vk.com/authorize?' . http_build_query($params) . '">Авторизация через ВКонтакте</a>';; ?>
            </div>
          </form>
        <?php } ?>
      </div>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>

</html>