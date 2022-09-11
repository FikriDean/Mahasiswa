<?php

require 'function.php';

if (isset($_POST["submit"])) {

  global $conn;

  if (registrasi($_POST) > 0) {
    echo "
              <script type=\"text/javascript\">
                alert('Username berhasil didaftarkan');
                window.location = 'index.php';
              </script>
          ";
  } else {
    echo "
                  <script type=\"text/javascript\">
                    alert('Username gagal didaftarkan');
                  </script>
              ";
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register Database</title>
  <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/jquery-ui.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>
    <?php include 'style.css'; ?>
  </style>

</head>

<body>

  <div class="container">
    <div class="header">
      <h1>Register</h1>
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
          <li>
            <label for="repassword">Re-Password</label>
            <input type="password" name="repassword" placeholder="Masukkan Ulang Password..." required>
          </li>
          <button type="submit" name="submit" id="kirim">Kirim</button>
        </ul>
      </form>

      <a href="index.php" class="kembali">Kembali</a>
    </div>
  </div>

</body>

</html>