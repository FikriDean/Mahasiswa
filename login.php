<?php

require 'function.php';

session_start();

// cek cookie
if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
  global $conn;

  $id = $_COOKIE['id'];
  $key = $_COOKIE['key'];

  // username berdasarkan id
  $result = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");
  $row = mysqli_fetch_assoc($result);

  // cek cookie dan username
  if ($key === hash('sha256', $row['username'])) {
    $_SESSION['login'] = true;
  }
}

if (isset($_SESSION["login"])) {
  header("Location: index.php");
  exit;
}

$error = false;

if (isset($_POST["submit"])) {

  global $conn;

  $username = $_POST["username"];
  $password = $_POST["password"];

  $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

  // cek ada username
  if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);

    if (password_verify($password, $row["password"])) {
      $error = false;

      $_SESSION["login"] = true;
      setcookie('id', $row['id'], time() + 60 * 10);
      setcookie('key', hash('sha256', $row['username']), time() + 60 * 10);
      setcookie('username', $row['username'], time() + 60 * 10);

      header("Location: index.php");
      exit;
    }
  }

  $error = true;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Log in Database</title>

  <!-- icon -->
  <!-- Favicon (Web Icon) -->
  <link rel="icon" href="./img/favicon.ico" type="image/ico">

  <!-- jQuery -->
  <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/jquery-ui.min.js"></script>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>
    <?php include 'style.css'; ?>
  </style>

</head>

<body>

  <div class="container">
    <div class="header">
      <h1>Log In</h1>
      <hr>
    </div>

    <div class="form">
      <form method="post" action="" enctype="multipart/form-data">
        <ul>
          <li>
            <label for="username">Username</label>
            <input type="text" name="username" placeholder="Masukkan Username..." required>
          </li>
          <li>
            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Masukkan Password..." required>
          </li>
          <?php if ($error === true) : ?>
            <li>
              <p id="error">Wrong password!</p>
            </li>
          <?php endif; ?>
          <button type="submit" name="submit" id="kirim">Log in</button>
        </ul>
      </form>
    </div>
  </div>

</body>

</html>