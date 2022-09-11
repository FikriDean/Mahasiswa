<?php
require 'function.php';

session_start();

if (!isset($_COOKIE['id']) && !isset($_COOKIE['key'])) {
  session_start();
  $_SESSION = [];
  session_unset();
  session_destroy();
}

if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

$data = select("SELECT * FROM mahasiswa");

if (isset($_POST["search"])) {
  global $data;

  $val = test_input($_POST["input-search"]);

  $data = cari($val);
}

if (isset($_GET["logout"])) {
  session_start();
  $_SESSION = [];
  session_unset();
  session_destroy();

  setcookie("id", "", time() - 3600);
  setcookie("key", "",  time() - 3600);
  setcookie("username", "",  time() - 3600);

  header("Location: login.php");
  exit;
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Database</title>

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
      <h1>Database</h1>
      <hr>
    </div>

    <div class="control">

      <form class="search" method="post" action="">
        <label for="input-search"><i class="fa-solid fa-magnifying-glass"></i></label>
        <input type="text" name="input-search" placeholder="Cari..." autofocus id="input-search">
        <button type="submit" name="search">Cari</button>
      </form>

      <div class="button">
        <a href="tambah.php"><button>Tambah Data</button></a>
        <a href="register.php"><button>Create account</button></a>
        <a href="index.php?logout=true"><button>Logout</button></a>
        <a>Hello, @<?= $_COOKIE['username'] ?></a>
      </div>

    </div>

    <div class="table" id="table">
      <div class="row" id="head">
        <div class="nomor column">
          <h3>No</h3>
        </div>
        <div class="aksi column">
          <h3>Aksi</h3>
        </div>
        <div class="gambar column">
          <h3>Gambar</h3>
        </div>
        <div class="nim column">
          <h3>NIM</h3>
        </div>
        <div class="nama column">
          <h3>Nama</h3>
        </div>
        <div class="email column">
          <h3>Email</h3>
        </div>
        <div class="jurusan column">
          <h3>Jurusan</h3>
        </div>
      </div>

      <?php $num = 1 ?>
      <?php foreach ($data as $row) :  ?>
        <div class="row">
          <div class="nomor column">
            <h3><?= $num ?></h3>
          </div>
          <div class="aksi column">
            <a href="ubah.php?id=<?php echo $row["id"] ?>"><button>Ubah</button></a>
            <a href="hapus.php?id=<?php echo $row["id"] ?>" onclick="return confirm('yakin?')"><button>Hapus</button></a>
          </div>
          <div class="gambar">
            <img src="./img/upload/<?php echo $row["gambar"] ?>" alt="gambar-profile">
          </div>
          <div class="nrp column">
            <h3><?php echo $row["nim"] ?></h3>
          </div>
          <div class="nama column">
            <h3><?php echo $row["nama"] ?></h3>
          </div>
          <div class="email column">
            <h3><?php echo $row["email"] ?></h3>
          </div>
          <div class="jurusan column">
            <h3><?php echo $row["jurusan"] ?></h3>
          </div>
        </div>
        <?php $num += 1 ?>
      <?php endforeach; ?>
    </div>

  </div>

  <!-- Font Awesome JS -->
  <script src="https://kit.fontawesome.com/abdbf7768f.js" crossorigin="anonymous"></script>

  <script src="script.js"></script>

</body>

</html>